<template>
	<div class="form-group">
		<label>{{ label }} <small v-if="labelNote" :class="labelNoteClass">{{ labelNote }}</small></label>
		<input v-model="input" @change="change" type="text" :name="name" class="form-control" v-mask="pattern" :placeholder="placeholder">
	</div>
</template>

<script>
export default {
	mounted() {
		this.setup(this.type);
	},

	methods: {
		setup(value) {
			switch(value) {
				case 'mobile':
						this.pattern = '###########';
					break;
				case 'telephone':
						this.pattern = '########';
					break;
			}
		},

		change() {
			this.$emit('change', this.input);
		}
	},

	watch: {
		type(value) {
			this.setup(value);
		},

		value(value) {
			this.input = value;
		},
	},

	data: () => ({
		pattern: '###########',
		input: null,
	}),

	props: {
        items: {},

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

        type: String,
    },

    model: {
        prop: 'value',
        event: 'change', 
    },
}
</script>