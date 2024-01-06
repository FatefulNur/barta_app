<script setup>
import { computed } from 'vue'

const props = defineProps({ status: Number })

const title = computed(() => {
    return {
        404: 'Page Not Found',
    }[props.status]
})

const description = computed(() => {
    return {
        404: 'Sorry, the page you are looking for could not be found.',
    }[props.status]
})
</script>

<template>
    <div class="flex items-center justify-center min-h-screen flex-col bg-slate-200 gap-2">
        <h1 class=" text-3xl text-gray-500 font-semibold">{{ title }}</h1>
        <div class="text-lg text-gray-500">{{ description }}</div>
    </div>
</template>
