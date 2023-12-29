<template>
    <slot></slot>
    <div id="endOfScroller" ref="endOfScroller" class="text-center">
        <slot name="endingText"></slot>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

let emit = defineEmits(['infinite'])

let endOfScroller = ref(null)
let observer = ref({})

onMounted(() => {
    observer.value = new IntersectionObserver(([{ isIntersecting }]) => {
        if (!isIntersecting) {
            return
        }
        emit('infinite', [observer.value, endOfScroller.value])
    }, { rootMargin: '250px' })

    observer.value.observe(endOfScroller.value)
})

onUnmounted(() => observer.value.disconnect())
</script>
