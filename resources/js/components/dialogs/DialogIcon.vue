<template>
	<div>
		<success-icon v-if="type == 'success'"></success-icon>
		<error-icon v-if="type == 'error'"></error-icon>
		<warning-icon v-if="type == 'warning'"></warning-icon>
		<info-icon v-if="type == 'info'"></info-icon>
	</div>
</template>

<script>
import SuccessIcon from '../icons/SuccessIcon.vue';
import ErrorIcon from '../icons/ErrorIcon.vue';
import WarningIcon from '../icons/WarningIcon.vue';
import InfoIcon from '../icons/InfoIcon.vue';

export default {
	props: {
		type: String,
	},

	components: {
		'success-icon': SuccessIcon,
		'error-icon': ErrorIcon,
		'warning-icon': WarningIcon,
		'info-icon': InfoIcon,
	},
}
</script>