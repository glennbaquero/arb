<template>
	<div class="d-inline-block">
		<ul v-show="length > 1" class="pagination">
			<!-- Previous -->
			<li class="page-item" :class="{ 'disabled': 1 == current_page }">
				<a @click="select(current_page - 1)" class="page-link" href="javascript:void(0)">
					<span v-if="prevIcon || prevText"><i :class="prevIcon"></i>{{ prevText }}</span>
					<span v-else>&laquo;</span>
				</a>
			</li>

	        <!-- Select Page -->
			<li v-for="(item, index) in items" class="page-item" :class="{ 'active': current_page === item, 'disabled': item === '...' }" :key="'pagination-' + index">
	            <a @click.prevent="select(item)" class="page-link" href="javascript:void(0)">{{ item }}</a>
	        </li>
			
			<!-- Next -->
			<li class="page-item" :class="{ 'disabled': length == current_page }">
				<a @click="select(current_page + 1)" class="page-link" href="javascript:void(0)">
					<span v-if="nextIcon || nextText"><i :class="nextIcon"></i>{{ nextText }}</span>
					<span v-else>&raquo;</span>
				</a>
			</li>
		</ul>
	</div>
</template>

<script>
export default {
	methods: {
		select(page) {
			if (page >= 1 && page <= this.length) {
				this.current_page = page;
			}
		},

		range(from, to) {
			const range = [];
			from = from > 0 ? from : 1;

			for (let i = from; i <= to; i++) {
				range.push(i);
			}

			return range;
		},
	},

	data() {
		return {
			current_page: 1,
			maxButtons: 33,
		}
	},

	computed: {
		items() {
			const totalVisible = parseInt(this.totalVisible, 10);
			const maxLength = totalVisible;

			if (this.length <= maxLength || maxLength < 1) {
				return this.range(1, this.length);
			}

			const even = maxLength % 2 === 0 ? 1 : 0;
			const left = Math.floor(maxLength / 2);
			const right = this.length - left + 1 + even;

			if (this.value > left && this.value < right) {
				const start = this.value - left + 2;
				const end = this.value + left - 2 - even;
				return [1, '...', ...this.range(start, end), '...', this.length];
			} else if (this.value === left) {
				const end = this.value + left - 1 - even;
				return [...this.range(1, end), '...', this.length];
			} else if (this.value === right) {
				const start = this.value - left + 1;
				return [1, '...', ...this.range(start, this.length)];
			} else {
				return [...this.range(1, left), '...', ...this.range(right, this.length)];
			}
		},
	},

	watch: {
		current_page(value) {
			this.$emit('change', value);
		},
	},

	props: {
		/* Current selected page */
		value: {
			default: 1,
			type: [ Number ],
		},

		/* The length of the pagination component */
		length: {
			default: 0,
			type: Number,
		},

		/* Specify the max total visible pagination numbers */
		totalVisible: {
			type: [ Number, String ],
		},

		/* Specify the icon to use for the prev icon and text */
		prevIcon: String,
		prevText: String,

		/* Specify the icon to use for the next icon text */
		nextIcon: String,
		nextText: String,
	},

	model: {
        prop: 'value',
        event: 'change',
    },
}
</script>