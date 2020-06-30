<template name="shop">
	<view class="shopContainer">
		<view class="shopItem" v-for="item in shopList"   :key="item.image">
		<navigator 
		:open-type="item.type == 1? 'navigate':'reLaunch'"
		:url="item.type == 1? '../../pages/shopDetail/shopDetail?id=' + item.id : '/pages/index/index?id='+ item.url.split('=')[1]">
			<view class="img">
				<image :src="item.image" mode="scaleToFill" :lazy-load="true"></image>
			</view>
			<view class="shopDirection">
				<view class="text">
					{{item.title}}
				</view>
				<view class="youhui">
					<view class="tianmao">天猫</view>
					<view class="isB">包邮</view>
				
				</view>
				<view class="shopItem_bottom">
					<view class="price">{{item.price}}</view>
					<view class="shopR">{{item.saleNum}}人</view>
				</view>
			</view>
		</navigator>
		
		
		</view>
	</view>
</template>

<script>
	export default {
		name: "shop",
		props: {
			shopList : {
				type : Array,
				default : ()=>[]
			}
		}
	}
</script>

<style scoped lang="scss">
	@import "./index.scss"
</style>
