<template>
	<div>
		<div id="chart-holder">
			<canvas ref="elem" id="canvas" :width="width" :height="height"></canvas>
		</div>
	</div>
</template>

<script type="text/javascript">
import Chart from 'chart.js';
import ArrayMixin from 'Mixins/array.js';

export default {
	watch: {
		items(value) {
			if (value) {
				this.initChart(value);
			}
		},
	},
	methods: {
		initChart(array) {
			$('#canvas').remove();
			$('#chart-holder').append('<canvas ref="elem" width="'+this.width+'" height="'+this.height+'" id=canvas></canvas>')
			let ctx = document.getElementById('canvas').getContext("2d");

			let config = {
			    type: this.type,
			    data: {
				    labels: this.array_pluck(array, this.itemLabel),
			        datasets: [{
			            label: this.label,
			            data: this.array_pluck(array, this.itemData),
			            backgroundColor: this.array_pluck(array, this.itemBgColor),
			            borderColor: '#ddd',
			            borderWidth: 1
			        }]
			    },
			    options: {
			        legend: {
			        	display: false,
			        	labels: {
				        	usePointStyle: this.usePointStyle,
			        	}
			        },
			        title: {
			        	display: true,
			        	text: this.title,
			        	position: this.titlePosition,
			        	fontSize: this.fontSize,
			        }
			    }
			};

			let myChart = new Chart(ctx, config);
		},
	},

	props: {
		items: {
			default: [],
			type: Array,
		},

		height: {
			default: 400,
		},

		width: {
			default: 400,
		},

		itemLabel: {
			default: 'label',
			type: String,
		},

		itemData: {
			default: 'data',
			type: String,
		},

		itemBgColor: {
			default: 'backgroundColor',
			type: String,
		},

		label: String,
		title: String,

		fontSize: {
			default: 14,
		},

		titlePosition: {
			default: 'bottom',
			type: String,
		},

		type: {
			default: 'pie',
			type: String,
		},

		usePointStyle: {
			default: false,
			type: Boolean,
		}
	},

	data() {
		return {
			loading:false,
		}
	},

	mixins: [ ArrayMixin ],
}
</script>