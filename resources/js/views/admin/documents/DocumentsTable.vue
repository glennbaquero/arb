<template>
    <div>
        <filter-box @refresh="fetch">
            <template v-slot:left>
            </template>
            <template v-slot:right>

                <search-form
                @search="filter($event, 'search')">
                </search-form>

            </template>
        </filter-box>

        <!-- DATATABLE -->
        <data-table
        ref="data-table"
        :headers="headers"
        :filters="filters"
        :fetch-url="fetchUrl"
        :no-action="noAction"
        :disabled="disabled"
        order-by="id"
        order-desc
        @load="load"
        >

            <template v-slot:body="{ items }">
                <tr v-for="item in items" >
                    <td>{{ item.id }}</td>
                    <td>{{ item.user }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.file_name }}</td>
                    <td>{{ item.file_type }}</td>
                    <td>{{ item.created_at }}</td>
                    <td>
                        <view-button :href="item.showUrl"></view-button>
                        
                        <action-button
                        v-if="!hideButtons"
                        small 
                        color="bg-green"
                        :action-url="item.approveUrl"
                        icon="fas fa-check"
                        confirm-dialog
                        :disabled="loading"
                        title="Approved Document"
                        :message="'Are you sure you want to approve this document #' + item.id + '?'"
                        @load="load"
                        @success="sync"
                        ></action-button>

                        <!-- <action-button
                        v-if="!hideButtons"
                        small 
                        color="btn-danger"
                        :action-url="item.rejectUrl"
                        icon="fas fa-times"
                        confirm-dialog
                        :disabled="loading"
                        title="Archive Item"
                        :message="'Are you sure you want to reject this document #' + item.id + '?'"
                        @load="load"
                        @success="sync"
                        ></action-button> -->

                        <button v-if="!hideButtons" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-default" @click="showModal(item)"><i class="fas fa-times"></i></button>

                        <!-- <action-button
                        v-if="!hideButtons"
                        small 
                        color="btn-danger"
                        alt-color="btn-warning"
                        :show-alt="item.deleted_at"
                        :action-url="item.archiveUrl"
                        :alt-action-url="item.restoreUrl"
                        icon="fas fa-trash"
                        alt-icon="fas fa-trash-restore-alt"
                        confirm-dialog
                        :disabled="loading"
                        title="Archive Item"
                        alt-title="Restore Item"
                        :message="'Are you sure you want to archive FAQ #' + item.id + '?'"
                        :alt-message="'Are you sure you want to restore FAQ #' + item.id + '?'"
                        @load="load"
                        @success="sync"
                        ></action-button> -->
                    </td>
                </tr>
            </template>

        </data-table>
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Reason</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <text-editor
                            class="col-sm-12"
                            label=" "
                            v-model="selected.rejected_reason"
                            name="rejected_reason"
                            row="5"
                            ></text-editor>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger btn-sm" @click="showConfirmation">
                                <i class="fas fa-times"></i>
                                Reject
                            </button>
                            <!-- <action-button
                            v-if="!hideButtons"
                            small 
                            color="btn-danger"
                            :action-url="item.rejectUrl"
                            icon="fas fa-times"
                            label="Reject"
                            :icon-visibility="false"
                            confirm-dialog
                            :disabled="loading"
                            title="Archive Item"
                            :message="'Are you sure you want to reject this document #' + item.id + '?'"
                            @load="load"
                            @success="sync"
                            ></action-button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <loader :loading="loading"></loader>
    </div>
</template>

<script type="text/javascript">
import ListMixin from 'Mixins/list.js';

import ResponseHandler from 'Mixins/response.js';
import ConfirmMethods from 'Mixins/confirm/methods.js';

import SearchForm from 'Components/forms/SearchForm.vue';
import ActionButton from 'Components/buttons/ActionButton.vue';
import ViewButton from 'Components/buttons/ViewButton.vue';
import TextEditor from 'Components/inputs/TextEditor.vue';

export default {
    methods: {
        showModal(item) {
            this.selected = item;
        },

        showConfirmation() {
            this.showConfirm();
        },

        onDialogSuccess(event, dialog) {
            this.rejectDocument();
        },

        rejectDocument() {
            this.loading = true;
            var data = {
              'rejected_reason': this.selected.rejected_reason
            };

            axios.post(this.selected.rejectUrl, data)
              .then(response => {
                this.parseSuccess(response.data.message);
                this.fetch();
                this.loading = false;
                $('#modal-default').modal('toggle');
              }).catch(error => {
                this.parseError(error);
                this.$emit('error');
                this.loading = false;
              })
        }
    },

    computed: {
        headers() {
            let array = [
                { text: '#', value: 'id' },
                { text: 'User', value: 'user' },
                { text: 'Email', value: 'email' },
                { text: 'File Name', value: 'file_name' },
                { text: 'File Type', value: 'file_type' },
            ];


            array = array.concat([
                { text: 'Created Date', value: 'created_at' },
            ]);

            return array;
        },
    },

    data() {
        return {
            selected: {}
        }
    },

    props: {
        hideParent: {
            default: false,
            type: Boolean,
        },

        hideButtons: {
            default: false,
            type: Boolean,
        },
    },

    mixins: [ ListMixin, ResponseHandler, ConfirmMethods ],

    components: {
        'search-form': SearchForm,
        'view-button': ViewButton,
        'action-button': ActionButton,
        'text-editor': TextEditor,
    },
}
</script>