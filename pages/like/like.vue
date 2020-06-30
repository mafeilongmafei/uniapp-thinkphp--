<template>
	<view class="Lickcontent">
		<!-- #ifdef APP-PLUS -->
		<view class="status_bar"></view>
		<!-- #endif -->
		<view class="header">
			<serach toUrl="../search/search"></serach>
		</view>
		<view class="main_content" ref="main_content">
			<scroll-view class="left_content" scroll-y="true"  >
				<view :class="index === currentIndex ? 'selectActice category_d' : 'category_d'" v-for="(item,index) in categoryList" :key="item.id" @click="swtichCategory(index)">{{item.name}}</view>
				
			</scroll-view> 
			<scroll-view  class="right_content" scroll-y="true" :scroll-top="Righttop" @scroll="Rightscroll">
				<view class="category_item" v-for="(item,index) in categoryList" :key="item.id">
					<lineV :content="item.name"></lineV>
				</view>
				
				
				
			</scroll-view >
		</view>
		
		
	</view>
</template>

<script>
	import {
		getHomeCatrgory,
		getBannerlist
	} from "../../request/api.js"
	import serach from "../../components/search/search.vue"
	import lineV from "../../components/line/index.vue"
	import { getElement } from "../../util/common.js"
	export default {
		data() {
			return {
				category : [],
				categories :[],
				num : 0,//那个tab的id
				currentIndex  : 0,//当前选中那个tab的小标
				Righttop : "",//scroll-view滚动条位置
				Lefttop : "",//scroll-view滚动条位置
				mainHeight : 0, //元素.main_content 的高度
			}
		},
		created() {
			this.getCategory()
		},
		methods:{
			async getCategory() {
				let { data } = await getHomeCatrgory()
				this.category = data.list
				this.$nextTick(async ()=>{
					let { height } = await getElement(".main_content" , {
						size : true
					})
					this.mainHeight = height
				})
				
				// this.num = this.category[2].id
				// let res2 = await getBannerlist(this.num)
				// this.categories = res2.data.categories
			},
			swtichCategory(index) {
				this.currentIndex = index
				this.Righttop = index * this.mainHeight
			},
			Rightscroll(e) {
				let height = this.mainHeight
				let { scrollTop } = e.detail
				let s = scrollTop /height
				let arr= (s + "").split(".")
				let len = arr.length
				let g = 0
				if(len >= 2) {
					let [a , b] = arr
					g = b - 0 > 0.5 ? a-0+1 : a-0;
				}else {
					g = s - 0
				}
				this.currentIndex = g
				this.Righttop =  g *height
				
			}
		},
		components:  {
			serach,
			lineV
		},
		computed:{
			categoryList() {
				this.category.shift()
				return this.category
			}
		}
	}
</script>


<style lang="scss" scoped>
	.Lickcontent {
		display: flex;
		flex-direction: column;
		flex-wrap: wrap;
		width: 100%;
		height: 100%;
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		/* #ifdef H5 */
			bottom: var(--window-bottom);
		/* #endif */
	
		.header {
			width: 100%;
			background-color: #fdde4a;
		
			/* #ifdef H5 || APP-PLUS */
			padding: 10upx 30upx;
			/* #endif */
			/* #ifdef MP */
			padding-bottom: 15upx;
			/* #endif */
		}
		.main_content {
			width: 100%;
			flex: 1;
			display: flex;
			overflow: hidden;
			.left_content {
				flex: 2;
				background-color: #fff;
				.category_d {
					width: 100%;
					display: inline-block;
					padding: 22upx 0;
					font-size: 30upx;
					color: #93918d;
					text-align: center;
					
				}
				.selectActice {
					color: #fdde4a;
				}
			}
			.right_content {
				background-color: #fff;
				flex: 6;
				.category_item {
					width: 100%;
					height: 100%;
					display: inline-block;
				}
			}
		}
	}
	
	

</style>
