<template>
    <!--- Barta Create Comment Form -->
    <form @submit.prevent="submit" method="POST">

        <!-- Create Comment Card Top -->
        <div>
            <div class="flex items-start space-x-3">
                <!-- Auto Resizing Comment Box -->
                <div class="text-gray-700 font-normal w-full">
                    <textarea x-data="{
                    resize() {
                        $el.style.height = '0px';
                        $el.style.height = $el.scrollHeight + 'px'
                    }
                }" x-init="resize()" x-on:input="resize()" type="text" name="body" placeholder="Write a comment..."
                        :class="`flex w-full h-auto min-h-[40px] px-3 py-2 text-sm bg-gray-100 focus:bg-white border border-sm rounded-lg border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-offset-0 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900 ${form.errors.body ? 'border-red-500' : ''}`"
                        style="height: 38px;" :autofocus="request.for_comment" v-model="form.body"></textarea>

                    <span v-if="form.errors.body" class="text-sm text-red-600 font-semibold">{{ form.errors.body }}</span>
                </div>
            </div>
        </div>
        <!-- Create Comment Card Bottom -->
        <div>
            <!-- Card Bottom Action Buttons -->
            <div class="flex items-center justify-end">
                <button :disabled="form.processing" type="submit"
                    class="mt-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white disabled:bg-gray-300">
                    <Loader v-if="form.processing" />
                    Update Comment
                </button>
            </div>
            <!-- /Card Bottom Action Buttons -->
        </div>
        <!-- /Create Comment Card Bottom -->
    </form>
    <!--- /Barta Create Comment Form -->
</template>

<script setup>
import Loader from '@/Components/Loader.vue'
import { usePage, useForm } from '@inertiajs/vue3'

const props = defineProps({
    commentBody: String,
    postId: String,
    commentId: String,
})

const emit = defineEmits(['submitted'])

const { request } = usePage().props

const form = useForm({
    body: props.commentBody,
})

const submit = () => {
    form.patch(route('posts.comments.update', {
        post: props.postId,
        comment: props.commentId,
    }), {
        onSuccess: () => {
            form.reset()
            emit('submitted')
        },
        preserveScroll: true,
    })
}

</script>
