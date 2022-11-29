<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
		<meta-form
		:item="meta"
		></meta-form>

		<card>
			<template v-slot:header>Basic Information</template>

			<div class="row">
				<div class="form-group col-sm-12 col-md-6">
					<label>Name</label>
					<input v-model="item.name" name="name" type="text" class="form-control">
				</div>

				<date-picker
				v-model="item.published_at"
				class="form-group col-sm-12 col-md-6"
				label="Published Date"
				name="published_at"
				placeholder="Choose a date"
				></date-picker>
			</div>

			<div class="row">
				<text-editor
				v-model="item.description"
				class="col-sm-12"
				label="Description"
				name="description"
				row="5"
				></text-editor>
			</div>
			
			<div class="row">

				<image-picker
				:value="item.path"
				class="form-group col-sm-12 col-md-12 mt-2"
                label="Image"
                name="image_path"
                placeholder="Choose a File"
				></image-picker>

				<image-picker
				:value="images"
				class="form-group col-sm-12 col-md-12 mt-2"
	            label="Images"
	            name="images[]"
	            placeholder="Choose Files"
	            multiple
	            sortable
	            :sort-url="sortUrl"
	            :remove-url="item.removeImageUrl"
	            @remove="fetch"
	            max="3"
	            min="1"
				></image-picker>

			</div>

			<template v-slot:footer>
				<action-button type="submit" :disabled="loading" class="btn-primary">Save Changes</action-button>
            
                <action-button
                v-if="item.archiveUrl && item.restoreUrl"
                color="btn-danger"
                alt-color="btn-warning"
                :action-url="item.archiveUrl"
                :alt-action-url="item.restoreUrl"
                label="Archive"
                alt-label="Restore"
                :show-alt="item.deleted_at"
                confirm-dialog
                title="Archive Item"
                alt-title="Restore Item"
                :message="'Are you sure you want to archive article #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore article #' + item.id + '?'"
                :disabled="loading"
                @load="load"
                @success="fetch"
                @error="fetch"
                ></action-button>
			</template>
		</card>

		<loader :loading="loading"></loader>
		
	</form-request>
</template>

<script type="text/javascript">
import { bus }from '../../../bus.js';
import CrudMixin from '../../../mixins/crud.js';

import MetaForm from '../../../components/forms/MetaForm.vue';

import ActionButton from '../../../components/buttons/ActionButton.vue';
import Select from '../../../components/inputs/Select.vue';
import ImagePicker from '../../../components/inputs/ImagePicker.vue';
import TextEditor from '../../../components/inputs/TextEditor.vue';
import Datepicker from '../../../components/datepickers/Datepicker.vue';

export default {
	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.meta = data.meta ? data.meta : this.meta;
			this.images = data.images ? data.images : this.images;
		},
	},

	data() {
		return {
			items: [],
			images: [],
			meta: {},
		}
	},

	components: {
		'meta-form': MetaForm,
		'action-button': ActionButton,
		'selector': Select,
		'image-picker': ImagePicker,
		'text-editor': TextEditor,
		'date-picker': Datepicker,
	},

	mixins: [ CrudMixin ],
}
</script>