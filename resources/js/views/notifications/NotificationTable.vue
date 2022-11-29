<template>
	<div>
        <filter-box @refresh="fetch">
            <template v-slot:left>

                <date-range
                @change="filter($event)"
                ></date-range>

            </template>
            <template v-slot:right>

                <action-button
                v-if="readAllUrl"
                small 
                :action-url="readAllUrl"
                color="btn-primary"
                icon="fa fa-envelope-open"
                title="Read Notifications"
                message="Mark all notifications as read?"
                :disabled="!array_count(items)"
                @load="load"
                @success="updateNotifications"
                >
                    Mark all as Read
                </action-button>

            </template>
        </filter-box>

        <!-- DATATABLE -->
        <data-list
        ref="data-table"
        :headers="headers"
        :filters="filters"
        :fetch-url="fetchUrl"
        :no-action="noAction"
        :disabled="disabled"
        order-by="created_at"
        order-desc
        max-height="78vh"
        infinite-scroll
        @load="load"
        @fetch="init"
        >
            <template v-slot:body="{ items }">
                <div class="fluid-container pr-5">
                    <div v-for="item in items" class="row">
                        <!-- timeline item 1 left dot -->
                        <div class="col-auto text-center flex-column d-none d-sm-flex">
                            <div class="row h-50">
                                <div class="col">&nbsp;</div>
                                <div class="col">&nbsp;</div>
                            </div>
                            <h5 class="m-2">
                                <span class="badge badge-pill" :class="item.read_at ? 'bg-light' : 'bg-success'">&nbsp;</span>
                            </h5>
                            <div class="row h-50">
                                <div class="col">&nbsp;</div>
                                <div class="col">&nbsp;</div>
                            </div>
                        </div>
                        <!-- timeline item 1 event content -->
                        <div class="col py-2">
                            <div class="card" :class="item.read_at ? '' : 'border-success shadow'">
                                <div class="card-body">
                                    <div class="float-right text-muted">{{ item.created_at }}</div>
                                    <h4 class="card-title text-muted">{{ item.title }}</h4>
                                    <p class="card-text">{{ item.message }}</p>

                                    <div class="float-right">
                                        <view-button v-if="item.read_at" :href="item.showUrl" target="_blank">Show Details</view-button>

                                        <action-button
                                        small
                                        :show-alt="item.read_at"
                                        :action-url="item.readUrl"
                                        :alt-action-url="item.unreadUrl"
                                        color="btn-primary"
                                        icon="fas fa-eye"
                                        alt-color="btn-secondary"
                                        alt-icon="fas fa-envelope"
                                        title="Read Notification"
                                        alt-title="Unread Notification"
                                        message="Mark notification as read?"
                                        alt-message="Mark notification as unread?"
                                        :href="item.read_at ? null : item.showUrl"
                                        target="_blank"
                                        :confirm-dialog="item.read_at"
                                        :hide-response="!item.read_at"
                                        :disabled="!item.showUrl && !item.read_at"
                                        @load="load"
                                        @success="updateNotifications"
                                        @error="updateNotifications"
                                        >{{ item.read_at ? 'Unread' : 'Show Details' }}
                                        </action-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

        </data-list>

        <loader :loading="loading"></loader>
	</div>
</template>

<script type="text/javascript">
import ListMixin from '../../mixins/list.js';
import ArrayMixin from '../../mixins/array.js';
import { bus } from '../../bus.js';

import ViewButton from '../../components/buttons/ViewButton.vue';
import ActionButton from '../../components/buttons/ActionButton.vue';
import DateRange from '../../components/datepickers/DateRange.vue';
import DataList from '../../components/lists/DataList.vue';

export default {
    methods: {
        init(data) {
            this.items = data.items;
        },

        updateNotifications() {
            bus.$emit('update-notification-count');
            this.sync();
        },
    },

    computed: {
        headers() {
            return [
                { text: 'Title' },
                { text: 'Message' },
                { text: 'Received Date', value: 'created_at' },
            ];
        }
    },

    data() {
        return {
            items: [],
        }
    },

    props: {
        filterTypes: {},

        readAllUrl: String,
    },

    mixins: [ ListMixin, ArrayMixin ],

    components: {
        'data-list': DataList,
        'view-button': ViewButton,
        'action-button': ActionButton,
        'date-range': DateRange,
    },
}
</script>