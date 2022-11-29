<template>
	<div>
        <form-request :submit-url="exportUrl" @load="load" submit-on-success method="POST" :action="exportUrl">
            <filter-box @refresh="fetch">
                <template v-slot:left>
                    <action-button v-if="exportUrl" type="submit" :disabled="loading" class="btn-warning mr-2" icon="fa fa-download">Export</action-button>

                    <date-range
                    class="mr-2"
                    @change="filter($event)"
                    ></date-range>

                    <selector
                    v-if="filterStatus"
                    class="mt-2"
                    :items="filterStatus"
                    @change="filter($event, 'status')"
                    placeholder="Filter by status"
                    ></selector>
                </template>
                <template v-slot:right>
                    <div class="custom-control custom-switch mr-3">
                        <input v-model="sortable" type="checkbox" class="custom-control-input" id="re-order-btn">
                        <label class="custom-control-label" for="re-order-btn">Re-order</label>
                    </div>
                    
                    <search-form
                    @search="filter($event, 'search')">
                    </search-form>
                </template>
            </filter-box>
        </form-request>

        <!-- DATATABLE -->
        <data-table
        ref="data-table"
        :headers="headers"
        :filters="filters"
        :fetch-url="fetchUrl"
        :no-action="noAction"
        :disabled="disabled"
        order-by="created_at"
        order-desc
        :sortable="sortable"
        :sort-url="sortUrl"
        @load="load"
        >
            <template v-slot:body="{ items }">
                <tr v-for="item in items" :data-id="item.id">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td><span class="badge" :class="item.status_class">{{ item.status }}</span></td>
                    <td>{{ item.created_at }}</td>
                    <td v-if="!noAction">

                        <div class="mb-2">
                            <view-button :href="item.showUrl"></view-button>
                            
                            <action-button
                            small 
                            color="btn-danger"
                            alt-color="btn-warning"
                            :show-alt="item.deleted_at"
                            :action-url="item.archiveUrl"
                            :alt-action-url="item.restoreUrl"
                            icon="fas fa-trash"
                            alt-icon="fas fa-trash-restore-alt"
                            confirm-dialog
                            :disabled="loading"
                            title="Archive Item"
                            alt-title="Restore Item"
                            :message="'Are you sure you want to archive sample item #' + item.id + '?'"
                            :alt-message="'Are you sure you want to restore sample item #' + item.id + '?'"
                            @load="load"
                            @success="sync"
                            ></action-button>
                        </div>

                        <sample-item-buttons 
                        v-if="!item.deleted_at" 
                        @load="load" 
                        @success="update" 
                        :item="item" 
                        small
                        ></sample-item-buttons>
                    </td>
                </tr>
            </template>

        </data-table>

        <loader 
        :loading="loading">
        </loader>
	</div>
</template>

<script type="text/javascript">
import ListMixin from '../../mixins/list.js';
import { bus }from '../../bus.js';

import SearchForm from '../../components/forms/SearchForm.vue';
import DateRange from '../../components/datepickers/DateRange.vue';
import ActionButton from '../../components/buttons/ActionButton.vue';
import ViewButton from '../../components/buttons/ViewButton.vue';
import Select from '../../components/inputs/Select.vue';
import FormRequest from '../../components/forms/FormRequest.vue';
import SampleItemButtons from './SampleItemButtons.vue';

export default {
    mounted() {
        // this.listen();
    },

    methods: {
        init(data) {
            // console.log(data);
        },
        
        update() {
            bus.$emit('update-sample-item-count');
            this.fetchSync();
        },

        listen() {
            if (process.env.MIX_PUSHER_APP_ENABLED) {

                // Echo.channel('admin')
                // .listen('.sample.changed', (data) => {
                //     this.update();
                // });
            }
        },
    },

    data: () => ({
        sortable: false,
    }),

    computed: {
        headers() {
            return [
                { text: '#', value: 'id', },
                { text: 'Name', value: 'name', },
                { text: 'Status', value: 'status', },
                { text: 'Created Date', value: 'created_at', },
            ];
        },
    },

    props: {
        filterStatus: {},
        exportUrl: String,
        sortUrl: String,
    },

    components: {
        'search-form': SearchForm,
        'view-button': ViewButton,
        'action-button': ActionButton,
        'date-range': DateRange,
        'selector': Select,
        'form-request': FormRequest,
        'sample-item-buttons': SampleItemButtons,
    },

    mixins: [ ListMixin ],
}
</script>