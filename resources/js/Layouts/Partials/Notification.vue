<template>
    <div v-if="notifications.length"
        class="px-1 absolute inline-flex items-center justify-center w-4 h-4 text-xs font-bold bg-red-500 border-2 border-white rounded-full -top-1 -end-2 dark:border-gray-900">
    </div>
    <div x-show="notifyOpen" x-on:click.away="notifyOpen = false" id="notify"
        class="w-72 max-w-xs px-2 py-4 absolute -right-24 -top-40 mt-52 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 z-10">
        <div class="text-center pb-3 border-b">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">
                Notifications</h5>
        </div>
        <div class="flow-root py-2">
            <template v-if="notifications.length">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    <li @click="markAsRead(notification.id)" v-for="notification in notifications"
                        class="p-2 hover:bg-gray-200 cursor-pointer text-left" :key="notification.id">
                        <div class="flex items-center">
                            <div class="flex-1 min-w-0 ms-4">
                                <p class="text-sm font-medium text-gray-600 truncate dark:text-white">
                                    {{ notification.message }}
                                </p>
                                <p class="text-xs text-gray-500 truncate dark:text-gray-400">
                                    {{ notification.created_at }}
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </template>
            <template v-else>
                <svg width="65px" height="65px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="m-auto">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.7628 9.00012H7.63719C7.18864 9.00012 6.82501 9.37307 6.82501 9.83312V16.5001C6.82501 17.8808 7.91632 19.0001 9.26251 19.0001H14.1375C14.784 19.0001 15.404 18.7367 15.8611 18.2679C16.3182 17.799 16.575 17.1632 16.575 16.5001V9.83312C16.575 9.37307 16.2114 9.00012 15.7628 9.00012Z"
                            stroke="#b0b0b0" stroke-width="0.576" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M14.625 7.00008L14.5217 6.78908C13.9873 5.69263 12.8947 5 11.6995 5C10.5044 5 9.4118 5.69263 8.8774 6.78908L8.77502 7.00008H14.625Z"
                            stroke="#b0b0b0" stroke-width="0.576" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M10.8247 12.3331C10.8247 11.9189 10.4889 11.5831 10.0747 11.5831C9.66047 11.5831 9.32469 11.9189 9.32469 12.3331H10.8247ZM9.32469 15.6661C9.32469 16.0803 9.66047 16.4161 10.0747 16.4161C10.4889 16.4161 10.8247 16.0803 10.8247 15.6661H9.32469ZM14.0753 12.3331C14.0753 11.9189 13.7396 11.5831 13.3253 11.5831C12.9111 11.5831 12.5753 11.9189 12.5753 12.3331H14.0753ZM12.5753 15.6661C12.5753 16.0803 12.9111 16.4161 13.3253 16.4161C13.7396 16.4161 14.0753 16.0803 14.0753 15.6661H12.5753ZM14.625 6.25012C14.2108 6.25012 13.875 6.58591 13.875 7.00012C13.875 7.41434 14.2108 7.75012 14.625 7.75012V6.25012ZM16.575 7.75012C16.9892 7.75012 17.325 7.41434 17.325 7.00012C17.325 6.58591 16.9892 6.25012 16.575 6.25012V7.75012ZM8.77501 7.75012C9.18923 7.75012 9.52501 7.41434 9.52501 7.00012C9.52501 6.58591 9.18923 6.25012 8.77501 6.25012V7.75012ZM6.82501 6.25012C6.4108 6.25012 6.07501 6.58591 6.07501 7.00012C6.07501 7.41434 6.4108 7.75012 6.82501 7.75012V6.25012ZM9.32469 12.3331V15.6661H10.8247V12.3331H9.32469ZM12.5753 12.3331V15.6661H14.0753V12.3331H12.5753ZM14.625 7.75012H16.575V6.25012H14.625V7.75012ZM8.77501 6.25012H6.82501V7.75012H8.77501V6.25012Z"
                            fill="#b0b0b0"></path>
                    </g>
                </svg>
            </template>

        </div>
        <Link :href="route('notifications.index')"
            class="block w-full p-2 bg-gray-800 text-white text-sm rounded-md font-semibold">View
        All</Link>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { usePage, router, Link } from '@inertiajs/vue3'

const { auth } = usePage().props

let notifications = ref([])

onMounted(() => {
    axios.get(route('notifications.latest'))
        .then(({ data }) => notifications.value = data)
})

Echo.private('App.Models.User.' + auth.user.id)
    .notification((notification) => {
        if (notifications.value.length < 2) {
            notifications.value.unshift(notification)
        } else {
            notifications.value.pop()
            notifications.value.unshift(notification)
        }
    })

const markAsRead = (notificationId) => {
    router.visit(route('notifications.show', notificationId), {
        onBefore: () => {
            notifications.value = notifications.value.filter(notification => notification.id !== notificationId)
        }
    })
}
</script>
