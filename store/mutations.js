import {
	SETUSERINFO,
	SETTOKEN,
	SETUSERARR,
} from "./mutations-type.js"

export default {
	[SETUSERINFO](state , data) {
		state.user = data
	},
	[SETTOKEN](state , data) {
		state.token = data
	},
	[SETUSERARR] (state , data) {
		state.userArr = data
	}
	
}