import { bus } from '../bus.js';
import LoaderMixin from './loader.js';

import Loader from '../components/loaders/Loader.vue';
import DataTable from '../components/lists/DataTable.vue';
import FilterBox from '../components/containers/FilterBox.vue';

export default {
	methods: {
        /* Add filter to filter object and then fetch */
        filter(event, column = null) {
            if (!this.$refs['data-table'].has_fetched) { return };
            let data = {};

            if (column) {
                data[column] = event;
            } else {
                data = event;
            }

            this.filters = Object.assign(this.filters, data);
            this.fetch();
        },

        /* Call fetch on method on component */
        fetch() {
            this.$refs['data-table'].fetch();
        },

        /* Initial fetch with conditional */
        fetchSetup() {
            if (!this.$refs['data-table'].has_fetched) {
                this.fetch();
            }
        },

        fetchSync() {
            if (this.$refs['data-table'].has_fetched) {
                this.fetch();
            }
        },

        /* Fire event that handle fetching of all visible components */
        sync() {
            bus.$emit('sync-tables');
            this.fetch();
        },
    },

	data() {
		return {
            filters: {},
		}
	},

    computed: {
        /* headers object for list table */
        headers() {
            return [
                //
            ];
        },
    },

	props: {
        fetchUrl: String,

        disabled: {
            default: false,
            type: Boolean,
        },
        
        noAction: {
        	default: false,
        	type: Boolean,
        },
    },

    mixins: [ LoaderMixin ],

    components: {
        'loader': Loader,
        'data-table': DataTable,
        'filter-box': FilterBox,
    },
}