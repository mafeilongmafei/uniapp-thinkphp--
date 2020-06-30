<template name="arrow">
	<view class="arrow" @click="backTo">
		<text class="iconfont icon-fanhui"></text>
	</view>
</template>

<script>
	export default {
		name: "arrow",
		props: {
			url : {
				type : String,
				default : ""
			}
		},
		methods: {
			backTo() {
				uni.switchTab({
					url: this.url,
				})
			}
		}
	}
</script>

<style lang="scss">
	
	.arrow {
		display: flex;
		top: 30upx;
		left: 30upx;
		justify-content: center;
		align-items: center;
		position: fixed;
		z-index: 5;
		width: 80upx;
		height: 80upx;
		border-radius: 50%;
		background-color: rgba(0,0,0,.5);
		
		.icon-fanhui {
			color: #FFFFFF;
			font-size: 36upx;
		}
	}
	
</style>
