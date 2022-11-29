import LoaderMixin from './loader.js';

import Loader from '../components/loaders/Loader.vue';

export default {
	mounted() {
		if (this.canFetch) {
			this.fetch();
		}
	},

	methods: {
        fetch() {
            return new Promise((resolve, reject) => {
                this.load(true);

                axios.post(this.fetchUrl, this.fetchParams)
                .then(response => {
                    this.fireEmitters();
                    this.fetchSuccess(response.data);

                    if (this.autoScroll) {
                        window.scrollTo(0, 0);
                    }

                    resolve();
                }).catch(error => {
                    // console.log(error);
                    reject();
                }).then(() => {
                    this.has_fetched = true;
                    this.load(false);
                });
            });
        },

        fireEmitters() {
            // fire events here
        },

        fetchSuccess(data) {
        	// console.log(data);
        },
    },

    computed: {
        fetchParams() {
            return {

            };
        },

        canFetch() {
            return this.fetchUrl;
        },
    },

    data() {
        return {
            has_fetched: false,
        }
    },

    props: {
		fetchUrl: String,

        autoScroll: {
            default: false,
            type: Boolean,
        },
	},

	components: {
		'loader': Loader,
	},

	mixins: [ LoaderMixin ],
}