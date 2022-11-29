/**
 * @FormMixin
 * Send Ajax Request with Dialog Confirmation
 */

import ResponseMixin from '../../mixins/response.js';
import LoaderMixin from '../loaders/mixin.js';
import ConfirmProps from '../../mixins/confirm/props.js';
import ConfirmMethods from '../../mixins/confirm/methods.js';

export default {
	methods: {
		/* Execute when vue-dialog is confirmed */
		onDialogSuccess(event, dialog) {
			this.submit(event, dialog);
		},

		/* Execute ajax request */
		submit(event, dialog = null) {
			this.load(true);
	
			let params = this.params;

			/* Get FormData if no parameter is provided in the props */
			if (!this.params) {
				let form = event.target;
				params = new FormData(form);
			}

			axios.post(this.submitUrl, params)
			.then(response => {
				this.$emit('success');

				const data = response.data;
				
				/* Show if has success message */
				if (data.message) {
					// console.log(this.successOptions);
					this.parseSuccess(data.message, data.title, this.options.success)
				}

				/* Additional execution when response is successful */
				this.success(data, event, response);

			}).catch(error => {
				/* Fire emitter on component */
				this.$emit('error');

				/* Display Error message */				
				this.parseError(error, null, this.options.error);

				/* Additional execution when response fails */
				this.error(event, error);
			}).then(() => {
				this.load(false);

				/* Stop loading of vue-dialog */
				if (dialog) {
					dialog.loading(false);
					dialog.close();
				}
			});
		},

		/* Execute when response is successful */
		success(event, data, response) {
			// console.log(event, data, response);
		},

		/* Execute when response fail */
		error(event, error) {
			// console.log(event, error);
		},
	},

	data() {
		return {
			token: null,
		}
	},

	props: {
		/* Action URL */
		submitUrl: String,

		/* Pass an object as the parameter */
		params: {},

		options: {
			default: () => { return {}; },
			type: Object,
		},
	},

	mixins: [ ResponseMixin, LoaderMixin, ConfirmProps, ConfirmMethods ],
}