<template>
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="row no-gutters">
					<div class="col-12 col-sm-12 col-md-6 order-2 order-sm-2 order-md-1">
						<div ref="gallery-tops" class="swiper-container gallery-top">
							<div class="swiper-wrapper">
								<img v-for="image in images" :src="image.path" class="swiper-slide">
							</div>
							<div class="swiper-button-next"></div>
						    <div class="swiper-button-prev"></div>
							<div class="swiper-pagination"></div>
						</div>
						<div ref="gallery-thumbs" class="swiper-container gallery-thumbs">
							<div class="swiper-wrapper">
								<img v-for="image in images" :src="image.path" class="swiper-slide">
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-6 order-1 order-sm-1 order-md-2">
						<div class="card-body">
							<div class="card-title" v-text="item.name"></div>
							<div class="card-text" v-html="item.description"></div>
						</div>
					</div>
				</div>
				<div class="card-footer text-right">
					<small>{{ toDate(item.published_at) }}</small>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import FetchMixin from '../../../mixins/fetch.js';
import DateMixin from '../../../mixins/date.js';

export default {
	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.images = data.images ? data.images : this.images;

			this.$nextTick(() => {
				this.setup();
			});
		},

		setup() {
			let galleryThumbs = new Swiper(this.$refs['gallery-thumbs'], {
				slidesPerView: 4,
				freeMode: true,
				watchSlidesVisibility: true,
				watchSlidesProgress: true,
			});

			let galleryTop = new Swiper(this.$refs['gallery-tops'], {
				effect: 'fade',
				zoom: true,
				loop: true,
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
				thumbs: {
					swiper: galleryThumbs
				}
			});
		},
	},

	data() {
		return {
			item: {},
			images: [],
		}
	},

	mixins: [ FetchMixin, DateMixin ],
}
</script>