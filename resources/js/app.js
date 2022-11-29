/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import bootstrap from './bootstrap.js';
import script from './script.js';

import VuejsDialog from 'vuejs-dialog';
Vue.use(VuejsDialog);

import VueTheMask from 'vue-the-mask';
Vue.use(VueTheMask);

import VueCountryCode from "vue-country-code";
Vue.use(VueCountryCode);

import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';

Vue.component('vue-phone-number-input', VuePhoneNumberInput);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('count-listener', require('./components/listeners/CountListener.vue').default);
Vue.component('page-pagination', require('./components/paginations/PagePagination.vue').default);

Vue.component('change-password-form', require('./components/forms/ChangePasswordForm.vue').default);

Vue.component('activity-log-table', require('./views/activity-logs/ActivityLogTable.vue').default);
Vue.component('notification-table', require('./views/notifications/NotificationTable.vue').default);

Vue.component('sample-item-table', require('./views/samples/SampleItemTable.vue').default);
Vue.component('sample-item-view', require('./views/samples/SampleItemView.vue').default);

Vue.component('sandbox', require('./views/sandbox/Sandbox.vue').default);

import developer from './views/developer/index.js';
import admin from './views/admin/index.js';
import web from './views/web/index.js';
import guest from './views/guest/index.js';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import SetupMixin from './mixins/setup.js';

const app = {
	init() {
		this.setup();
	},

	setup() {
		new Vue({
			el: '#app',
			
			mixins: [ SetupMixin ],
		});
	}
}

app.init();
