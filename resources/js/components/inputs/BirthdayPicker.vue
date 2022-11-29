<template>
	<div class="form-group">
		<label>{{ label }} <small v-if="labelNote" :class="labelNoteClass">{{ labelNote }}</small></label>
		<div class="row no-gutters">
			<div class="col-6 pr-2">
				<select v-model="month" @change="change" class="form-control" :disabled="disabled">
					<option :value="null" hidden>Month</option>
					<option v-for="month in months" :value="month.value">{{ month.text }}</option>
				</select>
			</div>
			<div class="col-2">
				<input v-model="day" @change="change" type="text" class="form-control" placeholder="Day" :disabled="disabled" v-mask="'##'">
			</div>
			<div class="col-4 pl-2">
				<input v-model="year" @change="change" type="text" class="form-control" placeholder="Year" :disabled="disabled" v-mask="'####'">
			</div>

			<input v-model="birthday" type="hidden" readonly :name="name">
		</div>
	</div>
</template>

<script>
import DateMixin from '../../mixins/date.js';

export default {
	methods: {
		change() {
			let result = '';
			let valid = 0;

			if (this.year) {
				result += this.year;
				valid++;
			}

			if (this.month) {
				result += '-' + this.month;
				valid++;
			}

			if (this.day) {
				result += '-' + this.day;
				valid++;
			}

			if (moment(result).isValid() && valid > 2) {
				this.birthday = this.toDate(result, 'YYYY-MM-DD');
				this.$emit('change', this.toDate(result, 'YYYY-MM-DD'));
			} else {
				this.birthday = '';
			}

		},
	},

	watch: {
		value(value) {
			this.birthday = this.toDate(value, 'YYYY-MM-DD');
			this.year = this.toDate(value, 'YYYY');
			this.month = this.toDate(value, 'MM');
			this.day = this.toDate(value, 'DD');
		},
	},

	props: {
		value: {},

        name: {
            default: null,
            type: String,
        },

        label: String,
        labelNote: String,
        labelNoteClass: {
            default: 'text-danger',
            type: String,
        },

        placeholder: String,
        emptyText: String,

        disabled: {
            default: false,
            type: Boolean,
        },
	},

	data: () => ({
		month: null,
		day: null,
		year: null,
		birthday: null,

		months: [
			{ value: '01', text: 'January' },
			{ value: '02', text: 'February' },
			{ value: '03', text: 'March' },
			{ value: '04', text: 'April' },
			{ value: '05', text: 'May' },
			{ value: '06', text: 'June' },
			{ value: '07', text: 'July' },
			{ value: '08', text: 'August' },
			{ value: '09', text: 'September' },
			{ value: '10', text: 'October' },
			{ value: '11', text: 'November' },
			{ value: '12', text: 'December' },
		],
	}),

    model: {
        prop: 'value',
        event: 'change', 
    },

    mixins: [ DateMixin ],
}
</script>