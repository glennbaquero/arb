<template>
	<div ref="elem" class="wall-carousel swiper-container">
		<div class="swiper-wrapper">
			<img v-for="item in items" :src="item.path" class="swiper-slide">
		</div>
		<div class="swiper-pagination"></div>
	</div>
</template>

<script>
export default {
	mounted() {
		this.setup();
	},

	methods: {
		setup() {
			new Swiper(this.$refs.elem, {
				grabCursor: true,
				loop: true,
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
					dynamicBullets: true,
				},
			});
		},
	},

	props: {
		items: {
			default: () => [],
			type: Array,
		},
	}
}
</script>