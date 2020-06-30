
<template>
	<view class="userContainer">
			<view class="service">
				<view class="service_item" v-for="item in oauth" :key="item.name" >
					<image :src="item.avatar" mode="scaleToFill" @click="login(item.y)"></image>
					<view>{{item.name}}</view>
				</view>
				
			</view>
		
	</view>
</template>

<script>
	import { service } from "../../util/enum.js"  
	import {  UserRegistered} from "../../request/api.js"
	import { SETUSERINFO , SETTOKEN } from "../../store/mutations-type.js"
	import socket from "../../request/socket.js"
	export default {
		data() {
			return {
				oauth : [] //服务商列表
			}
		},
		mounted() {
			uni.getProvider({
				service : 'oauth',
				success : (res)=>{
					let { provider } = res
 					provider.forEach(item=>{
						if(service[item]) {this.oauth.push(service[item])}
					})
				}
			})
		},
		methods: {
			login(au) {
				uni.showLoading({
					title: "加载中"
				})
				uni.login({
					provider : au,
					success(res) {
						uni.hideLoading();
						uni.getUserInfo({
							provider : au,
							success: async (infoRes)=>{
								let { userInfo } = infoRes;
									let user = await UserRegistered({
										identity_type : au,
										identitfier : userInfo.openId,
										avatarUrl : userInfo.avatarUrl,
										nickname : userInfo.nickname
									})
								this.userInfo =user.fid ||  user
								uni.setStorageSync("userInfo", this.userInfo)
								uni.setStorageSync("token", user.token)
								this.$store.commit(SETUSERINFO ,  this.userInfo)
								this.$store.commit(SETTOKEN , user.token)
								// 登录后进行初始化
								socket.init();
								uni.switchTab({
									url: "../my/my"
								})
								
							},
							fail() {
								uni.showToast({
									title: "获取用户信息失败",
									icon : none
								})
							}
						})
					},
					fail(err) {
							uni.showToast({
								title: "登录失败",
								icon : none
							})
					}
					
				})
			}
			
		}
	}
</script>

<style lang="scss" scoped>
	.userContainer {
		margin-top: 30px;
	}
	.service {
		display: flex;
		justify-content: center;
		.service_item {
			margin: 0 20upx;
			display: flex;
			flex-direction: column;
			align-items: center;
			image {
				width: 120upx;
				height: 120upx;
				border-radius: 50%;
			}
		}
	}
	
	.action-row {
		display: flex;
		flex-direction: row;
		justify-content: center;
	}
	
	.action-row navigator {
		color: #007aff;
		padding: 0 10px;
	}
	
	.oauth-row {
		display: flex;
		flex-direction: row;
		justify-content: center;
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
	}
	
	.oauth-image {
		position: relative;
		width: 50px;
		height: 50px;
		border: 1px solid #dddddd;
		border-radius: 50px;
		margin: 0 20px;
		background-color: #ffffff;
	}
	
	.oauth-image image {
		width: 30px;
		height: 30px;
		margin: 10px;
	}
	
	.oauth-image button {
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		opacity: 0;
	}

</style>
