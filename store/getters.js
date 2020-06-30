export default {
	isShowBage({userArr}) {
		return userArr.reduce((preTol , nextValue) =>{
			if(!nextValue.isShow) {
				return preTol + 1
			}else {
				return preTol + 0
			}
		}, 0)
	}
}