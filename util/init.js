import {
	SETUSERINFO,
	SETTOKEN,
	SETUSERARR,
} from "../store/mutations-type.js"

import store from "../store/index.js"
let userArr = uni.getStorageSync("userArr") || []
let userInfo =  uni.getStorageSync("userInfo") ||  {}
let token =  uni.getStorageSync("token") || ""

store.commit(SETUSERINFO , userInfo)
store.commit(SETTOKEN , token)
store.commit(SETUSERARR , userArr)