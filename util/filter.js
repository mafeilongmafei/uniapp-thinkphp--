import Vue from "vue"
Vue.filter("parseTime" , (value)=>{
	let date = new Date(value);
	let nowDate = new Date();
	let nowT = nowDate.getDate()
	let n = date.getFullYear()
	let t = date.getDate() + "日" //天
	let y = date.getMonth() + 1 + "月" //月
	let h = date.getHours(); //时
	let f = date.getMinutes(); //分
	if(nowT > t) {
		return `${n}年${y}月 ${t}日${h}时${f}分`
	}else {
		return  `${h}时${f}分` 
	}
})

