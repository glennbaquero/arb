import DocReady from './plugins/doc-ready/index.js';
import { setup } from './scripts/setup.js';
import { home } from './scripts/home.js';
import { about } from './scripts/about.js';

let app = {
	init() {
		setup.init();

		switch(this.getPageSlug()) {
			case 'home':
					home.init();
				break;
			case 'about':
					about.init();
				break;
		}
	},

	getPageSlug() {
		let result = document.head.querySelector('meta[name="page-slug"]');

		if (result) {
		    result = result.content;
		}

		return result;
	},
}

// Run scripts when DOM is ready
docReady(context => {
    app.init();
}, document);

