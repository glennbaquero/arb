<template>
    <div>
        <form-request :submit-url="exportUrl" @load="load" submit-on-success method="POST" :action="exportUrl">
            <filter-box @refresh="fetch">
                <template v-slot:left>
                    <action-button v-if="exportUrl" type="submit" :disabled="loading" class="btn-warning mr-2" icon="fa fa-download">Export</action-button>
                </template>
                <template v-slot:right>
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
        order-by="id"
        order-desc
        @load="load"
        >

            <template v-slot:body="{ items }">
                <tr v-for="item in items">
                    <td>{{ item.id }}</td>
                    <td>{{ item.user }}</td>
                    <td>{{ item.usage }}</td>
                    <td>
                        <view-button :href="item.showUrl"></view-button>
                    </td>
                </tr>
            </template>

        </data-table>

        <loader :loading="loading"></loader>
    </div>
</template>

<script type="text/javascript">
import ListMixin from 'Mixins/list.js';

import SearchForm from 'Components/forms/SearchForm.vue';
import ActionButton from 'Components/buttons/ActionButton.vue';
import ViewButton from 'Components/buttons/ViewButton.vue';
import Select from 'Components/inputs/Select.vue';
import DateRange from 'Components/datepickers/DateRange.vue';
import FormRequest from 'Components/forms/FormRequest.vue';

export default {
    computed: {
        headers() {
            let array = [
                { text: '#', value: 'id' },
                { text: 'User', value: 'user' },
                { text: 'Storage used', value: '' },
            ];

            return array;
        },
    },

    props: {
        hideParent: {
            default: false,
            type: Boolean,
        },

        hideButtons: {
            default: false,
            type: Boolean,
        },

        exportUrl: String
    },

    mixins: [ ListMixin ],

    components: {
        'search-form': SearchForm,
        'view-button': ViewButton,
        'action-button': ActionButton,
        'selector': Select,
        'date-range': DateRange,
        'form-request': FormRequest,
    },
}
</script>