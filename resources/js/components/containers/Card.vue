<template>
	<div v-if="$slots['header'] || $slots['default'] || $slots['footer']" class="card shadow-sm">
        <div v-show="$slots['header']" class="card-header">
            <h5 class="font-weight-bold m-0"><slot name="header"></slot></h5>
        </div>

        <div v-show="$slots['default']" class="card-body">
			<slot></slot>
        </div>
		
		<div v-show="$slots['footer']" class="card-footer">
        	<div class="float-right">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</template>