<template>
    <div role="status" class="p-4 border border-gray-300 rounded shadow animate-pulse md:p-6 dark:border-gray-700 min-h-40">
        <div class="flex items-center my-4">
            <svg class="w-12 h-12 me-3 text-gray-300 dark:text-gray-700" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
            </svg>
            <div>
                <div class="h-3 bg-gray-300 rounded-full dark:bg-gray-700 w-48 mb-2"></div>
                <div class="w-32 h-2 bg-gray-300 rounded-full dark:bg-gray-700"></div>
            </div>
        </div>
        <div class="h-20 bg-gray-300 rounded-lg dark:bg-gray-700 mb-4"></div>
        <div class="h-5 bg-gray-300 rounded-full dark:bg-gray-700 mb-2.5"></div>

        <span class="sr-only">Loading...</span>
    </div>
</template>

<script setup>

</script>
