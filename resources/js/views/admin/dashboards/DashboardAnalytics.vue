<template>
	<div class="row">
		<div class="col-12">
			<date-range
            @change="filter($event)"
            ></date-range>
		</div>
		<div class="col-12 col-sm-12">
			<card>
				<template v-slot:header>Files Uploaded</template>
				
				<div class="row">
					<div class="col-sm-6 col-md-6">
						<chart
						:items="usage_chart"
						type="bar"
						title=""
						use-point-style
						></chart>
					</div>
				</div>
			</card>
		</div>

		<loader :loading="loading"></loader>
	</div>
</template>

<script type="text/javascript">
import FetchMixin from 'Mixins/fetch.js';

import Card from 'Components/containers/Card.vue';
import DateRange from 'Components/datepickers/DateRange.vue';
import Charts from 'Components/charts/Chart.vue';
import BoxWidget from 'Components/widgets/BoxWidget.vue';

export default {
	methods: {
		filter(value) {
			this.filters = value;

			this.$nextTick(() => {
				this.fetch();
			});
		},

		fetchSetup() {
			if (!this.has_fetched) {
				this.fetch();
			}
		},

		fetchSuccess(data) {
			this.usage_chart = data.usage_chart;
		},
	},

	data() {
		return {
			filters: {},
			usage_chart: [],
		}
	},

	props: {
		title: String,
	},

	computed: {
		fetchParams() {
			return this.filters;
		},
	},

	components: {
		'card': Card,
		'date-range': DateRange,
		'chart': Charts,
		'box-widget': BoxWidget,
	},

	mixins: [ FetchMixin ],
}
</script>