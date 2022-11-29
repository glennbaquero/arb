<template>
    <div>
        <filter-box @refresh="fetch">
            <template v-slot:left>
                <date-range
                class="mr-2"
                @change="filter($event)"
                ></date-range>

                <selector 
                class="mt-2" 
                v-if="filterTypes"
                :items="filterTypes"
                @change="filter($event, 'subject_type')"
                placeholder="Filter by type"
                no-search
                ></selector>
            </template>
            <template v-slot:right>
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
        @load="load"
        >

            <template v-slot:body="{ items }">
                <tr v-for="item in items">
                    <td>{{ item.id }}</td>
                    <td v-if="showSubject">
                        <span class="badge badge-secondary">{{ item.subject_type }}</span>
                        <p v-if="item.subject_name">{{ item.subject_name }}</p>
                    </td>
                    <td>{{ item.name }}</td>
                    <td v-if="!hideCauser">
                        <a :href="item.show_causer" class="btn btn-link" :class="!item.show_causer ? 'disabled' : ''" target="_blank">
                            {{ item.caused_by }}
                        </a>
                    </td>
                    <td>{{ item.created_at }}</td>
                    <td v-if="!noAction">
                        <view-button :href="item.showUrl"></view-button>
                    </td>
                </tr>
            </template>

        </data-table>

        <loader :loading="loading"></loader>
    </div>
</template>

<script type="text/javascript">
import ListMixin from '../../mixins/list.js';

import SearchForm from '../../components/forms/SearchForm.vue';
import ViewButton from '../../components/buttons/ViewButton.vue';
import DateRange from '../../components/datepickers/DateRange.vue';
import Select from '../../components/inputs/Select.vue';

export default {
    computed: {
        headers() {
            let array = [
                { text: '#', value: 'id', },
            ];

            if (this.showSubject) {
                array.push({ text: 'Subject', value: 'subject_type', });
            }

            array.push({ text: 'Description', value: 'description', });

            if (!this.hideCauser) {
                array.push({ text: 'Caused By', value: 'causer_type', });
            }

            array.push({ text: 'Created Date', value: 'created_at', });

            return array;
        },
    },

    props: {
        filterTypes: {},

        hideCauser: {
            default: false,
            type: Boolean,
        },

        showSubject: {
            default: false,
            type: Boolean,
        },
    },

    mixins: [ ListMixin ],

    components: {
        'search-form': SearchForm,
        'view-button': ViewButton,
        'date-range': DateRange,
        'selector': Select,
    },
}
</script>