<template>
    <form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
        <card>
            <template v-slot:header>Basic Information</template>
            <div class="row">
                <div class="form-group col-sm-12 col-md-6">
                    <label>First Name</label>
                    <input v-model="item.first_name" name="first_name" type="text" class="form-control input-sm">
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label>Last Name</label>
                    <input v-model="item.last_name" name="last_name" type="text" class="form-control input-sm">
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label>Email Address</label>
                    <input v-model="item.email" name="email" type="text" class="form-control input-sm">
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label>Mobile Number</label>
                    <input v-model="item.mobile_number" name="mobile_number" type="text" class="form-control input-sm">
                </div>

                <image-picker
                class="form-group col-sm-12 col-md-12 mt-2"
                :value="item.renderImage"
                label="Avatar"
                name="image_path"
                placeholder="Choose a File"
                ></image-picker>
            </div>
            
            <template v-slot:footer>
                <action-button type="submit" :disabled="loading" class="btn-primary">Save Changes</action-button>
                
                <action-button
                v-if="item.archiveUrl && item.restoreUrl"
                color="btn-danger"
                alt-color="btn-warning"
                :action-url="item.archiveUrl"
                :alt-action-url="item.restoreUrl"
                label="Archive"
                alt-label="Restore"
                :show-alt="item.deleted_at"
                confirm-dialog
                title="Archive Item"
                alt-title="Restore Item"
                :message="'Are you sure you want to archive Supervisor #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Supervisor #' + item.id + '?'"
                :disabled="loading"
                @load="load"
                @success="fetch"
                ></action-button>
            </template>
        </card>

        <loader :loading="loading"></loader>

    </form-request>
</template>

<script type="text/javascript">
import CrudMixin from 'Mixins/crud.js';

import ActionButton from 'Components/buttons/ActionButton.vue';
import Select from 'Components/inputs/Select.vue';
import ImagePicker from 'Components/inputs/ImagePicker.vue'

export default {
    methods: {
        fetchSuccess(data) {
            this.item = data.item ? data.item : this.item;
        },
    },

    props: {
        editable: {
            default: true,
        },
    },

    data() {
        return {
            //
        }
    },

    components: {
        'action-button': ActionButton,
        'selector': Select,
        'image-picker': ImagePicker,
    },

    mixins: [ CrudMixin ],
}
</script>