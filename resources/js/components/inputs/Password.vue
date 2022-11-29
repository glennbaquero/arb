<template>
	<div class="form-group">
		<label>{{ label }}</label>
		<div class="input-group">
			<input :placeholder="placeholder" :name="name" :type="hidden ? 'password' : 'text'" class="form-control">
			<div class="input-group-append">
                <button type="button" @click="hidden = !hidden" class="btn btn-light border">
					<i v-if="hidden" class="fa fa-eye-slash"></i>
					<i v-if="!hidden" class="fa fa-eye"></i>
				</button>
            </div>
		</div>
	</div>
</template>

<script type="text/javascript">
export default {
	data() {
		return {
			hidden: true,
		};
	},

	props: {
		name: String,
		label: String,
		placeholder: String,
	}
}
</script>