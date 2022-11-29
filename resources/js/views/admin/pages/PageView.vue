<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
		<card>
			<template v-slot:header>Basic Information</template>
			<div class="row">
				<div class="form-group col col-sm-12 col-md-6">
					<label>Name</label>
					<input v-model="item.name" name="name" type="text" class="form-control input-sm">
				</div>

				<div class="form-group col col-sm-12 col-md-6">
					<label>Slug <small class="text-danger">(Warning: editing this may cause issues)</small></label>
					<input v-model="item.slug" name="slug" type="text" class="form-control input-sm">
				</div>
			</div>
	    </card>

		<meta-form
		:item="meta"
		></meta-form>

	    <card>
	    	<template v-slot:header>Page Content</template>

			<page-item-content 
			v-if="array_count(page_items)"
			v-for="page_item in page_items" :key="page_item.id" 
			v-model="page_item.content"
			:type="page_item.type" 
			:name="'content[' + page_item.id + ']'" 
			:label="page_item.name"
			:note="page_item.slug"
			></page-item-content>
	    </card>

	    <div class="row mb-5">
	    	<div class="col-sm-12 text-right">
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
                :message="'Are you sure you want to archive Page #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Page #' + item.id + '?'"
                :disabled="loading"
                @load="load"
                @success="fetch"
                ></action-button>
	    	</div>
	    </div>

	    <loader :loading="loading"></loader>
	    
	</form-request>
</template>

<script type="text/javascript">
import CrudMixin from '../../../mixins/crud.js';
import ArrayMixin from '../../../mixins/array.js';

import ActionButton from '../../../components/buttons/ActionButton.vue';
import MetaForm from '../../../components/forms/MetaForm.vue';
import PageItemContent from './PageItemContent.vue';

export default {
	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.meta = data.meta ? data.meta : this.meta;
			this.page_items = data.page_items ? data.page_items : this.page_items;
		}
	},

	data() {
		return {
			page_items: [],
			meta: {},
		}
	},

	components: {
		'action-button': ActionButton,
		'meta-form': MetaForm,
		'page-item-content': PageItemContent,
	},

	mixins: [ CrudMixin, ArrayMixin ],
}
</script>