<template>
	<div>
        <!-- DATATABLE -->
        <data-list
        ref="data-table"
        :filters="filters"
        :fetch-url="fetchUrl"
        :no-action="noAction"
        :disabled="disabled"
        :per-page="12"
        :limits="[12, 16, 20]"
        order-by="created_at"
        order-desc
        auto-scroll
        infinite-scroll
        max-height="80vh"
        @load="load"
        >
            <template v-slot:body="{ items }">
                <div class="container-fluid">
                    <div class="row">
                        <div v-for="(item, index) in items" :key="'sample-' + index" 
                        class="col-12 col-sm-12 col-md-4 col-lg-3 d-flex align-items-stretch mb-4">
                            <div class="card w-100">
                                <div class="card-header">
                                    <span>#{{ item.id }} {{ item.name }}</span>
                                    <span class="float-right"><small>{{ fromNow(item.published_at) }}</small></span>
                                </div>
                                <img :src="item.path" class="img-fluid">
                                <div class="card-body">
                                    <p class="card-text" v-html="item.description"></p>
                                </div>
                                <div class="card-footer text-center text-sm-center text-md-right m-0 p-0">
                                    <a :href="item.showUrl" class="btn btn-sm btn-light btn-block rounded-0">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

        </data-list>

        <loader 
        :loading="loading">
        </loader>
	</div>
</template>

<script type="text/javascript">
import ListMixin from '../../../mixins/list.js';
import DateMixin from '../../../mixins/date.js';
import { bus }from '../../../bus.js';

import DataList from '../../../components/lists/DataList.vue';
import SearchForm from '../../../components/forms/SearchForm.vue';

export default {
    mixins: [ ListMixin, DateMixin ],

    components: {
        'data-list': DataList,
    },
}
</script>