<template name="category" >
	<view class="category_list_img">
		<view class="category_main">
			<view class="category_header" v-if="isHeader">
				<text>全部分类</text>
				<text class="iconfont icon-icon- category_exit" @click="hideYour"></text>
			</view>
			

			
			<view class="category_content" @click="selctTab">
				<view class="category_item" v-for="(item , index) in categoryList" :key="item.imageUrl" :data-id="item.id" :data-index="index">
					<image mode="scaleToFill" :src="item.imageUrl" :data-id="item.id"  :data-index="index"></image>
					<text :data-id="item.id"  :data-index="index">{{item.name || item.title}}</text>
				</view>
				
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		name : "category",
		props: {
			categoryList : {
				type : Array,
				default : function() {return []}
			},
			isHeader : {
				type : Boolean,
				default : true
			}
		},
		data() {
			return {
				
			};
		}
		,methods:{
			hideYour(){
				this.$emit("hid")
			},
			selctTab(e){
				let {
					id,index
				} = e.target.dataset
				this.$emit("hid")
				this.$emit("switchTab" , {id  , index})
			}
		},
			
		components: {
		}
	}
</script>

<style scoped lang="scss" scoped>
	@import  "./index.scss"

</style>
