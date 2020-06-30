function Http(options) {
	return new Promise((resolve, reject) => {
		uni.request({
			...options,
			success: (res) => {
				let { data } = res
				let code = data.error_code 
				if(code || code === 0) {
					if(code == 401){
						wx.setStorageSync("userInfo", {})
						wx.setStorageSync("token", {})
					}
					uni.showToast({
						title: data.msg,
						icon : "none"
					});
				}else{
				resolve(data)
				}
				
			
				
			},
			fail: (err) => {
				uni.showToast({
					title : "请稍后重试",
					icon : "none"
				})
				reject(err)
			}
		})
	})
}

export default Http