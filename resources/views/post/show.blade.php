@extends('layouts.app')

@section('content')
    <section id="newsfeed" class="space-y-6">
        <!-- Barta Card -->
        <article class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
            <!-- Barta Card Top -->
            <header>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <!-- User Avatar -->
                        <!--                <div class="flex-shrink-0">-->
                        <!--                  <img-->
                        <!--                    class="h-10 w-10 rounded-full object-cover"-->
                        <!--                    src="https://avatars.githubusercontent.com/u/61485238"-->
                        <!--                    alt="Al Nahian" />-->
                        <!--                </div>-->
                        <!-- /User Avatar -->

                        <!-- User Info -->
                        <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                            <a href="{{ route('profile.index') }}" class="hover:underline font-semibold line-clamp-1">
                                {{ str($post->name)->title() }}
                            </a>

                            <a href="{{ route('profile.index') }}"
                                class="hover:underline text-sm text-gray-500 line-clamp-1">
                                {{ str($post->username)->prepend('@') }}
                            </a>
                        </div>
                        <!-- /User Info -->
                    </div>

                    @author($post->user_id)
                    <!-- Card Action Dropdown -->
                    <div class="flex flex-shrink-0 self-center" x-data="{ open: false }">
                        <div class="relative inline-block text-left">
                            <div>
                                <button @click="open = !open" type="button"
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

                            @author($post->user_id)
                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <a href="{{ route('posts.edit', $post->uuid) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">Edit</a>
                                <form onsubmit="return confirm('Really wanna delete the post')"
                                    action="{{ route('posts.destroy', $post->uuid) }}" method="POST" role="menuitem"
                                    tabindex="-1" id="user-menu-item-1">
                                    @csrf
                                    @method('DELETE')

                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        type="submit">Delete</button>
                                </form>
                            </div>
                            @endauthor
                        </div>

                    </div>
                    <!-- /Card Action Dropdown -->
                    @endauthor
                </div>
            </header>

            <!-- Content -->
            <div class="py-4 text-gray-700 font-normal">
                <p class="whitespace-pre-wrap">{{ $post->body }}</p>
            </div>

            <!-- Date Created & View Stat -->
            <div class="flex items-center gap-2 text-gray-500 text-xs my-2">
                <span>{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                <span>•</span>
                <span>3 comments</span>
                <span>•</span>
                <span>{{ $post->view_count }} views</span>
            </div>

            <hr class="my-6">

            <!--- Barta Create Comment Form -->
            <form action="" method="POST">
                <!-- Create Comment Card Top -->
                <div>
                    <div class="flex items-start /space-x-3/">
                        <!-- User Avatar -->
                        <!-- <div class="flex-shrink-0">-->
                        <!--              <img-->
                        <!--                class="h-10 w-10 rounded-full object-cover"-->
                        <!--                src="https://avatars.githubusercontent.com/u/831997"-->
                        <!--                alt="Ahmed Shamim" />-->
                        <!--            </div> -->
                        <!-- /User Avatar -->

                        <!-- Auto Resizing Comment Box -->
                        <div class="text-gray-700 font-normal w-full">
                            <textarea x-data="{
                                resize() {
                                    $el.style.height = '0px';
                                    $el.style.height = $el.scrollHeight + 'px'
                                }
                            }" x-init="resize()" @input="resize()" type="text" name="comment"
                                placeholder="Write a comment..."
                                class="flex w-full h-auto min-h-[40px] px-3 py-2 text-sm bg-gray-100 focus:bg-white border border-sm rounded-lg border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-offset-0 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900"
                                style="height: 38px;"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Create Comment Card Bottom -->
                <div>
                    <!-- Card Bottom Action Buttons -->
                    <div class="flex items-center justify-end">
                        <button type="submit"
                            class="mt-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                            Comment
                        </button>
                    </div>
                    <!-- /Card Bottom Action Buttons -->
                </div>
                <!-- /Create Comment Card Bottom -->
            </form>
            <!--- /Barta Create Comment Form -->
        </article>
        <!-- /Barta Card -->

        <hr>

        <div class="flex flex-col space-y-6">
            <h1 class="text-lg font-semibold">Comments (3)</h1>

            <!-- Barta User Comments Container -->
            <article
                class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-2 sm:px-6 min-w-full divide-y">
                <!-- Comments -->

                <!-- Comment 1 -->
                <div class="py-4">
                    <!-- Barta User Comments Top -->
                    <header>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- User Info -->
                                <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                    <a href="profile.html" class="hover:underline font-semibold line-clamp-1">
                                        Al Nahian
                                    </a>

                                    <a href="profile.html" class="hover:underline text-sm text-gray-500 line-clamp-1">
                                        @alnahian2003
                                    </a>
                                </div>
                                <!-- /User Info -->
                            </div>
                        </div>
                    </header>

                    <!-- Content -->
                    <div class="py-4 text-gray-700 font-normal">
                        <p>আজকে থেকে আমিও একজন PoorPHP ডেভেলপার 😂</p>
                    </div>

                    <!-- Date Created -->
                    <div class="flex items-center gap-2 text-gray-500 text-xs">
                        <span class="">6m ago</span>
                    </div>
                </div>
                <!-- /Comment 1 -->

                <!-- Comment 2 -->
                <div class="py-4">
                    <!-- Barta User Comments Top -->
                    <header>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- User Info -->
                                <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                    <a href="profile.html" class="hover:underline font-semibold line-clamp-1">
                                        Bruce Wayne
                                    </a>

                                    <a href="profile.html" class="hover:underline text-sm text-gray-500 line-clamp-1">
                                        @wayne
                                    </a>
                                </div>
                                <!-- /User Info -->
                            </div>
                        </div>
                    </header>

                    <!-- Content -->
                    <div class="py-4 text-gray-700 font-normal">
                        <p>এখন থেকে শুধু টাকা কথা বলবে, টাকা 🤑</p>
                    </div>

                    <!-- Date Created -->
                    <div class="flex items-center gap-2 text-gray-500 text-xs">
                        <span class="">6m ago</span>
                    </div>
                </div>
                <!-- /Comment 2 -->

                <!-- Comment 3 -->
                <div class="py-4">
                    <!-- Barta User Comments Top -->
                    <header>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- User Info -->
                                <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                    <a href="profile.html" class="hover:underline font-semibold line-clamp-1">
                                        Ahmed Shamim Hasan Shaon
                                    </a>

                                    <a href="profile.html" class="hover:underline text-sm text-gray-500 line-clamp-1">
                                        @me_shaon
                                    </a>
                                </div>
                                <!-- /User Info -->
                            </div>

                            <!-- Card Action Dropdown -->
                            <div class="flex flex-shrink-0 self-center" x-data="{ open: false }">
                                <div class="relative inline-block text-left">
                                    <div>
                                        <button @click="open = !open" type="button"
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
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                        tabindex="-1" style="display: none;">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem" tabindex="-1" id="user-menu-item-0">Edit</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem" tabindex="-1" id="user-menu-item-1">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Card Action Dropdown -->
                        </div>
                    </header>

                    <!-- Content -->
                    <div class="py-4 text-gray-700 font-normal">
                        <p>PoorPHP vs Regular PHP 😎 Let the battle begin 💪</p>
                    </div>

                    <!-- Date Created -->
                    <div class="flex items-center gap-2 text-gray-500 text-xs">
                        <span class="">6m ago</span>
                    </div>
                </div>
                <!-- /Comment 3 -->

                <!-- /Comments -->
            </article>
            <!-- /Barta User Comments -->
        </div>
    </section>
@endsection
