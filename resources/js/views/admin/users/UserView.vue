<template>
    <form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
        <card>
            <template v-slot:header>Basic Information</template>
            <div class="row">
                <selector class="col-sm-12 col-md-6"
                v-model="item.user_type"
                name="user_type"
                label="User Type"
                :items="types"
                item-value="value"
                item-text="label"
                empty-text="None"
                placeholder="Please select type of user"
                ></selector>
            </div>
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
                <!-- <div class="form-group col-sm-12 col-md-6">
                    <label>Mobile Number</label>
                    <div class="row">
                        <div class="col-md-1">
                            <vue-country-code @onSelect="onSelect" class="input-sm"></vue-country-code>
                        </div>
                        <div class="col-md-11">
                            <input type="text" name="mobile_number" v-model="item.mobile_number" class="form-control input-sm">
                        </div>
                    </div>
                </div> -->

                <div class="form-group col-sm-12 col-md-6">
                    <label>Mobile Number</label>
                    <vue-phone-number-input v-model="item.mobile_number_component" required default-country-code="PH" size="sm" @update="update" ref="mobile_number" no-example/>
                    <input type="hidden" name="mobile_number" v-model="item.mobile_number">
                    <input type="hidden" name="calling_code" v-model="item.calling_code">
                </div>
                <!-- <contact-number
                v-model="item.mobile_number"
                type="mobile"
                label="Mobile Number"
                name="mobile_number"
                class="col-sm-12 col-md-4"
                ></contact-number> -->

                <!-- <div class="form-group col-sm-12 col-md-6">
                    <label>Username</label>
                    <input v-model="item.username" name="username" type="text" class="form-control input-sm">
                </div> -->
                
<!--                 <image-picker
                class="form-group col-sm-12 col-md-12 mt-2"
                :value="item.renderImage"
                label="Avatar"
                name="image_path"
                placeholder="Choose a File"
                ></image-picker> -->

                <!-- <birthday-picker
                class="col-sm-12 col-md-6"
                label="Birthday"
                name="birthday"
                v-model="item.birthday"
                ></birthday-picker> -->

                <!-- <div class="form-group col-sm-12 col-md-6">
                    <label>Gender</label>
                    <select v-model="item.gender" name="gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div> -->

                <!-- <contact-number
                v-model="item.telephone_number"
                type="telephone"
                label="Telephone Number"
                name="telephone_number"
                class="col-sm-12 col-md-6"
                ></contact-number> -->
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
                :message="'Are you sure you want to archive User #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore User #' + item.id + '?'"
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
import ImagePicker from 'Components/inputs/ImagePicker.vue';
import BirthdayPicker from 'Components/inputs/BirthdayPicker.vue';
import ContactNumber from 'Components/inputs/ContactNumber.vue';

export default {
    methods: {
        fetchSuccess(data) {
            this.item = data.item ? data.item : this.item;
            this.types = data.types ? data.types : this.types;
        },

        update(e) {
            this.item.calling_code = this.$refs['mobile_number'].results.countryCallingCode;
            this.item.mobile_number = e.countryCallingCode+''+e.nationalNumber;
        }
    },

    data() {
        return {
            types: []
        }
    },

    components: {
        'action-button': ActionButton,
        'selector': Select,
        'image-picker': ImagePicker,
        'birthday-picker': BirthdayPicker,
        'contact-number': ContactNumber,
    },

    mixins: [ CrudMixin ],
}
</script>

<style type="text/css">
    .vue-country-select .dropdown-list {
        z-index: 2 !important;
    }
</style>