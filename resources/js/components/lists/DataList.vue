<template>
	<div>

        <!-- Body Slot -->

        <!-- Infinite Scroll Body -->
        <div v-if="infiniteScroll" @scroll="scroll" :style="'max-height:' + maxHeight + '; overflow-y: auto;'">
	        <slot name="body" :items="items"></slot>

	        <div v-if="array_count(items) && infiniteScroll && is_last_page" class="text-center">
	        	<p>{{ endText }}</p>
	        </div>
	    </div>

	    <!-- Pagination Body -->
	    <template v-else>
	    	<slot name="body" :items="items"></slot>
	    </template>

        <!-- Empty list -->
        <div class="text-center mt-3">
        	<p v-if="!array_count(items) && !loading">{{ emptyText }}</p>
        </div>

	    <!-- List Pagination -->
	    <div v-if="array_count(items) && !infiniteScroll">
		    <div class="row">
		    	<div class="col-12 col-md-6 mb-3">
		    		<div class="d-flex align-items-center form-inline">
		    			<label>Show</label>
			    		<select v-model="limit" class="form-control d-inline-block mx-2">
			    			<option v-for="limit in limits" :value="limit">{{ limit }}</option>
			    		</select>
			    		<label>Entries</label>
		    		</div>
		    	</div>
		    	<div class="col-12 col-md-6 text-sm-left text-md-right">
		    		<pagination
					v-model="page"
					:total-visible="totalVisible"
					:length="pagination.last_page"
					></pagination>
		    	</div>
		    </div>
		    <div class="row">
		    	<div class="col-12 col-md-6 d-flex align-items-center">
		    		<p class="mb-0">Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }}</p>
		    	</div>
		    	<div class="col-12 col-md-6 text-sm-left text-md-right">
		    		<div v-if="pagination.last_page > 1" class="d-inline-flex form-inline">
		    			<label>Go to Page:</label>
			    		<select v-model="page" class="form-control ml-2">
			    			<option v-for="page_number in pagination.last_page" :value="page_number">{{ page_number }}</option>
			    		</select>
		    		</div>
		    	</div>
		    </div>
	    </div>

	</div>
</template>

<script>
import ListMixin from './mixin.js';

export default {
	mixins: [ ListMixin ],
}
</script>