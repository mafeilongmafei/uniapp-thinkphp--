module.exports = {
	devServer : {
		proxy : {
			"/api" : {
				target : "http://www.xiongmaoyouxuan.com",
				changeOrigin : true
			}
		}
	}
}