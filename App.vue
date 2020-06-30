<script>
	// let socket_flag = false;
	// var SocketTask = uni.connectSocket({
	// 	url: 'ws://127.0.0.1:2345',
	// 	fail: function(res) {
	// 		console.log("连接服务器websocket_失败", res);
	// 	},
	// 	success: function(res) {
	// 		console.log("连接服务器websocket_成功", res);
	// 		socket_flag = true;
	// 	},
	// 	complete: function(res) {
	// 		console.log("连接服务器websocket_完成", res);
	// 	}
	// });
	// export default {
	// 	globalData: { //   导出为全局方法使用
	// 		SocketTask: SocketTask
	// 	},
	// 	methods : {
	// 		onmessage_fun: function() {
	// 			console.log("onmessage_fun_______");
	// 			SocketTask.onMessage(function(data) {
	// 				console.log("SocketTask 通信接受消息______", data);
	// 				uni.$emit('app_test', data);
	// 			})
	// 		},
	// 		//中转事件
	// 		// app_test: function(data) {
	// 		// 	console.log("监听到了，接受消息的事件回调::ffffffffff::::::")
	// 		// },
	// 		openSocketFun: function() {
	// 			SocketTask = uni.connectSocket({
	// 				url: 'ws://127.0.0.1:2345',
	// 				fail: function(res) {
	// 					console.log("连接服务器websocket_失败", res);
	// 				},
	// 				success: function(res) {
	// 					console.log("连接服务器websocket_成功", res);
	// 				},
	// 				complete: function(res) {
	// 					console.log("连接服务器websocket_完成", res);
	// 				}
	// 			});
	// 			getApp().globalData.SocketTask = SocketTask;
	// 		},
	// 	},
	// 	onShow: function() {
	// 		console.log('App Show')
	// 		// 判断socket连接标识 false未连接，true 连接
	// 		if (!socket_flag) {
	// 			// 调用methods中方法打开创建连接
	// 			this.openSocketFun();
	// 		}
	// 		// 调用全局的创建连接方法    执行.onOpen打开连接
	// 		SocketTask.onOpen((res) => {
	// 			console.log("socketTask 打开连接: ", res);
	// 			socket_flag = true; // 修改连接标识 为true
	// 			this.onmessage_fun(); // 调用接收通信信息的方法 接收信息
	// 		});


	// 	},
	// 	onHide: function() {
	// 		console.log('App Hide')
	// 		// 关闭连接
	// 		SocketTask.close({
	// 			code: 1000,
	// 			success: function() {
	// 				console.log("SocketTask close success ");
	// 			},
	// 			fail: function(res) {
	// 				console.log("SocketTask close fail ", res);
	// 			}

	// 		});
	// 		// 关闭连接并且修改标识
	// 		SocketTask.onClose(function() {
	// 			console.log("SocketTask onClose success ");
	// 			socket_flag = false;
	// 		})

	// 	},


	// }
</script>

<style>
	@import "./assets/iconfont.css";

	/*每个页面公共css */
	.container {
		display: flex;
		flex-direction: column;
		background-color: #f5f5f5;
	}

	view,
	navigator,
	text,
	swiper,
	swiper-item,
	input,
	scroll-view {
		margin: 0;
		padding: 0;
		box-sizing: border-box;

	}

	.clearFix::after,
	.clearFix::before {
		content: "";
		display: table;
		clear: both;
	}

	.centerW {
		display: flex;
		justify-content: center;
		align-items: center;
	}

	uni-page-body {
		height: 100%;
	}

	scroll-view [style*="overflow"]::-webkit-scrollbar {
		display: none;
	}

	/* 状态栏 */
	.status_bar {
		width: 100%;
		height: var(--status-bar-height);
		background-color: #fdde4a;
	}

	/* body 在横屏底下和竖屏底下一定要做好定位，不然*/
	/* 竖屏底下的查询 */
	@media screen and (orientation: portrait) {
		body {
			/* 防止页面被刘海遮住 */
			padding-top: constant(safe-area-inset-top);
			//以防万一写一个你本身适配其他手机的
			padding-top: 0px;
		}
	}

	/* 横屏底下的查询 */
	@media screen and (orientation: landscape) {
		body {
			/* IOS 11支持*/
			padding-right: constant(safe-area-inset-right);
			padding-left: constant(safe-area-inset-left);
			padding-bottom: constant(safe-area-inset-bottom); //为底下圆弧的高度 34px 
			/*IOS 11.2版本版本支持*/
			padding-right: env(safe-area-inset-right);
			padding-left: env(safe-area-inset-left);
			padding-bottom: env(safe-area-inset-bottom);
			/* //以防万一写一个你本身适配其他手机的 */
			padding-right: 0px;
			padding-left: 0px;
			padding-bottom: 0px;
		}
	}
</style>
