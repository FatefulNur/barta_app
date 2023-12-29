<template>
    <div v-if="message"
        :class="`p-2 text-md text-center text-${color}-700 bg-${color}-100 border border-${color}-300 rounded-lg`">
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
