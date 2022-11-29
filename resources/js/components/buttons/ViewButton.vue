<template>
	<a :href="href ? href : 'javascript:void(0)'" :class="[!href ? 'disabled' : '', color]" class="btn btn-sm">
        <i v-if="icon" :class="icon"></i>
        <span v-if="$slots.default" class="ml-1">
        	<slot></slot>
        </span>
    </a>
</template>

<script type="text/javascript">
export default {
	props: {
		href: String,

		icon: {
			default: 'fa fa-eye',
			type: String,
		},

		color: {
			default: 'btn-primary',
			type: String,
		},

		link: {
			default: false,
			type: Boolean,
		},
	},
}
</script>