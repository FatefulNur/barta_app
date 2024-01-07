<template>
    <form @submit.prevent="submit" method="POST" enctype="multipart/form-data">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-xl font-semibold leading-7 text-gray-900">
                    Edit Profile
                </h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    This information will be displayed publicly so be careful what you
                    share.
                </p>

                <div class="mt-10 border-b border-gray-900/10 pb-12">
                    <div class="col-span-full mt-10 pb-10">
                        <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">Photo</label>
                        <div class="mt-2 flex items-center gap-x-3">
                            <input @input="form.avatar = $event.target.files[0]" class="hidden" type="file" name="avatar"
                                id="avatar">
                            <img class="h-32 w-32 object-cover rounded-full border-2" :src="profile_image" alt="AVATAR">
                            <label for="avatar">
                                <div
                                    class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    Change
                                </div>
                            </label>
                        </div>

                        <span v-if="$page.props.errors.avatar" class="text-sm text-red-600 font-semibold">{{
                            $page.props.errors.avatar }}</span>
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Full
                                Name</label>
                            <div class="mt-2">
                                <input type="text" name="name" id="name" autocomplete="given-name" v-model="form.name"
                                    :class="`block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 ${$page.props.errors.name ? '!border border-red-500' : ''}`" />
                                <span v-if="$page.props.errors.name" class="text-sm text-red-600 font-semibold">{{
                                    $page.props.errors.name }}</span>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                            <div class="mt-2">
                                <input type="text" name="username" id="username" autocomplete="family-name"
                                    v-model="form.username"
                                    :class="`block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 ${$page.props.errors.username ? '!border border-red-500' : ''}`" />
                                <span v-if="$page.props.errors.username" class="text-sm text-red-600 font-semibold">{{
                                    $page.props.errors.username }}</span>
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                                address</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="text" autocomplete="email" v-model="form.email"
                                    :class="`block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 ${$page.props.errors.email ? '!border border-red-500' : ''}`" />
                                <span v-if="$page.props.errors.email" class="text-sm text-red-600 font-semibold">{{
                                    $page.props.errors.email }}</span>
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                            <div class="mt-2">
                                <input type="password" name="password" id="password" autocomplete="password"
                                    v-model="form.password"
                                    :class="`block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 ${$page.props.errors.password ? '!border border-red-500' : ''}`" />
                                <span v-if="$page.props.errors.password" class="text-sm text-red-600 font-semibold">{{
                                    $page.props.errors.password }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-full">
                        <label for="bio" class="block text-sm font-medium leading-6 text-gray-900">Bio</label>
                        <div class="mt-2">
                            <textarea id="bio" name="bio" rows="3" v-model="form.bio"
                                :class="`block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 ${$page.props.errors.bio ? '!border border-red-500' : ''}`"></textarea>
                            <span v-if="$page.props.errors.bio" class="text-sm text-red-600 font-semibold">{{
                                $page.props.errors.bio }}</span>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            Write a few sentences about yourself.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">
                Cancel
            </button>
            <button :disabled="form.processing" type="submit"
                class="flex items-center justify-center gap-2 rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 disabled:bg-gray-300">
                <Loader v-if="form.processing" />
                Save
            </button>
        </div>
    </form>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    layout: AppLayout
}
</script>

<script setup>
import Loader from '@/Components/Loader.vue'
import { usePage, router, useForm } from '@inertiajs/vue3'

const { auth } = usePage().props
const props = defineProps({
    user: Object,
    profile_image: String,
})

const form = useForm({
    avatar: null,
    name: props.user.name,
    username: props.user.username,
    email: props.user.email,
    password: props.user.password,
    bio: props.user.bio,
})

const submit = () => {
    router.post(route('profile.update', props.user.id), {
        ...form.data(),
        _method: 'put',
    }, {
        onBefore: () => form.processing = true,
        onFinish: () => {
            console.log(auth.user.password);
            form.password = null
            form.processing = false
        },
    })
}
</script>
