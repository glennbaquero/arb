<template>
	<div>
		<div class="small-box shadow" :class="color">
			<div class="inner">
				<h3>{{ count }}</h3>
				<p>{{ label }}</p>
			</div>
			<div class="icon">
				<i :class="icon"></i>
			</div>
			<a v-if="href" :href="href" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
</template>

<script type="text/javascript">
export default {
	props: {
		icon: String,
		label: String,
		count: {},
		color: String,
		href: String,
	}
}
</script>