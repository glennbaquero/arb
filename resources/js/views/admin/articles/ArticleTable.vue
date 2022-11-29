<template>
	<div>
        <filter-box @refresh="fetch">
            <template v-slot:left>
                <date-range
                class="mr-2"
                @change="filter($event)"
                ></date-range>

                <selector
                v-if="filterTypes"
                class="mt-2"
                :items="filterTypes"
                @change="filter($event, 'type')"
                placeholder="Filter by type"
                ></selector>
            </template>
            <template v-slot:right>
                <div class="custom-control custom-switch mr-2">
                    <input v-model="sortable" type="checkbox" class="custom-control-input" id="re-order-btn">
                    <label class="custom-control-label" for="re-order-btn">Re-order</label>
                </div>

                <search-form
                @search="filter($event, 'search')">
                </search-form>
            </template>
        </filter-box>

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
                    <td>{{ item.published_at }}</td>
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
                            :message="'Are you sure you want to archive article #' + item.id + '?'"
                            :alt-message="'Are you sure you want to restore article #' + item.id + '?'"
                            @load="load"
                            @success="sync"
                            ></action-button>
                        </div>
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
import ListMixin from '../../../mixins/list.js';
import { bus }from '../../../bus.js';

import SearchForm from '../../../components/forms/SearchForm.vue';
import DateRange from '../../../components/datepickers/DateRange.vue';
import ActionButton from '../../../components/buttons/ActionButton.vue';
import ViewButton from '../../../components/buttons/ViewButton.vue';
import Select from '../../../components/inputs/Select.vue';
import FormRequest from '../../../components/forms/FormRequest.vue';

export default {
    computed: {
        headers() {
            return [
                { text: '#', value: 'id', },
                { text: 'Name', value: 'name', },
                { text: 'Published At', value: 'published_at', },
                { text: 'Created Date', value: 'created_at', },
            ];
        },
    },

    data: () => ({
        sortable: false,
    }),

    props: {
        filterTypes: {},
        sortUrl: String,
    },

    mixins: [ ListMixin ],

    components: {
        'search-form': SearchForm,
        'view-button': ViewButton,
        'action-button': ActionButton,
        'date-range': DateRange,
        'selector': Select,
        'form-request': FormRequest,
    },
}
</script>