<template>
	<div class="card shadow-sm">
		<div @click="toggle" class="card-header cursor-pointer">
			<h5 class="font-weight-bold m-0 d-inline-block">Meta Tags</h5>
			<span class="float-right">
				<i v-if="visible" class="fas fa-chevron-up"></i>
				<i v-if="!visible" class="fas fa-chevron-down"></i>
			</span>
		</div>
		<div v-if="visible" class="card-body">
			<transition name="fade">
				<div class="row">
					<div class="form-group col col-sm-12 col-md-6">
						<label>Title</label>
						<input v-model="meta.title" name="meta_title" type="text" class="form-control input-sm">
					</div>

					<div class="form-group col col-sm-12 col-md-6">
						<label>Keywords</label>
						<input v-model="meta.keywords" name="meta_keywords" type="text" class="form-control input-sm">
					</div>

					<div class="form-group col col-sm-12 col-md-12">
						<label>Description</label>
						<input v-model="meta.description" name="meta_description" type="text" class="form-control input-sm">
					</div>

					<div class="col-sm-12">
						<hr />
						<h5 class="font-weight-bold">Open Graph (OG)</h5>
					</div>
					
					<div class="form-group col col-sm-12 col-md-12">
						<label>Title</label>
						<input v-model="meta.og_title" name="meta_og_title" type="text" class="form-control input-sm">
					</div>

					<div class="form-group col col-sm-12 col-md-12">
						<label>Description</label>
						<input v-model="meta.og_description" name="meta_og_description" type="text" class="form-control input-sm">
					</div>

					<image-picker
					:value="meta.path"
					class="form-group col-sm-12 col-md-12 mt-2"
			        label="Image"
			        name="meta_og_image"
			        note="Recommended Size: 1200 x 630"
			        placeholder="Choose a File"
					></image-picker>
				</div>
			</transition>
			
		</div>
	</div>
</template>

<script>
import Card from '../containers/Card.vue';
import ImagePicker from '../inputs/ImagePicker.vue';

export default {
	mounted() {
		if (!this.meta.id) {
			this.meta = this.item;
		}
	},

	methods: {
		toggle() {
			this.visible = !this.visible;
		},
	},

	watch: {
		item(value) {
			this.meta = value;
		},
	},

	data() {
		return {
			visible: false,
			meta: {},
		};
	},

	props: {
		item: {},
	},

	components: {
		'card': Card,
		'image-picker': ImagePicker,
	}
}
</script>