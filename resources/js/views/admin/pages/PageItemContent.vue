<template>
	<div class="row">
		<div v-if="isText" class="form-group col-sm-12 col-md-12">
			<label>{{ label }} <small v-if="note">({{ note }})</small></label>
			<input :value="content" :name="name" type="text" class="form-control input-sm">
		</div>

		<image-picker v-if="isImage"
		:value="content"
		class="form-group col-sm-12 col-md-12 mt-2"
        :label="label"
        :name="name"
        :note="note"
        placeholder="Choose an Image"
		></image-picker>

		<text-editor v-if="isHtml"
		v-model="content"
		class="col-sm-12"
		:label="label"
		:name="name"
		:note="note"
		row="3"
		></text-editor>
	</div>
</template>

<script type="text/javascript">
import ImagePicker from '../../../components/inputs/ImagePicker.vue';
import TextEditor from '../../../components/inputs/TextEditor.vue';
import StringHelper from '../../../mixins/string.js';

export default {
	mounted() {
		if (!this.content) {
			this.content = this.value;
		}
	},

	computed: {
		isText() {
			return this.type === 'TEXT';
		},

		isHtml() {
			return this.type === 'HTML';
		},

		isImage() {
			return this.type === 'IMAGE';
		},
	},

	data() {
		return {
			content: null,
		}
	},

	watch: {
		content(value) {
			this.$emit('change', value);
		},

		value(value) {
			this.content = value;
		},
	},

	props: {
		type: {},
		name: String,
		value: {},
		label: {
			default: '',
		},
		note: {},
	},

	components: {
		'image-picker': ImagePicker,
		'text-editor': TextEditor,
	},

    model: {
        prop: 'value',
        event: 'change',
    },

	mixins: [ StringHelper ],
}
</script>