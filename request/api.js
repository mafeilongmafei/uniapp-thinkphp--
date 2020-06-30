import Http from "./request.js"

//#ifdef H5

const baseUrl = process.env.NODE_ENV === "development" ?  "" : "http://www.xiongmaoyouxuan.com" 
// #endif
// #ifdef APP-PLUS || MP
const baseUrl = "http://www.xiongmaoyouxuan.com"
// #endif



// 得到首页分类列表
const getHomeCatrgory =  ()=>{
	return  Http({
		url : baseUrl + "/api/tabs?sa="
	})
	
}
// 点击小分类得数据
const getMincategory = (column , start = 0 , sort = 0)=>{
	console.log(baseUrl + `/api/category/${column}/items?start=${start}&sort=${sort}`)
	return Http({
		url : baseUrl + `/api/category/${id}/items?start=${start}&sort=${sort}`
	})
}
// 得到轮播图数据和点击分类数据
const getBannerlist = (num = 1)=>{
	return Http({
		url : baseUrl + `/api/tab/${num}?start=0`
	})
	
}
// 下拉请求数据
const getReachBottomData =  ( tab = 1, start = 0) => {
	return Http({
		url : baseUrl + `/api/tab/${tab}/feeds?start=${start}&sort=0`
	})
}

// 得到热门搜索列表
const getHotSearch = () =>{
	return Http({
		url : baseUrl + "/api/search/home"
	})
}
//搜索
 const userSearch = (word, start=0, sort = 0)=>{
	 return Http({
		 url : baseUrl + `/api/search?word=${word}&start=${start}&sort=${sort}&couponOnly=NaN&minPrice=0&maxPrice=99999`
	 })
 }
 // 得到商品详情
 const getShopDetail = (id)=>Http({
	 url : baseUrl + `/api/detail?id=${id}&normal=1&sa=`
 })
// 得到优惠码
const getDisCount = (id)=>Http({
	url : baseUrl + `/api/tbPassword?id=${id}`
})
//登录
const UserLogin = (data)=>Http({
	url : "http://movie.com/index.php/login",
	method : "post",
	data
})
// 注册
const UserRegistered = (data)=>Http({
	url : "http://movie.com/index.php/registered",
	method : "post",
	data
})
// 得到token
const getUserToken = (data)=>Http({
	url : "http://movie.com/index.php/getToken",
	method : "post",
	data
})
// 发送验证码
const toUserEmail = (data)=>Http({
	url : "http://movie.com/index.php/toEmail",
	method : "post",
	data
})


// 发送消息到服务器
const tomsg = (data)=>Http({
	url : "http://movie.com/index.php/addUserGroup",
	method : "post",
	header : {
		token : uni.getStorageSync("token")
	},
	data
})
// 获取在线用户
const getOnlineUser = ()=>Http({
	url : "http://movie.com/index.php/ByTokenOnlineUser",
	method : "post",
	header : {
		token : uni.getStorageSync("token")
	},
})




export {
		getHomeCatrgory,
		getBannerlist,
		getReachBottomData,
		getHotSearch,
		userSearch,
		getShopDetail,
		getDisCount,
		getMincategory,
		UserLogin,
		UserRegistered,
		toUserEmail,
		tomsg,
		getOnlineUser
}