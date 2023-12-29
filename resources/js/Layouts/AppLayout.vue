<template>
    <Head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    </Head>

    <body class="bg-gray-100">
        <header>
            <!-- Navigation -->
            <nav x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white shadow">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <div class="flex flex-shrink-0 items-center">
                                <a :href="route('posts.index')">
                                    <h2 class="font-bold text-2xl">{{ $page.props.app_name }}</h2>
                                </a>
                            </div>

                        </div>

                        <!-- Search Input -->
                        <form :action="route('search')" method="GET" class="flex items-center">
                            <input type="text" name="q" placeholder="Search..."
                                class="border-2 border-gray-300 bg-white h-10 px-5 pr-10 rounded-full text-sm focus:outline-none"
                                :value="$page.props.search_query">
                        </form>

                        <div class="hidden sm:ml-6 sm:flex gap-2 sm:items-center">
                            <!-- Navigation Menu -->
                            <Navigation />
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main
            :class="`container ${maxContainerWidth ? 'max-w-2xl' : 'max-w-xl'} mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen`">

            <!-- Message for session data -->
            <template v-if="$page.props.flash.success">
                <FlashMessage type="success" :message="$page.props.flash.success" />
            </template>
            <template v-else-if="$page.props.flash.error">
                <FlashMessage type="error" :message="$page.props.flash.error" />
            </template>

            <slot></slot>
        </main>

        <!-- Footer -->
        <Footer />
    </body>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import Footer from '@/Layouts/Partials/Footer.vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import Navigation from '@/Layouts/Partials/Navigation.vue'

defineProps({
    maxContainerWidth: Boolean,
})
</script>
