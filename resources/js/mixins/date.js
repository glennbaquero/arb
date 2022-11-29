export default {
	methods: {
		toDate(value, format = 'MMMM DD, YYYY') {
			let result = '';

			if (moment(new Date(value)).isValid()) {
				result = moment(new Date(value)).format(format);
			}

			return result;
		},

		toTime(value) {
			let result = '';
			
			if (moment(new Date(value)).isValid()) {
				result = moment(new Date(value)).format('HH:mm');
			}

			return result;
		},

		fromNow(value) {
			let result = '';
			
			if (moment(new Date(value)).isValid()) {
				result = moment(new Date(value)).fromNow();
			}

			return result;
		},

		moment() {
			return {
				getPastYear(years = 1) {
					return moment(new Date).subtract(years, 'years').format('YYYY-MM-DD');
				},
			};
		},
	},
}