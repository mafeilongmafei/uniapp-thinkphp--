<template>
	<view class="container" >
		<!-- :style="isShowcategory?'{display:none}':'{}'" -->
		<makev v-if="isShowcategory"></makev>
		<!-- ['header' , { activeCategory : isAddAvtive }] -->
		<view :class="isAddAvtive ? 'header activeCategory' : 'header'" >
			<search class="search" toUrl="../search/search"></search>
			<view class="cateContainer" v-if="!isShowcategory">
				<list @switchCategoryName="switchCategoryName" :categoryList="categoryList" :currentIndex="currentIndex" class="cate the-ancestor"
				@setLeftArr ='setLeftArr'
				 ref="list"></list>
				<view class="iconfont icon-shangpinliebiao menu" @click="showCategory"></view>
			</view>
			<category v-if="isShowcategory" @hid="showCategory" :categoryList="categoryList" @switchTab="switchTab"></category>
		</view>



		<scroll-view scroll-y="true" class="shopMain" @scroll="scroll" :scroll-top="top" :lower-threshold='70' @scrolltolower="onBottom"
		 :scroll-with-animation="true">
			<view class="banner" v-if="indexData.banners">
				<swiper autoplay>
					<swiper-item v-for="item in indexData.banners" :key="item.imageUrl">
						<image :src="item.imageUrl" mode="widthFix"></image>
					</swiper-item>

				</swiper>
			</view>

			<view class="xmenu" v-if="!indexData.banners">
				<lineV :content="indexData.categoriesTitle"></lineV>
				<category :categoryList="indexData.categories" :isHeader="false" ></category>

			</view>
			<returnTop :isShow="showReturnTop" @returnTop="returnTop"></returnTop>

			<lineV content="大家都在逛"></lineV>
			<shop class="shopItem" :shopList="indexData.items && indexData.items.list"></shop>
		</scroll-view>
	</view>
</template>
<script>
	import search from "../../components/search/search.vue"
	import list from "../../components/list/index.vue"
	import category from "../../components/category/category.vue"
	import makev from "../../components/mask/index.vue"
	import shop from "../../components/shop/shop.vue"
	import lineV from "../../components/line/index.vue"
	import returnTop from "../../components/returnTop/index.vue"
	import   config from "../../util/config.js"
	import {
		scollView,
		getElement,
	} from "../../util/common.js"

	import {
		getHomeCatrgory,
		getBannerlist,
		getReachBottomData,
		getMincategory,
	} from "../../request/api.js"

	let preScroll = 0;
	let start = 0; //从多少条开始请求
	let	height = config.height //超出多少显示返回
	export default {
		name: "index",
		data() {
			return {
				categoryList: [], //分类列表
				indexData: {}, //首页数据
				isAddAvtive: false, //是否给category添加吸顶的效果,
				isShowcategory: false,
				currentIndex: 1, //当前选择的分类,
				showReturnTop: false,
				top: 0,
				old: {
					top: 0,
				},
				leftArr: [], // 子组件中每一个运算的offsetleft值,
				
			
		

			}
		},
		components: {
			search,
			list,
			category,
			makev,
			shop,
			lineV,
			returnTop
		},
		created() {
			uni.showLoading({
				title: "加载中",
				mask: true
			})
			this.getCategoryData()
			this.getHomeData()
			
		},
		methods: {
			// 得到分类列表
			switchCategoryName(id) {
				this.currentIndex = id - 0
				this.getHomeData(id - 0)
			},
			async getCategoryData() {
				let res = await getHomeCatrgory();
				this.categoryList = res.data.list
				uni.hideLoading()
				// 获取到子组件中的leftArr数据 保存到父组件
				let list = this.$refs.list
				list.selCategory();	
				this.leftArr = list.leftArr
			},
			setnavTop() {
				let WY = this.old.top
				if (WY > preScroll) {
					this.isAddAvtive = true
				} else {
					this.isAddAvtive = false
				}
				preScroll = WY

			},
			showCategory() {
				this.isShowcategory = !this.isShowcategory

			},
			//得到首页数据
			async getHomeData(num) {
				let bannerList = await getBannerlist(num)
				let {
					banners,
					categoriesTitle,
					categories,
					items
				} = bannerList.data
				this.indexData = {
					banners,
					categoriesTitle,
					categories,
					items
				}
				// this.$nextTick(()=>{
				// 	let view = uni.createSelectorQuery().select(".banner")
				// 	view.fields({rect: true} , res=>{
				// 		console.log(res)
				// 	}).exec()
				// })


			},
			// scroll-view滚动触发
			async scroll(e) {
				// let is = await scollView(e, ".shopMain", (scrollTop) => {
				// 	this.old.top = scrollTop
				// })
				let {
					scrollTop
				} = e.detail
				this.old.top = scrollTop
				let is
				if (scrollTop > height) {
					is = true
				} else {
					is = false
				}
				if (is) {
					this.showReturnTop = true
				} else {
					this.showReturnTop = false
				}
				this.setnavTop()
			},
			// 回到顶部
			returnTop() {
				this.top = this.old.top
				this.$nextTick(function() {
					this.top = 0
				})

			},
			async onBottom(e) {
				start += 20;
				uni.showLoading({
					title: "加载中",
					mask: true,
				})
				let {
					data
				} = await getReachBottomData(this.currentIndex, start);
				if (!data.isEnd) {
					let newArray = [].concat(this.indexData.items.list, data.list)
					this.indexData.items.list = newArray
				} else {
					uni.showToast({
						title: "已经到底了"
					})
				}
				uni.hideLoading()


			},
			switchTab({id,index}) {
					this.currentIndex = id - 0;
					this.switchCategoryName(id)
					this.$nextTick(()=>{
						// 这里获取的list组件中 leftArr是空的
						let list = this.$refs.list
						// 把父组件中保存的子组件的数据再次给了子组件   主要是由于 我自己无法获取跨组件获取子组件中的元素 ,不然没这么麻烦
						list.leftArr= this.leftArr
						list.moveTab(index - 0)
					})

				},
			setLeftArr(data){
				this.leftArr = data
			},
			
		}
	}
</script>

<style scoped lang="scss">
	@import "./index.scss"
</style>
