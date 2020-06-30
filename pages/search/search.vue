<template>
	<view class="searchContainer">
		<view class="header" >
			<view class="search">
				<text @click="rehome">返回</text>
				<view class="input">
					<view class="iconfont icon-sousuo">
					</view>
					<input type="text" placeholder="搜索商品,发现更多优选" @confirm="search"  @blur="setValue" :value="value">
				</view>
				<text @click="startSearch">搜索</text>
				
			</view>
			<menuV :menuList="menuList" @staSearch="startSearch" v-if="indexData.list.length" ></menuV>
			
		</view>
	
			<scroll-view scroll-y="true" 
			class="shoplist" v-if="indexData.list.length"
			 @scrolltolower="nextData"
			  @scroll="scroll"
			  :scroll-top="top"
			  :scroll-with-animation="true"
			  >
				<shop :shopList="list" ></shop>
			</scroll-view>
	
		<view v-if="!indexData.list.length">
			<view class="hot" >
				<view class="hotSearch"><text>热门搜索</text>
					<view class="hotContent" @click="clickTag">
			
						<view :class="item.highlight ? 'hot_item hotC' : 'hot_item'" v-for="item in hotWords" :key="item.word" :data-content="item.word">
							{{item.word}}
						</view>
					</view>
				</view>
			</view>
			<view class="hot">
				<view class="hotSearch"><text>商品分类</text>
					<view class="hotContent" @click="clickTag">
			
						<view class="hot_item" v-for="item in category" :key="item.name" :data-content="item.name">
							{{item.name}}
						</view>
					</view>
				</view>
			</view>
		</view>
	<returnTop v-if="isShow"  @returnTop="returnTop"></returnTop>
	</view>
	
</template>

<script>
	let query = {
		start : 0,
		sort : 0,
	}
	
	import {
		getHomeCatrgory,
		getHotSearch,
		userSearch,
		
	} from "../../request/api.js"
	import menuV from "../../components/menu/index.vue"
	import shop from "../../components/shop/shop.vue"
	import returnTop from "../../components/returnTop/index.vue"
	import { scollView } from "../../util/common.js"
	export default {
		data() {
			return {
				category: [],
				hotWords: [],
				value : "",
				list : [],
				indexData : {
					list : []
				},
				isShow : false, //是否显示回到顶部按钮
				top : 0,
				old : {top : 0},
				menuList : [{
					name : "默认",
					id : 1
				},
				{
					name : "价格最低",
					id : 1
				},{
					name : "销量最高",
					id : 1
				}
				]
			}
		},
		async created() {
			let res1 = await getHomeCatrgory();
			let res2 = await getHotSearch();
			
			let {
				hotWords
			} = res2.data
			let {
				list
			} = res1.data
			this.category = list
			
			this.hotWords = hotWords


		},
		methods: {
			rehome() {
				
				// uni.switchTab({
				// 	url: "../index/index"
				// })
				uni.navigateBack({
					
				})
			},
			search(data) {
				
				let { value } = data.detail
				this.value = this.urlencode(value)
				this.startSearch( query.sort , 0 , true)
				
			},
			urlencode(str) {
			  str = (str + "").toString();
			  return encodeURIComponent(str)
			},
			setValue(data) {
				let { value } = data.detail
				this.value = value
			},
			async startSearch( sort = 0 , start = 0 , isClear = true) {
				this.isShow = false
				// sort 不同 清空list
				if(isClear) {
					this.list = []
					query.start = 0
					
				}
				query.sort = sort
				uni.showLoading({
					title: "加载中"
				})
				let value = this
				let res = await userSearch(this.value  , query.start , query.sort)
				this.indexData = res.data
				
				let newArray = this.list.concat(res.data.list)
				this.list = newArray
				uni.hideLoading()
			},
			async nextData(){
				query.start+= 40
				if(!this.indexData.isEnd){
					this.startSearch( query.sort , query.start , false)
				}
				
			},
			async scroll(e) {
				let is = await scollView(e , ".searchContainer" , (scrollTop)=>{
					this.old.top = scrollTop
				})
				this.isShow = is
			},
			returnTop(){
				this.top = this.old.top;
				this.$nextTick(()=>{
					this.top = 0
				})
				
				
			},
			clickTag(e) {
				let {content} = e.target.dataset
				this.value = content
				this.startSearch(query.sort , 0 , true)
			}
			
		},
		computed: {
			cat: function() {
				this.category.shift()
				return this.category
				
			}
		},
		components: {
			menuV,
			shop,
			returnTop
		}
	}
</script>

<style scoped lang="scss">
	@import "./index.scss"
</style>
