import {
	tomsg,
	getOnlineUser
} from "./api.js"
import store from "../store/index.js"
import { SETUSERARR } from "../store/mutations-type.js"
import {  getCurPage } from "../util/common.js"

class Socket {
	constructor() {
	    this.init()
	}
	showBage(num) {
		store.getters.isShowBage ? uni.showTabBarRedDot({
			index : 2
		}) :  uni.hideTabBarRedDot({index : 2})
	}
	// 初始化
	init() {
		let token = uni.getStorageSync("token");
		// 没有token 不进行初始化  初始化没用
		if(!token) {
			return 
		}
		this.showBage();
		uni.connectSocket({
			url: "ws://127.0.0.1:2345",
			success: () => {
				uni.onSocketOpen(() => {
					uni.onSocketMessage((data) => {
						let d = JSON.parse(data.data)
						this.byTypeDispose(d)
					})
		
				})
			},
			fail: () => {
				uni.showToast({
					title: "设配不支持通信",
					icon: "none"
				})
			}
		})
		
		uni.onSocketError(() => {
			uni.showToast({
				title: "连接出了点问题",
				icon: "none"
			})
		})
	}
	// 根据type做处理
	byTypeDispose(data) {
		switch (data.type) {
			// 初始化将client_id 与uid绑定 后端做
			case "init":
				tomsg(data)
				break;
			case "sconnect":
				// 告诉通信录有人上线 不能立马就执行  因为上线时他还的和服务器进行通信 将client_id和uid绑定 需要时间
				uni.$emit("OnlineUser")
				break;
				// 别人向你发消息
			case "toMsg":
				this.savemsg(data)
				break;
			case "disconnect":
				// 有人下线
				uni.$emit("OnlineUser")
				break;
			case "ping":
			uni.sendSocketMessage({data : "ok"})
				break;
			default:
				break;
		}
	}
	// 接收到消息
	// 1.更新聊天界面消息
	// 2.网对应的聊天界面存数据
		savemsg(data) {
			// 发送者的id
			let fromId = data.fromId
			// 我的nickname
			let nickname = data.user[0].nickname
			// 我的id
			let id = data.touid - 0
			// 我和发过来的人的聊天记录   发送时 和接收时的key要一样
			let key =  id  + ""  + fromId   + "user"
			let user = uni.getStorageSync(key) || [];
			// 我的的头像
			let avatarUrl = data.user[0].avatarUrl
			// 他给我消息
			let msg = data.msg
			// 发送者的时间
			// let date = Date.now()
			let date = data.date
			// 所有消息列表
			let usermsg = uni.getStorageSync("userArr") || []
			// 要添加的新小息
			let addUsermsg = {
				id : fromId,
				nickname,
				avatarUrl,
				msg,
				date,
				
			}
			let curRoute = getCurPage();
			if(curRoute === "pages/chatDetail/chatDetail"){
				// 是否已读 0 未读 1已读   
				// 除了聊天页面 已读   其他页面都是未读
				addUsermsg.isShow = 1
			}else {
				addUsermsg.isShow = 0
			}
			// 我和他的聊天记录
			user.push({
				from: addUsermsg
			})
			// 消息页面 先看一下消息中有没有这条消息 有更新 没有新增
			let index = usermsg.findIndex(item => item.id === fromId)
			if (index == -1) {
				usermsg.push(addUsermsg)
			} else {
				usermsg[index] = addUsermsg
			
			}
			
			// 更新消息界面
			store.commit(SETUSERARR , usermsg)
			// 保存到本地
			uni.setStorageSync("userArr", usermsg)
			uni.setStorageSync( key , user)
			// 通知我和他聊天界面 , 数据更新了
			if(curRoute === "pages/chatDetail/chatDetail"){
				uni.$emit("msg" , user)
			}
			this.showBage();
			
		}
	
}

export default new Socket()






