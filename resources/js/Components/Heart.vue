<template>
    <button type="button" :class="{ 'text-gray-600': isLiked, 'text-gray-600': !isLiked }"
        class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 hover:text-gray-800" @click="toggleLike"
        :disabled="isLikeProcessing">
        <span class="sr-only">Like</span>
        <!-- Show this icon when liked -->
        <svg v-show="isLiked" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
            <path
                d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
        </svg>
        <!-- Show this icon when not liked -->
        <svg v-show="!isLiked" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>

        <p>{{ likesCount }}</p>
    </button>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import axios from 'axios'

const { auth } = usePage().props

const props = defineProps({
    postId: String,
    likes: Object,
    likesCount: Number,
})

// storing this long logic into a variable cause reference error
let isLiked = ref(Boolean(props.likes.find(obj => obj.user.id === auth.user.id)?.id))
let isLikeProcessing = ref(false)
let likeId = ref(props.likes.find(obj => obj.user.id === auth.user.id)?.id)
let likesCount = ref(props.likesCount)

const toggleLike = () => {
    isLiked.value = !isLiked.value
    isLikeProcessing.value = true

    if (isLiked.value) {
        likesCount.value = likesCount.value + 1
        axios.post(route('likes.store'), {
            post_id: props.postId
        })
            .then(({ data }) => likeId.value = data.id)
            .catch(err => {
                isLiked.value = false
                likesCount.value = likesCount.value - 1
            }).finally(() => isLikeProcessing.value = false)
    } else {
        likesCount.value = likesCount.value - 1
        axios.delete(route('likes.destroy', likeId?.value))
            .catch(err => {
                isLiked.value = true
                likesCount.value = likesCount.value + 1
            }).finally(() => isLikeProcessing.value = false)
    }
}
</script>
