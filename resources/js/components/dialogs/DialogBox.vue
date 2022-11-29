<template>
	<div ref="modal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="card bg-white">
					<div class="card-header text-center bg-white border-0 pb-0">
						<h1 class="d-inline-block mt-2">
							<dialog-icon
							:type="response.type"
							></dialog-icon>
						</h1>
						<button @click="close" type="button" class="float-right close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div v-html="message" class="card-body pt-3" :class="message_option.class"></div>
					<div v-if="array_count(buttons) > 0 || !options.hideCloseButton" class="card-footer bg-white border-0 text-center">
						<button 
						v-if="!options.hideCloseButton"
			    		type="button" 
			    		class="btn btn-dark" 
			    		@click="close">
				    		Continue
				    	</button>

						<template v-for="button in buttons">
							<button 
							v-if="button.closes"
				    		:type="button.type" 
				    		:class="button.class" 
				    		@click="submit(button)">
					    		<span :class="button.icon"></span>
					    		{{ button.label }}
					    	</button>
						</template>
				    	
				    </div>
				</div>
				
			</div>
		</div>
	</div>
</template>

<script>
import { bus } from '../../bus.js';
import ArrayMixin from '../../mixins/array.js';
import DialogIcon from './DialogIcon.vue';

export default {
	mounted() {
		this.element = $(this.$refs.modal);

		this.element.on('hidden.bs.modal', (e) => {
			this.emit();
		})

		bus.$on('show-dialog', (data) => {
			this.title = data.title;
			this.type = data.type;
			this.message = data.message;
			this.options = data.options ? data.options : {};

			if (!this.options.closeButtonLabel) {
				this.options.closeButtonLabel = 'Continue';
			}

			this.$nextTick(() => {
				this.setButtons(this.options.buttons);
				this.setMessage(this.options.message);

				this.response = this.getResponse(data.type);
			});

			this.$nextTick(() => {
				this.show();
			});
		});
	},

	methods: {
		submit(button) {
			return button.closes ? this.close() : button.action();
		},

		show() {
			this.element.modal('show');
		},

		close() {
			this.element.modal('hide');
		},

		emit() {
			bus.$emit('hide-dialog');
		},

		setButtons(buttons) {
			this.buttons = [];

			if (this.array_count(buttons) > 0) {
				buttons.forEach(button => {
					button.type = button.type ? button.type : 'button';
					button.label = button.label ? button.label : '';
					button.icon = button.icon ? button.icon : '';
					button.class = button.class ? button.class : '';
					button.action = button.action ? button.action : () => {};
					button.closes = button.closes ? button.closes : false;

					this.buttons.push(button);
				});
			}
		},

		setMessage(message_option) {
			if (message_option) {
				this.message_option.class = message_option.class;
			}
		},

		getResponse(type) {
			let result = {};

			switch(type) {
				case 'error':
					result = {
						class: 'text-white bg-danger',
						icon: 'fas fa-times',
						type: 'error',
					};
					break;
				case 'warning':
					result = {
						class: 'text-white bg-warning',
						icon: 'fas fa-exclamation-triangle',
						type: 'warning',
					};
					break;
				case 'success':
					result = {
						class: 'text-white bg-success',
						icon: 'fas fa-check-circle',
						type: 'success',
					};
					break;
				case 'info':
					result = {
						class: 'text-white bg-info',
						icon: 'fas fa-question-circle',
						type: 'info',
					};
					break;
			}

			return result;
		},
	},

	data() {
		return {
			response: {},
			message_option: {},
			element: null,
			title: null,
			message: null,
			type: null,
			options: {},
			buttons: [],
		}
	},

	components: {
		'dialog-icon': DialogIcon,
	},

	mixins: [ ArrayMixin ],
}
</script>