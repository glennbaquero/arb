<template>
	<div class="form-group">
		<!-- For Single Display -->
		<div v-if="(value || url) && !multiple" class="row align-items-start">
            <div class="col-sm-12 mb-2">
            	<div class="d-inline-block align-top">
            		<a :href="value" target="_blank">
		                <img v-if="value" :src="value" class="img-thumbnail" width="120px" height="auto">
	            		<small v-if="url && value" class="d-block text-muted align-top text-sm-center">(Current Image)</small>
            		</a>
            	</div>
            	<div class="d-inline-block align-top">
	                <img v-if="url" :src="url ? url : value" class="img-thumbnail" width="120px" height="auto" />
            		<small v-if="url" class="d-block text-muted align-top text-spm-center">(New Image)</small>
            	</div>
            </div>
        </div>
		
		<!-- / For Multiple Display -->
        <div v-if="multiple">
    		<small v-if="value.length > 0" class="d-block text-muted align-top mb-2">({{ sortUrl ? 'Drag to Sort Current Images' : 'Current Images' }})</small>
        	<div ref="sortable" v-if="value" class="d-block align-top">
	        	<template v-for="image in value">
	        		<div class="d-inline-block position-relative mr-2" :data-id="image[imageValue]">
	        			<a class="d-inline-block border border-dark" :href="image[imageSrc]" target="_blank">
	        				<div class="bg-cover" style="width: 120px; height: 120px;" :style="'background: url('+ image[imageSrc] +');'"></div>
		        		</a>
		        		<button @click="showDialog(image[imageValue])" type="button" class="btn btn-sm btn-danger remove-button" :disabled="disabled"><i class="fa fa-times"></i></button>
	        		</div>
	        	</template>
        	</div>
        	<div v-if="array_count(files) > 0" class="d-block align-top">
        		<small class="d-block text-muted align-top">(New Images)</small>
	        	<template v-for="file in files">
	        		<div class="border border-dark bg-cover d-inline-block mr-2" style="width: 120px; height: 120px;" :style="'background: url('+ file +');'"></div>
	        	</template>
        	</div>
        	<div class="mb-1"></div>
        </div>

        <label v-if="label">{{ label }} <small v-if="note">({{ note }})</small></label>
        <div class="input-group">
	        <div class="custom-file" style="overflow: hidden;">
	            <input ref="file" :name="name" @click="clear" @change="change" :disabled="!editable" 
	            type="file" :multiple="multiple" class="custom-file-input">
	            <label class="custom-file-label">
	            	<template>
	                	<template v-if="images.length > 0" v-for="image in images">{{ image.name }} </template>
	                	<template v-if="images.length < 1">{{ placeholder }}</template>
	            	</template>
	            </label>
	        </div>
	        <div class="input-group-append">
				<button @click="clear" type="button" class="input-group-text" :disabled="disabled"><i class="fa fa-times"></i></button>
			</div>
        </div>
    </div>
</template>

<script type="text/javascript">
import ResponseMixin from '../../mixins/response.js';
import ArrayMixin from '../../mixins/array.js';
import SortableMixin from '../../mixins/sortable.js';

export default
{
	methods: {
		change: function(event) {
			let files = event.target.files;
			if (!this.validateCount(files)) { 
				return; 
			};

			if(!this.multiple) { 
				this.url = URL.createObjectURL(files[0]);
			} else {
				for (let i = files.length - 1; i >= 0; i--) {
					this.files.push(URL.createObjectURL(files[i]));
				}
			}

			this.images = files;
			this.$emit('change', event);
		},

		showDialog(id) {
			if (!this.confirm) { return; }
			if (!this.validateCount(this.files, true)) { return; };

			let message = {
				title: this.title,
			    body: this.message, 
			};

			let options = {
				loader: true,
				okText: this.okText,
				cancelText: this.cancelText,
				animation: 'fade',
				type: this.type,
				verification: this.verification,
				verificationHelp: this.verificationHelp,
			};

			this.$dialog.confirm(message, options)
			.then((dialog) => {
				this.remove(id, dialog);
			}).catch(() => {

			});			
		},

		remove(id, dialog = null) {
			if (this.loading) { return; }
			if (!this.validateCount(this.files, true)) { return; };

			this.loading = true;

			axios.post(this.removeUrl, {
				id: id
			})
			.then(response => {
				this.has_removed = true;
				const data = response.data;
				this.parseSuccess(data.message);
				this.$emit('remove');
			}).catch(error => {
				this.parseError(error);
			}).then(() => {
				this.loading = false;
				if (dialog) {
					dialog.loading(false)
					dialog.close();
				}
			});
		},

		clear() {
			this.$refs.file.value = null;
			this.images = [];
			this.files = [];
			this.url = null;
		},

		validateCount(files, removeImage = false) {
			if (this.multiple) {
				let count = this.value.length;

				if (this.max && !removeImage) {
					if ((files.length + count) > this.max) {
						this.parseError('You can only have maximum of ' + this.max + ' images.');
						this.clear();
						return false;				
					}
				}

				if(this.min) {
					let minus = removeImage ? 1 : 0; 
					if ((files.length + count - minus) < this.min) {
						this.parseError('You can only have minimum of ' + this.min + ' images.');
						this.clear();
						return false;
					}
				}

				return true;
			}

			return true;
		},
	},

	watch: {
		value() {
			if (!this.has_removed) {
				this.files = [];
				this.clear();
			}

			this.has_removed = false;
		},
	},

	computed: {
		editable() {
			return !this.disabled && !this.loading;
		},
	},

	props: {
		label: {
			default:null,
			type: String,
		},

		name: {
			default:null,
			type: String,
		},

		multiple: {
			default:false,
			type: Boolean,
		},

		placeholder: {
			default: 'Choose File'
		},

		confirm: {
			default: true,
			type: Boolean,
		},

		title: {
			default: 'Warning!',
			type: String,
		},

		note: {},

		message: {
			default: 'This action cannot be undone, are you sure you wish to proceed?',
			type: String,
		},

		okText: {
			default: 'Continue',
			type: String,
		},

		cancelText: {
			default: 'Cancel',
			type: String,
		},

		value: {},

		removeUrl: String,

		imageSrc: {
			default: 'path',
			type: String,
		},

		imageValue: {
			default: 'id',
			type: String,
		},

		max: {},

		min: {},

		disabled: {
			type: Boolean,
			default: false,
		},

		sortUrl: String,
	},

	data(){
		return {
			images: [],
			url: null,

			files: [],
			loading: false,
			has_removed: false,
		}
	},

	mixins: [ ResponseMixin, ArrayMixin, SortableMixin ],
}
</script>

<style type="text/css" scoped>
.bg-cover {
	background-size: cover !important;
    background-repeat: no-repeat !important;
    background-position: center center !important;
}

.remove-button {
	position: absolute;
	top: 0;
	right: 0;
}
</style>