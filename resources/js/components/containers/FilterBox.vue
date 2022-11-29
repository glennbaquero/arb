<template>
	<div class="row mb-2">
        <!-- FILTERS -->
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-12 form-inline">
                    <button v-if="!hideRefresh" @click="refresh" type="button" class="btn btn-light border mr-2"><i class="fas fa-sync-alt"></i></button>
                    <slot name="left"></slot>
                </div>
            </div>
        </div>

        <div class="col-sm-4 d-flex justify-content-end">
            <div class="row">
                <div class="col-sm-12 justify-content-end form-inline">
                	<slot name="right"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        refresh() {
            this.$emit('refresh');
        },
    },

    props: {
        hideRefresh: {
            default: false,
            type: Boolean,
        },
    },
}
</script>