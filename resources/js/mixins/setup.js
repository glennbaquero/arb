export default {
	methods: {
		initList(component) {
			let element = this.$refs[component];
			
			if (element) {
				if(!element.has_fetched) {
					element.fetchSetup();
				}
			}
		},
	},
}