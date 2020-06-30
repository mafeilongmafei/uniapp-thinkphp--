<template>
	<view class="content">
		<view class="header_title">
			<view class="iconfont icon-fanhui1" @touchstart="Backnav">

			</view>
			<view class="quName">
				{{nickname}}
			</view>
		</view>


		<scroll-view scroll-y="true" class="main_content" :scroll-top="scrollTop">
			<view class="main_scroll">
				<view class="item_content" v-for="(item , index) in UserMsg" :key="index">
					<view class="user_date" v-if="item.from && item.from.date " >{{item.from.date | parseTime}}</view>
					<view class="userCount">
						<!-- <view class="user_date">{{item.from.date}}</view> -->
						<view class="leftUser userMsg" v-if="item.from">
							<image mode="scaleToFill" :src="item.from.avatarUrl"></image>
							<view>{{item.from.msg}}</view>
						</view>
						<view class="RightUser clearFix" v-if="item.to">
							<view class="user_date" v-if="item.to && item.to.date ">{{item.to.date | parseTime}}</view>
							<view class="you">
								<view>{{item.to.msg}}</view>
								<image mode="scaleToFill" :src="item.to.avatarUrl"></image>
							</view>

						</view>
					</view> 
				</view>
			</view>
		</scroll-view>

		<view class="footer centerW">
			<view class="leftFooter centerW">
				<view class="iconfont icon-yuyin">

				</view>
			</view>
			<!-- <view class="contentUser centerW" >按住说话</view> -->

			<input type="text" value="" class="contentUser" v-model="msg" @confirm="fa" />
			<view class="rightFooter centerW">
				<!-- <view class="iconfont icon-biaoqing-xue"></view>
				<view class="iconfont icon-jia"></view> -->
				<view class="btn" @touchstart="fa">
					发送
				</view>
			</view>
		</view>
	</view>
</template>


<script>
	import {
		tomsg
	} from "../../request/api.js"
	import {
		mapState
	} from "vuex"
	import {
		getElement,
		isToken
	} from "../../util/common.js"
	let timer = 0;
	let isAddDate  = 0; //在这个时间段不添加时间
	export default {
		data() {
			return {
				id: null,
				nickname: "",
				msg: "",
				UserMsg: [],
				scrollTop: 0, //scroll-view 高度
				curPath : ""
				// msg  : [
				// 	{
				// 		to : [],
				// 		from :[]
				// 	}
				// ]
			}
		},
		mixins: [isToken],
		computed: {
			...mapState(["user", "toekn"]),

		},
		created() {
			this.curPath = this.$route.fullPath
		},
		onLoad(options) {
			let {
				id,
				nickname
			} = options;
			this.id = id
			this.nickname = nickname
			// 自己和他人的id
			let key = this.user.id + "" + this.id + "user"
			let user = uni.getStorageSync(key) || [];
			this.UserMsg = user
			this.setScrollTop()


			uni.$on("msg", (data) => {
				this.UserMsg = data
				this.setScrollTop()
			})

		},
		onShow() {
			let path = this.$route.fullPath
			// 两次进入的页面不同
			if(path != this.curPath) {
				// 重新初始化是否添加date
				isAddDate  = 0;
			}
		},
		methods: {
			Backnav() {
				uni.switchTab({
					url: "../chat/chat"
				})
			},
			// 设置scroll-view的top值
			setScrollTop() {
				this.$nextTick(() => {
					let query = uni.createSelectorQuery()
					query.select(".main_content").boundingClientRect();
					query.select(".main_scroll").boundingClientRect();
					query.exec(res => {
						let ConHeight = res[0].height
						let scrolHeight = res[1].height
						if (ConHeight < scrolHeight) {
							this.scrollTop = scrolHeight - ConHeight
						}
					})
				})
			},
			editDate() {
				timer = setInterval(()=>{
					if(isAddDate < 0) {
						clearInterval(timer)
					}
					isAddDate--
				} , 1000) 
				
			},

			fa() {
				
				let date = Date.now()
				let msg = this.msg
				let key = this.user.id + "" + this.id + "user";
				let store = this.$store
				if(isAddDate > 0) {
					date = undefined	
				}else {
					isAddDate = 60
				}
				if (this.msg) {
					let fromId =  this.user.id - 0;
					tomsg({
						type: "toMsg",
						msg,
						// 向谁发的id
						touid: this.id - 0,
						date,
						// 发的人的id
						fromId


					})
					let user = uni.getStorageSync(key) || [];
					user.push({
						to: {
							// 发的人的id
							fromId,
							nickname: this.user.nickname,
							avatarUrl: this.user.avatarUrl,
							msg,
							date

						}
					})
					this.UserMsg = user
					this.setScrollTop()
					uni.setStorageSync(key, user)
					this.msg = ""
					// 开始计数
					clearInterval(timer)
					this.editDate()

				}
			}
		}
	}
</script>



<style scoped lang="scss">
	@import "./index.scss"
</style>
