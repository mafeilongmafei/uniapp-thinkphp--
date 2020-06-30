<template name="lineV">
	<view class="split-line">
		<view class="line"></view>
		<view class="text">{{content}}</view>
		<view class="line"></view>
	</view>
</template>

<script>
	export default {
		name : "lineV",
		props: {
			content : {
				type : String,
				default : ""
			}
		}
	}
</script>

<style  lang="scss" scoped>
	.split-line {
		display: flex;
		justify-content: center;
		align-items: center;
		height: 100upx;
		width: 100%;
		.line {
			height: 2upx;
			width: 90upx;
			background-color: #fdde4a;
			margin-right: 40upx;
		}
		view:last-child {
			margin-left: 40upx;
			margin-right: 0;
		}
		.text {
			font-size: 28upx;
			color: hsla(21,8%,49%,.7);
			position: relative;
			&::before {
				content: "";
				position: absolute;
				width: 18upx;
				height: 18upx;
				background-color: #fdde4a;
				transform: rotate(45deg);
				left: -36upx;
				top: 50%;
				margin-top: -9upx;
			}
			&::after {
				
					content: "";
					position: absolute;
					width: 18upx;
					height: 18upx;
					background-color: #fdde4a;
					transform: rotate(45deg);
					right: -36upx;
					top: 50%;
					margin-top: -9upx;
				
			}
		}
		
	}
</style>
