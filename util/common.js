import Clipboard from 'clipboard'
import store from "../store/index.js"
import { SETUSERARR } from "../store/mutations-type.js"

export let getElement = (el, options) => {
	return new Promise((resolve, reject) => {
		let view = uni.createSelectorQuery()
		// view.select(".container").boundingClientRect()
		// view.exec(function(res){
		// 	console.log(res)
		// })
		view.select(el).fields(options)
		view.exec(function(res) {
			resolve(res[0])
		})
	})
}


export let scollView = async (e, field, calllBack) => {
	let {
		scrollTop
	} = e.detail
	let pageY
	// #ifdef APP-PLUS 
	pageY = document.body.clientHeight; //页面的高度
	// #endif
	// #ifdef MP || H5
	let {
		height
	} = await getElement(field, {
		size: true
	})
	pageY = height
	// #endif
	calllBack(scrollTop)
	if (scrollTop > pageY) {
		return true
	} else {
		return false
	}
}
export let getSystemStatusBarHeight = {
	data() {
		return {
			heightBar: 0 ////状态栏的高度
		}
	},
	created() {
		let height = 0;
		// #ifdef APP-PLUS
		height = plus.navigator.getStatusbarHeight();
		// #endif
		// #ifdef MP
		height = 25;
		// #endif
		this.heightBar = height

	}
}


export let isToken = {
	beforeCreate() {
		let token = uni.getStorageSync("token");
		if (!token) {
			uni.showToast({
				title: "请登录",
				icon: "none"
			})
			uni.switchTab({
				url: "../pages/my/my"
			})

		}
	}
}

export function getCurPage() {
	let pages = getCurrentPages();
	let curPage = pages[pages.length - 1];
	return curPage.route
}
export let edituserArr = {
	methods: {
		navChatDetail(id, nickname) {
			let len = this.userArr.length
			let userArr = []
			if (len) {
				userArr = this.userArr.map(item => {
					if (item.id === id) {
						item.isShow = 1
					}
					return item
				})
				uni.setStorageSync("userArr", userArr)
			}
			store.commit(SETUSERARR, userArr)
			console
			store.getters.isShowBage ? uni.showTabBarRedDot({
				index: 2
			}) : uni.hideTabBarRedDot({index : 2})

			uni.navigateTo({
				url: `../chatDetail/chatDetail?id=${id}&nickname=${nickname}`
			})

		}

	}

}
