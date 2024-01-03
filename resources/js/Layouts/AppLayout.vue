<template>
    <Head title="Home">
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    </Head>

    <body class="bg-gray-100">
        <header>
            <!-- Navigation -->
            <Navigation />
        </header>

        <main
            :class="`container ${route().current('posts.show') ? 'max-w-2xl' : 'max-w-xl'} mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen`">

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
</script>
