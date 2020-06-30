<template>
	<view class="backContainer">
		<view class="backContent">
			<view class="userEmail">
				<text>邮箱:</text>
				<input type="text" v-model="email" focus placeholder="请输入邮箱" class="input">
			</view>
			<button type="primary" class="btn" @click="sub">提交</button>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				email : ""
			};
		},
		onLoad(options) {
			let {email } = options
			this.email = email
			
		},
		methods: {
			// 提交
			sub() {
				if (this.email.length < 3 || !~this.email.indexOf('@')) {
					uni.showToast({
						icon: 'none',
						title: '邮箱地址不合法'
					});
					return;
				}
				
			}
		}
	}
</script>

<style lang="scss">
	.backContainer {
		display: flex;
		justify-content: center;
		align-items: center;
		background-color: #efeff4;
		.backContent {
			width: 100%;
			.userEmail {
				width: 100%;
				display: flex;
				align-items: center;
				background-color: #FFFFFF;
				text {
					font-size: 32upx;
				}
				input {
					flex: 1;
				}
			}
			.btn {
				margin-top: 20upx;
				width: 100%;
			}
		}
	}
	.input {
		height: 100%;
		.uni-input-wrapper{
			.uni-input-placeholder{
				height: 100%;
				font-size: 32upx;
				height: 100%;
				display: flex;
				align-items: center;
			}
		}
		
	}
</style>
