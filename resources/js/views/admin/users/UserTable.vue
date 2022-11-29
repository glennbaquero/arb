<template>
    <div>
        <form-request :submit-url="exportUrl" @load="load" submit-on-success method="POST" :action="exportUrl">
            <filter-box @refresh="fetch">
                <template v-slot:left>
                    <action-button v-if="exportUrl" type="submit" :disabled="loading" class="btn-warning mr-2" icon="fa fa-download">Export</action-button>

                    <selector 
                    class="mt-2" 
                    @change="filter($event, 'email_verified_at')" 
                    :items="types" 
                    placeholder="Filter by Status">
                    </selector>

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
        order-by="created_at"
        order-desc
        @load="load"
        >

            <template v-slot:body="{ items }">
                <tr v-for="item in items">
                    <td>{{ item.id }}</td>
                    <td>{{ item.firstname }}</td>
                    <td>{{ item.lastname }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.mobile_number }}</td>
                    <td>{{ item.user_type }}</td>
                    <td>
                        <span :class="item.status_class" class="badge">{{ item.status }}</span>
                        <small>{{ item.verified_at }}</small>
                    </td>
                    <td>{{ item.created_at }}</td>
                    <td>
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
                        :message="'Are you sure you want to archive User #' + item.id + '?'"
                        :alt-message="'Are you sure you want to restore User #' + item.id + '?'"
                        @load="load"
                        @success="sync"
                        ></action-button>
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

import FormRequest from '../../../components/forms/FormRequest.vue';
import SearchForm from '../../../components/forms/SearchForm.vue';
import Selector from '../../../components/inputs/Select.vue';
import ActionButton from '../../../components/buttons/ActionButton.vue';
import ViewButton from '../../../components/buttons/ViewButton.vue';

export default {
    data() {
        return {
            types: [
                { value: 1, label: 'Verified' },
                { value: 2, label: 'Unverified' },
            ]
        }
    },

    computed: {
        headers() {
            return [
                { text: '#', value: 'id' },
                { text: 'First Name', value: 'first_name' },
                { text: 'Last Name', value: 'last_name' },
                { text: 'Email', value: 'email' },
                { text: 'Mobile #', value: 'mobile_number' },
                { text: 'User Type', value: '' },
                { text: 'Status', value: 'status' },
                { text: 'Registration Date', value: 'created_at' },
            ];
        }
    },

    props: {
        filterRoles: {},
        exportUrl: String,
    },

    mixins: [ ListMixin ],

    components: {
        'form-request': FormRequest,
        'selector': Selector,
        'search-form': SearchForm,
        'view-button': ViewButton,
        'action-button': ActionButton,
    },
}
</script>