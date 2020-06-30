<template>
	<view class="userContainer">
		<!-- #ifdef APP-PLUS -->
		<view class="login" @click="navto" v-if="!userInfo.id">其他登录方式</view>
		<!-- #endif -->
		<!-- #ifdef MP -->
		<button @getuserinfo="getUserInfo" open-type="getUserInfo" type="primary" v-if="!userInfo.avatarUrl">授权</button>
		<!-- #endif -->
		<!-- #ifdef H5 || APP-PLUS -->
		<view class="loginHome" v-if="!userInfo.id">
			<view class="user">
				<view class="username inp" v-if="!isLogin">
					<text>昵称:</text>
					<input type="text" placeholder="请输入昵称" focus v-model="nickname" class="input">
				</view>
				<view class="username inp">
					<text>账号:</text>
					<input type="text" placeholder="请输入邮箱" focus v-model="email" class="input">
					
				</view>
				<view class="username inp" v-if="!isLogin">
					<text>验证码:</text>
					<input type="text" placeholder="请输入验证码" focus v-model="code" class="input">
					
					<view :class="isToEmail ? 'toEmail' : 'yiEmail toEmail' " @click="toEmail">{{ isToEmail ? '('+time+')' : '发送验证码'}}</view>
				</view>
				<view class="userPassword inp">
					<text>密码:</text>
					<input type="text" :password="ispass" placeholder="请输入密码" v-model="password" class="input">
					<view :class="ispass ? 'iconfont icon-yanjing' : 'iconfont icon-yanjing yanjingBg'" @click="ispass = !ispass">

					</view>
				</view>
			</view>
			<view class="login_bottom" >
				<button type="primary" @click="getUserInfo">{{isLogin ? "登录" : "注册"}}</button>
				<view class="switchStatus">
					<text @click="isLogin = !isLogin">{{! isLogin ? "登录账号" : "注册账号"}}</text>
					<text>|</text>
					<text @click="findBack">忘记密码</text>
				</view>
			</view>
		</view>

		<!-- #endif -->
		<view class="userInfo">
			<image :src="userInfo.avatarUrl" mode="scaleToFill"></image>
			<text>{{userInfo.name || userInfo.nickname}}</text>
		</view>
	</view>
</template>

<script>
	import Http from "../../request/request.js"
	import config from "../../util/config.js"
	import { UserLogin , UserRegistered , toUserEmail } from "../../request/api.js"
	import { mapMutations } from "vuex"
	import { SETUSERINFO , SETTOKEN } from "../../store/mutations-type.js"
	// 登录类型
	let identity_type = "email";
	let on = true; //
	import socket from "../../request/socket.js"
	
	export default {
		data() {
			return {
				userInfo: {},
				email: "",
				nickname : "",
				code : "",
				password: "",
				ispass: true, //是否是密码
				isLogin: true, //登录还是注册
				isToEmail : false, //是否允许验证码
				time : 60, //发送时间倒计时
			}
		},
		created() {
			let userInfo = uni.getStorageSync("userInfo")
			this.userInfo = userInfo
			// #ifdef MP
			wx.checkSession({
				success() {
					//session_key 未过期，并且在本生命周期一直有效
					// session_key用来解密手机号的之类数据
				},
				fail: () => {
					// session_key 已经失效，需要重新执行登录流程
					uni.showToast({
						title: "请重新登录",
						icon: "none",
						success: () => {
							this.userInfo = {}
							this.$store.commit(SETUSERINFO , {})
							this.$store.commit(SETTOKEN , {})
							wx.setStorageSync("userInfo", {})
							wx.setStorageSync("token", {})
						}
					})
				}
			})
			// #endif
		},
		methods: {
			navto(){
				uni.navigateTo({
					url: "../login/login"
				})
			},
			async getUserInfo(wu) {
				// #ifdef MP-WEIXIN
				let {
					detail
				} = wu
				if (!detail.userInfo) return uni.showToast({
					title: "登录失败",
					icon: "none"
				})
				uni.login({
					success: async (res) => {
						if (res.code) {
							let data = await Http({
								url: `https://api.weixin.qq.com/sns/jscode2session?appid=${config.appid}&secret=${config.secret}&js_code=${res.code}&grant_type=authorization_code`,
							})
							let user = await UserRegistered({
								identity_type : "weixinxiaochengxu",
								identitfier : data.openid,
								avatarUrl : detail.userInfo.avatarUrl,
								nickname : detail.userInfo.nickName
							})
							
							this.userInfo =user.fid ||  user
							this.$store.commit(SETUSERINFO , this.userInfo)
							this.$store.commit(SETTOKEN , this.token)
							uni.setStorageSync("userInfo", this.userInfo)
							uni.setStorageSync("token", user.token)
						}
					}
				})
				// #endif
				// #ifdef H5 || APP-PLUS
				if (this.password.length < 6) {
					uni.showToast({
						icon: 'none',
						title: '密码最短为 6 个字符'
					});
					return;
				}
				if (this.email.length < 3 || !~this.email.indexOf('@')) {
					uni.showToast({
						icon: 'none',
						title: '邮箱地址不合法'
					});
					return;
				}
				let data = {
						identitfier : this.email,
						creadential : this.password,
						identity_type,
						nickname : this.nickname
					}
				if(this.isLogin) {
					try {
						let res = await UserLogin(data)
					}catch(e) {
						console.log(e)
					}
					this.userInfo = res.fid
					uni.setStorageSync("userInfo", this.userInfo)
					uni.setStorageSync("token", res.token)
					this.$store.commit(SETUSERINFO , this.userInfo)
					this.$store.commit(SETTOKEN , res.token)
				}else {
					data.code = this.code;
					let user = await UserRegistered(data)
					this.isLogin = true
				}
				// #endif
				// 登录后进行初始化
				this.isLogin ? socket.init() : ""
			},
			// 找回密码
			findBack() {
				uni.navigateTo({
					url: "../findBack/findBack?email=" + this.email
				})
			},
			//发送验证码
			toEmail(){
				// 开启定时器
				if(on) {
					// 关闭
					on = false
					this.isToEmail = true;
					let timer = setInterval(()=>{
						if(this.time == 0) {
							clearInterval(timer);
							on = true
							this.isToEmail = false
							this.time = 60;
						}
						this.time --
					} , 1000)
					toUserEmail({
						identitfier : this.email
					})
					
					
					
				}
				
				
			}
			
		}

	}
</script>

<style lang="scss" scoped>
	@import "./index.scss"
</style>
