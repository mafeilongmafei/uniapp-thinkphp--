<template name="search">
	<navigator class="content" :url="toUrl">
			<text class="iconfont icon-sousuo"></text>
			<text>搜索商品,发现更多优惠</text>
	</navigator>
</template>

<script>
	export default {
		name: "search",
		props: {
			toUrl : {
				type : String,
				default : ""
			}
		},
	}
</script>

<style scoped lang="scss" scoped>
	// 全局的css可以影响到组件的
	.content {
		/*#ifdef MP  */
		margin: 20rpx 30rpx 0 30rpx;
		/* #endif */
		height: 56upx;
		background-color: #fff;
		border-radius: 10upx;
		display: flex;
		align-items: center;
		justify-content: center;
		text:first-child {
			font-size: 36upx;
		}
		text {
			font-size: 28upx;
			color : #8e827b;
		}
		
	}
	
</style>
