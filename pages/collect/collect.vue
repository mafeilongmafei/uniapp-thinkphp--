<template>
	<view class="content">
		<view class="litiantitle">通讯录</view>
		<div class="user_item" v-for="item in Alluser" :key="item.nickname" @touchstart="navChatDetail(item.id , item.nickname)">
			<image :src="item.avatarUrl" mode="scaleToFill"></image>
			<text>{{item.nickname}}</text>
		</div>

	</view>
</template>


<script>
	import {
		getOnlineUser
	} from "../../request/api.js"
	import {
		isToken,
		edituserArr
	} from "../../util/common.js"
	import {
		mapState
	} from "vuex"
	export default {
		data() {
			return {
				Alluser: []
			}
		},
		mixins: [isToken, edituserArr],
		mounted() {
			this.getONline();
		},
		computed: {
			...mapState(['userArr'])
		},
		onLoad() {
			uni.$on("OnlineUser", () => {
				this.getONline();
			})
		},
		methods: {
			//获取在线所有用户
			async getONline() {
				let data = await getOnlineUser();
				this.Alluser = data;
			}
		},

	}
</script>


<style lang="scss" scoped>
	.content {
		width: 100%;

		.user_item {
			width: 100%;
			height: 120rpx;
			display: flex;
			justify-content: space-around;
			align-items: center;
			border-bottom: 1rpx solid #ccc;

			image {
				width: 80rpx;
				height: 80rpx;
				border-radius: 50%;
			}
		}

		.litiantitle {
			height: 60rpx;
			font-size: 38rpx;
			font-weight: 600;
			line-height: 60rpx;
			text-align: center;
			border-bottom: 1rpx solid #ccc;
		}
	}
</style>
