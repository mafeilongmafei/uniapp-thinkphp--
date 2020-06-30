<template name="list">
	<view class="category the-descendant">
		<view :class="1 === currentIndex ? 'recommend active' : 'recommend'" data-id="1" @click="switchName">{{currentCategoryName}}

		</view>
		<view class="su">
			|
		</view>
		<view class="test" id="test" :prop="VLeftArr" :change:prop="test.updateEcharts"></view>
		<scroll-view :scroll-x="true" :scroll-left="left" :scroll-with-animation="true" @scroll="scroll" :show-scrollbar="true">
			<view :class="cate.id === currentIndex ?  'category-item active' : 'category-item'" v-for="(cate , index) in categoryList"
			 :key="cate.name" :data-id="cate.id" :data-index="index" @click="switchName">{{cate.name}}

			</view>
		</scroll-view>

	</view>
</template>

<script>
	export default {
		name: "list",
		props: {
			categoryList: {
				type: Array,
				default: function() {
					return []
				}
			},
			currentIndex: {
				type: Number,
				// 当前的index 也就激活状态
				default: 1,
			}
		},
		data() {
			return {
				oldIndex: 0,
				leftArr: [],
				VLeftArr: [], //假的vLeftArr
				left: 0,
			}
		},
		methods: {
			switchName(e) {
				let {
					index,
					id
				} = e.currentTarget.dataset
				let len = this.leftArr.length
				this.$emit("switchCategoryName", id - 0)
				this.moveTab(index - 0)
			},
			moveTab(index) {
				if (index == 0 || index == 1 || index == 2) {
					this.left = 0
					return false
				}
				this.left = this.leftArr[index] - this.leftArr[2]

			},
			scroll(e) {
				let {
					scrollLeft
				} = e.detail
				this.left = scrollLeft
			},
			selCategory() {
				this.$nextTick(() => {
					// let view = uni.createSelectorQuery().in(this)
					// view.selectAll('.category-item').fields({rect: true} , res=>{
					// // this.leftArr.push(item)
					// console.log(res)
					// }).exec()

					// #ifdef MP || H5 
					let view = uni.createSelectorQuery().in(this)
					view.selectAll('.category-item').fields({
						rect: true
					})
					view.exec(res => {
						let arr = res[0]
						arr.forEach(item => {
							this.leftArr.push(item.left)
						})

					})
					// #endif
					// #ifdef APP-PLUS
					// 触发renderjs :change:prop
					this.VLeftArr = [1, 2, 3]
					// #endif
				})
			},
			setLeftArr(data) {
				this.leftArr = data
				// 重新给父组件中leftArr赋值
				this.$emit("setLeftArr" , data)

			}
		},
		computed: {
			currentCategoryName() {
				let d = this.categoryList[0]
				return d && d.name
			}
		},

	}
</script>
<script module="test" lang="renderjs">
	export default {
		mounted() {},
		methods: {
			getElementItem(ownerInstance) {
				this.$nextTick(() => {
					let arr = []
					let itemArr = document.getElementsByClassName("category-item")
					itemArr = [...itemArr]
					itemArr.forEach(item => {
						arr.push(item.offsetLeft);
					})
					this.chufa(ownerInstance, arr)
				})

			},
			updateEcharts(newValue, oldValue, ownerInstance, instance) {
				this.getElementItem(ownerInstance)

			},
			chufa(ownerInstance, data) {
				// 调用 service 层的方法
				ownerInstance.callMethod('setLeftArr', data)
			}
		}
	}
</script>


<style lang="scss" scoped>
	.category {
		display: flex;
		justify-content: space-between;
		align-items: center;
		height: 92upx;
		color: #43240c;
		font-size: 32upx;

		background-color: #fdde4a;

		.recommend {
			height: 100%;
			margin-right: 18upx;
			line-height: 92upx;
		}

		.su {
			height: 100%;
			line-height: 92upx;
			font-size: 32upx;
			color: #ccc;
			margin-right: 18upx;
		}

		scroll-view {
			flex: 1;
			white-space: nowrap;
			overflow: hidden;
			position: relative;

			view {
				display: inline-block;
				margin-left: 14px;
				text-align: center;
				line-height: 92upx;
				font-size: 28upx;
				color: #6b4c10;
				position: relative;

				.line-bottom {
					width: 100%;
					height: 8upx;
					background-color: #fdde4a;
				}
			}

			&::-webkit-scrollbar {
				display: none;
			}

			& view:first-child {
				display: none;
			}

			// & view:first-child::before {
			// 	content: "";
			// 	height: 60upx;
			// 	border-right:2upx solid #ccc;
			// 	position: absolute;
			// 	right: -19upx;
			// 	top: 50%;
			// 	margin-top: -30upx;
			// }





		}

		.active {
			color: #333333;
			position: relative;

			&::before {
				content: "";
				position: absolute;
				width: 100%;
				left: 0;
				right: 0;
				bottom: 0;
				border-bottom: 3px solid #43240c;
			}
		}

	}

	.activeCategory {
		top: -86upx;
	}

	.test {
		display: none;
	}
</style>
