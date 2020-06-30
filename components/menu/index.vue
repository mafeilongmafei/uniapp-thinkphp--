<template name="menuV">
	<view class="menuContainer">
		<view v-for="(item , index) in menuList" 
		:key="item.name" 
		:class="Currentindex === index? 'menu_item menuActive' : 'menu_item'"
		@click="switchMenu(index)"
		>
			{{item.name}}
		</view>
	</view>
</template>

<script>
	export default {
		name : "menuV",
		props: {
			menuList : {
				type : Array,
				default : ()=>{return []}
			}
		},
		
		data(){
			return {
				Currentindex : 0,//默认显示菜单
			}
		},
		methods : {
			switchMenu(index) {
				this.Currentindex = index
				this.$emit("staSearch" , this.Currentindex)
			}
		}
		
	}
</script>

<style lang="scss" scoped>
	.menuContainer {
		width: 100%;
		height: 86upx;
		background-color: #ffffff;
		display: flex;
		justify-content: space-around;
		align-items: center;
		font-size: 24upx;
		color: #43240c;
		border-bottom: 1px solid #d9d9d9;
		.menu_item {
			width: 100upx;
			height: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.menuActive {
			color : #fa585a;
		}
	}
	
</style>
