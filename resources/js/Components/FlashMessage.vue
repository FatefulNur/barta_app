<template>
    <div v-if="message" :class="`text-md text-center text-${color}-700 font-semibold`">
        {{ message }}
    </div>
</template>

<script setup>
const props = defineProps({
    message: {
        type: String,
    },
    type: {
        type: String,
        validator(value) {
            return ['success', 'error'].includes(value)
        },
    },
})
const color = (props.type === 'success') ? 'green' : 'red';
</script>
