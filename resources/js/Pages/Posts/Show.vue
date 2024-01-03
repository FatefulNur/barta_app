<template>
    <section id="newsfeed" class="space-y-6">
        <!-- Barta Card -->
        <article class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
            <!-- Barta Card Top -->
            <header>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <!-- User Avatar -->
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full object-cover" :src="post.data.user.profile_image"
                                alt="AVATAR">
                        </div>
                        <!-- /User Avatar -->

                        <!-- User Info -->
                        <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                            <a :href="route('profile.index', post.data.user.id)"
                                class="hover:underline font-semibold line-clamp-1">
                                {{ post.data.user.full_name }}
                            </a>

                            <a :href="route('profile.index', post.data.user.id)"
                                class="hover:underline text-sm text-gray-500 line-clamp-1">
                                @{{ post.data.user.username }}
                            </a>
                        </div>
                        <!-- /User Info -->
                    </div>

                    <!-- Card Action Dropdown -->
                    <div v-if="post.data.can.edit && post.data.can.delete" class="flex flex-shrink-0 self-center"
                        x-data="{ open: false }">
                        <div class="relative inline-block text-left">
                            <div>
                                <button x-on:click="open = !open" type="button"
                                    class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600"
                                    id="menu-0-button">
                                    <span class="sr-only">Open options</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Dropdown menu -->
                            <div x-show="open" x-on:click.away="open = false"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <a :href="route('posts.edit', post.data.id)"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">Edit</a>
                                <form onsubmit="return confirm('Really wanna delete the post')"
                                    :action="route('posts.destroy', post.data.id)" method="POST" role="menuitem"
                                    tabindex="-1" id="user-menu-item-1">

                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        type="submit">Delete</button>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- /Card Action Dropdown -->
                </div>
            </header>

            <!-- Content -->
            <div class="py-4 text-gray-700 font-normal space-y-2">
                <img v-if="post.data.post_image" :src="post.data.post_image"
                    class="min-h-auto w-full rounded-lg object-cover max-h-64 md:max-h-72" alt="">
                <p class="whitespace-pre-wrap">{{ post.data.body }}</p>
            </div>

            <!-- Date Created & View Stat -->
            <div class="flex items-center gap-2 text-gray-500 text-xs my-2">
                <span>{{ post.data.created_at }}</span>
                <span>•</span>
                <span>{{ post.data.comments_count }} comments</span>
                <span>•</span>
                <span>{{ post.data.view_count }} views</span>
            </div>

            <hr class="my-6">

            <!-- Create a Comment -->
            <CreateComment :post-id="post.data.id" />

        </article>
        <!-- /Barta Card -->

        <template v-if="post.data.comments_count">
            <hr>
            <div class="flex flex-col space-y-6">
                <h1 class="text-lg font-semibold">Comments ({{ post.data.comments_count }})</h1>
                <!-- Barta User Comments Container -->
                <article
                    class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-2 sm:px-6 min-w-full divide-y">
                    <!-- Comments -->
                    <div v-for="comment in post.data.comments" class="py-4">
                        <!-- Barta User Comments Top -->
                        <header>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <!-- User Avatar -->
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full object-cover" :src="comment.user.profile_image"
                                            alt="AVATAR">
                                    </div>
                                    <!-- /User Avatar -->

                                    <!-- User Info -->
                                    <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                        <a :href="route('profile.index', comment.user.id)"
                                            class="hover:underline font-semibold line-clamp-1">
                                            {{ comment.user.full_name }}
                                        </a>

                                        <a :href="route('profile.index', comment.user.id)"
                                            class="hover:underline text-sm text-gray-500 line-clamp-1">
                                            @{{ comment.user.username }}
                                        </a>
                                    </div>
                                    <!-- /User Info -->
                                </div>

                                <!-- Card Action Dropdown -->
                                <div v-if="comment.can.edit && comment.can.delete" class="flex flex-shrink-0 self-center"
                                    x-data="{ open: false }">
                                    <div class="relative inline-block text-left">
                                        <div>
                                            <button x-on:click="open = !open" type="button"
                                                class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600"
                                                id="menu-0-button">
                                                <span class="sr-only">Open options</span>
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                    aria-hidden="true">
                                                    <path
                                                        d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Dropdown menu -->
                                        <div x-show="open" x-on:click.away="open = false"
                                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                            tabindex="-1" style="display: none;">
                                            <a @click="shouldEdit = comment.id"
                                                class="block px-4 py-2 text-sm text-gray-700 cursor-pointer hover:bg-gray-100"
                                                role="menuitem" tabindex="-1" id="user-menu-item-0">Edit</a>
                                            <form @submit.prevent="deleteComment(comment.id)" method="POST" role="menuitem"
                                                tabindex="-1" id="user-menu-item-1">

                                                <button
                                                    class="block px-4 py-2 w-full text-left text-sm text-gray-700 hover:bg-gray-100"
                                                    type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Card Action Dropdown -->
                            </div>
                        </header>

                        <!-- Content -->
                        <div class="py-4 text-gray-700 font-normal">
                            <template v-if="shouldEdit === comment.id">
                                <EditComment @submitted="shouldEdit = ''" @cancelled="shouldEdit = ''"
                                    :comment-body="comment.body" :post-id="post.data.id" :comment-id="comment.id" />
                            </template>
                            <template v-else>
                                {{ comment.body }}
                            </template>
                        </div>

                        <!-- Date Created -->
                        <div class="flex items-center gap-2 text-gray-500 text-xs">
                            <span class="">{{ comment.created_at }}</span>
                        </div>
                    </div>

                    <!-- /Comments -->
                </article>
                <!-- /Barta User Comments -->
            </div>
        </template>
        <template v-else>
            <div class="font-bold text-red-800 text-center">No Comment added yet</div>
        </template>
    </section>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    layout: AppLayout
}
</script>

<script setup>
import CreateComment from '@/Pages/Posts/Partials/Forms/CreateComment.vue'
import EditComment from '@/Pages/Posts/Partials/Forms/EditComment.vue'

import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    post: {
        type: Object
    }
})

let shouldEdit = ref('')

const form = useForm({})

const deleteComment = (commentId) => {
    form.delete(route('posts.comments.destroy', {
        post: props.post.data.id,
        comment: commentId,
    }), {
        onBefore: () => confirm('Would you like to delete the comment?'),
    })
}
</script>
