import { bus } from '../bus.js';
import FetchMixin from './fetch.js';

import Card from '../components/containers/Card.vue';
import FormRequest from '../components/forms/FormRequest.vue';
import ActionButton from '../components/buttons/ActionButton.vue';

export default {
	methods: {
		/* Sync table when crud is fetched to update any related items */
		fireEmitters() {
            bus.$emit('sync-tables');
        },
	},

	data() {
		return {
			item: {},
		}
	},

	props: {
		fetchUrl: String,
		submitUrl: String,
		sortUrl: String,
	},

	components: {
        'card': Card,
		'form-request': FormRequest,
        'action-button': ActionButton,
	},

	mixins: [ FetchMixin ],
}