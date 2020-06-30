<template>
	<view class="chatContainer">
		<view class="status_bar bgc"></view>
		<view class="header">
			<text>微信(77)</text>
			<view class="header_right">
				<view class="iconfont icon-sousuo"></view>
				<view class="iconfont icon-tianjia"></view>
			</view>
		</view>
		<scroll-view class="chatList" scroll-y="true">
			<view class="chat_item" v-for="item in userArr" :key="item.nickname" @touchstart="navChatDetail(item.id , item.nickname)">
				<view class="useravatar">
					<image :src="item.avatarUrl" mode="scaleToFill"></image>
					<view class="img_bage" v-if="!item.isShow">
						
					</view>
				</view>
				<view class="userInfo">
					<view class="infocontent">
						<view class="userName">
							{{item.nickname}}
						</view>
						<view class="userChat">{{item.msg}}</view>


					</view>
					<view class="userDate" v-if="item.date">
						{{item.date |  parseTime}}
					</view>


				</view>

			</view>

		</scroll-view>

	</view>
</template>

<script>
	import  { mapState } from "vuex"
	import {  isToken , edituserArr } from "../../util/common.js"
	import {
		getOnlineUser,
		
	} from "../../request/api.js"
	export default {
		computed: {
			...mapState(['userArr'])
		},
		 mixins:[isToken ,edituserArr]
	}
</script>

<style lang="scss" scoped>
	@import "./index.scss"
</style>
