<template>
    <AppLayout>
        <!-- Create Post Form -->
        <CreatePost />
        <!-- /Create Post Form -->

        <!-- Newsfeed -->
        <section id="newsfeed" class="space-y-6">
            <template v-if="posts.data.length">
                <InfiniteScroller @infinite="loadMore">
                    <PostCard v-for="post in posts.data" :key="post.id" v-bind="post" />

                    <template #endingText>
                        <template v-if="hasPages">
                            <Loader />
                        </template>
                        <template v-else>
                            <p class="text-md text-red-600 font-semibold">End of the posts</p>
                        </template>
                    </template>
                </InfiniteScroller>
            </template>

            <template v-else>
                <div class="p-3 bg-red-100 text-red-800 border border-red-300 text-center">No Post added yet</div>
            </template>

        </section>
        <!-- /Newsfeed -->
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import CreatePost from '@/Pages/Posts/Partials/Forms/CreatePost.vue'
import PostCard from '@/Pages/Posts/Partials/PostCard.vue'
import InfiniteScroller from '@/Components/InfiniteScroller.vue'
import Loader from '@/Components/Loader.vue'

import { ref, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
    posts: {
        type: Object
    }
})

let hasPages = ref(true)

onMounted(() => {
    if (!props.posts?.links.next) {
        hasPages.value = false
    }
})

/* Load more posts logic */
const loadMore = async ([observer, element]) => {
    // check if next link exist
    if (!props.posts.links.next) {
        return
    }

    // initialize pages exist
    hasPages.value = true

    // getting next page post data
    const response = await axios.get(props.posts.links.next)

    // preserve response posts data as current data
    props.posts.data = [
        ...JSON.parse(JSON.stringify(props.posts.data)),
        ...JSON.parse(JSON.stringify(response.data.data))
    ]

    // preserve links, meta as current state
    props.posts.links = JSON.parse(JSON.stringify(response.data.links))
    props.posts.meta = JSON.parse(JSON.stringify(response.data.meta))

    if (!props.posts.links.next) {
        // stop observing if next page isn't exist
        observer.unobserve(element)
        hasPages.value = false
    } else {
        hasPages.value = true
    }

    // observe again if data formatted
    observer.observe(element)
}
</script>
