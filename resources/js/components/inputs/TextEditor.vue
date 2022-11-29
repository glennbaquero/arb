<template>
    <div class="form-group">
        <label v-if="label">{{ label }} <small v-if="note">({{ note }})</small></label>
        <textarea ref="elem" :name="name" type="text" class="form-control input-sm">{{ value }}</textarea>
    </div>
</template>

<script>
require('../../plugins/ckeditor/index.js');
import { UploadAdapter } from '../../plugins/ckeditor/UploadAdapter.js';

export default {
    mounted() {
        this.setup();
    },

    watch: {
        value(newValue, oldValue) {
            if (!newValue && this.has_set) {
                this.has_set = false;
            }

            if (!oldValue && !this.has_set) {

                if (!newValue) {
                    newValue = '';
                }

                this.has_set = true;

                if (this.editor) {
                    this.editor.setData(newValue);
                }
            }
        },
    },

    methods: {
        setup() {
            ClassicEditor
            .create(this.$refs.elem, {
                placeholder: this.placeholder,
                extraPlugins: [ this.uploadAdapterPlugin ],
            })
            .then(editor => {
                this.editor = editor;

                this.editor.model.document.on('change:data', (event, name) => {
                    this.has_set = true;
                    this.$emit('change', this.editor.getData());
                });
            }).catch(error => {
                console.log(error);
            });
        },

        uploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new UploadAdapter(loader);
            };
        },
    },

    props: {
        name: {
            type: String,
        },

        label: {
            type: String,
        },

        placeholder: {
            type: String,
        },

        value: {},
        note: {},
    },

    model: {
        prop: 'value',
        event: 'change',
    },

    data() {
        return {
            editor: null,
            has_set: false,
        }
    }
}
</script>

<style type="text/css">
.ck.ck-content.ck-editor__editable {
    min-height: 200px;
    /* max-height: 200px; */
}
</style>