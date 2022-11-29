<template>
	<form @submit.prevent="showConfirm" method="GET" action="javascript:void(0)">
		<input v-if="token" type="hidden" name="_token" v-model="token">

		<slot></slot>
	</form>
</template>

<script type="text/javascript">
import FormMixin from './mixin.js';
import { bus } from '../../bus.js';

export default {
	mounted() {
		this.setup();
	},

	methods: {
		setup() {
			/* Get CSRF Token */
			if (this.submitOnSuccess) {
				let token = document.head.querySelector('meta[name="csrf-token"]');

				if (token) {
				    this.token = token.content;
				} else {
				    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
				}
			}
		},

		success(data, event, response) {
			/* Non-ajax form submit */
			if (this.submitOnSuccess) {
				setTimeout(() => {
					event.target.submit();
				}, 500);
				return;
			}

			/* Redirect to url */
			if (data.redirect) {
				window.location.href = data.redirect;
				return;
			}

			/* Reset form on success */
			if (this.resetOnSuccess) {
				event.target.reset();
			}

			/* Fire Emitter to Sync other data tables */
			if (this.syncOnSuccess) {
				bus.$emit('sync-tables');
			}
		},
	},

	data() {
		return {
			token: null,
		}
	},

	props: {
		/* Non-ajax form submit */
		submitOnSuccess: {
			default: false,
			type: Boolean,
		},

		/* Reset form on success */
		resetOnSuccess: {
			default: false,
			type: Boolean,
		},

		/* Fire Emitter to Sync other data tables */
		syncOnSuccess: {
			default: false,
			type: Boolean,
		},
	},

	mixins: [ FormMixin ],
}
</script>