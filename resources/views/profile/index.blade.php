@extends('layouts.app')

@section('content')
    <section
        class="bg-white border-2 p-8 border-gray-800 rounded-xl min-h-[400px] space-y-8 flex items-center flex-col justify-center">
        <!-- Profile Info -->
        <div class="flex gap-4 justify-center flex-col text-center items-center">
            <!-- Avatar -->
            <!--          <div class="relative">-->
            <!--            <img-->
            <!--              class="w-32 h-32 rounded-full border-2 border-gray-800"-->
            <!--              src="https://avatars.githubusercontent.com/u/831997"-->
            <!--              alt="Ahmed Shamim" />-->
            <!--            <span-->
            <!--              class="bottom-2 right-4 absolute w-3.5 h-3.5 bg-green-400 border-2 border-white rounded-full"></span>-->
            <!--          </div>-->
            <!-- /Avatar -->

            <!-- User Meta -->
            <div>
                <h1 class="font-bold md:text-2xl">{{ $fullName }}</h1>
                <p class="text-gray-700">{{ $bio }}</p>
            </div>
            <!-- / User Meta -->
        </div>
        <!-- /Profile Info -->

        <!-- Profile Stats -->
        <!--        <div-->
        <!--          class="flex flex-row gap-16 justify-center text-center items-center">-->
        <!--          &lt;!&ndash; Total Posts Count &ndash;&gt;-->
        <!--          <div class="flex flex-col justify-center items-center">-->
        <!--            <h4 class="sm:text-xl font-bold">405</h4>-->
        <!--            <p class="text-gray-600">Posts</p>-->
        <!--          </div>-->

        <!--          &lt;!&ndash; Total Friends Count &ndash;&gt;-->
        <!--          <div class="flex flex-col justify-center items-center">-->
        <!--            <h4 class="sm:text-xl font-bold">1,334</h4>-->
        <!--            <p class="text-gray-600">Friends</p>-->
        <!--          </div>-->

        <!--          &lt;!&ndash; Total Followers Count &ndash;&gt;-->
        <!--          <div class="flex flex-col justify-center items-center">-->
        <!--            <h4 class="sm:text-xl font-bold">18,589</h4>-->
        <!--            <p class="text-gray-600">Followers</p>-->
        <!--          </div>-->
        <!--        </div>-->
        <!-- /Profile Stats -->

        <div class="flex flex-row gap-16 justify-center text-center items-center">
            <!-- Total Posts Count -->
            <div class="flex flex-col justify-center items-center">
                <h4 class="sm:text-xl font-bold">{{ $posts->count() }}</h4>
                <p class="text-gray-600">Posts</p>
            </div>

            <!-- Total Comments Count -->
            <div class="flex flex-col justify-center items-center">
                <h4 class="sm:text-xl font-bold">{{ $commentsCountOfUserPosts }}</h4>
                <p class="text-gray-600">Comments</p>
            </div>
        </div>

        @author($user->id)
        <!-- Edit Profile Button (Only visible to the profile owner) -->
        <a href="{{ route('profile.edit', auth()->id()) }}" type="button"
            class="-m-2 flex gap-2 items-center rounded-full px-4 py-2 font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>

            Edit Profile
        </a>
        <!-- /Edit Profile Button -->
        @endauthor
    </section>

    @author($user->id)
    <!-- Barta Create Post Card -->
    <form action="{{ route('posts.index') }}" method="POST" enctype="multipart/form-data"
        class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3 @error('body')
            border-red-500
        @enderror">
        @csrf

        <!-- Create Post Card Top -->
        <div>
            <div class="flex items-start /space-x-3/">
                <!-- User Avatar -->
                <!--            <div class="flex-shrink-0">-->
                <!--              <img-->
                <!--                class="h-10 w-10 rounded-full object-cover"-->
                <!--                src="https://avatars.githubusercontent.com/u/831997"-->
                <!--                alt="Ahmed Shamim" />-->
                <!--            </div>-->
                <!-- /User Avatar -->

                <!-- Content -->
                <div class="text-gray-700 font-normal w-full">
                    <textarea
                        class="block w-full p-2 pt-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 focus:ring-offset-0"
                        name="body" rows="2" placeholder="What's going on, {{ $firstName }}?">{{ old('body') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Create Post Card Bottom -->
        <div>
            <!-- Card Bottom Action Buttons -->
            <div class="flex items-center justify-end">
                <!--            <div class="flex gap-4 text-gray-600">-->
                <!--              &lt;!&ndash; Upload Picture Button &ndash;&gt;-->
                <!--              <div>-->
                <!--                <input-->
                <!--                  type="file"-->
                <!--                  name="picture"-->
                <!--                  id="picture"-->
                <!--                  class="hidden" />-->

                <!--                <label-->
                <!--                  for="picture"-->
                <!--                  class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800 cursor-pointer">-->
                <!--                  <span class="sr-only">Picture</span>-->
                <!--                  <svg-->
                <!--                    xmlns="http://www.w3.org/2000/svg"-->
                <!--                    fill="none"-->
                <!--                    viewBox="0 0 24 24"-->
                <!--                    stroke-width="1.5"-->
                <!--                    stroke="currentColor"-->
                <!--                    class="w-6 h-6">-->
                <!--                    <path-->
                <!--                      stroke-linecap="round"-->
                <!--                      stroke-linejoin="round"-->
                <!--                      d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />-->
                <!--                  </svg>-->
                <!--                </label>-->
                <!--              </div>-->
                <!--              &lt;!&ndash; /Upload Picture Button &ndash;&gt;-->

                <!--              &lt;!&ndash; GIF Button &ndash;&gt;-->
                <!--              <button-->
                <!--                type="button"-->
                <!--                class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">-->
                <!--                <span class="sr-only">GIF</span>-->
                <!--                <svg-->
                <!--                  xmlns="http://www.w3.org/2000/svg"-->
                <!--                  fill="none"-->
                <!--                  viewBox="0 0 24 24"-->
                <!--                  stroke-width="1.5"-->
                <!--                  stroke="currentColor"-->
                <!--                  class="w-6 h-6">-->
                <!--                  <path-->
                <!--                    stroke-linecap="round"-->
                <!--                    stroke-linejoin="round"-->
                <!--                    d="M12.75 8.25v7.5m6-7.5h-3V12m0 0v3.75m0-3.75H18M9.75 9.348c-1.03-1.464-2.698-1.464-3.728 0-1.03 1.465-1.03 3.84 0 5.304 1.03 1.464 2.699 1.464 3.728 0V12h-1.5M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />-->
                <!--                </svg>-->
                <!--              </button>-->
                <!--              &lt;!&ndash; /GIF Button &ndash;&gt;-->

                <!--              &lt;!&ndash; Emoji Button &ndash;&gt;-->
                <!--              <button-->
                <!--                type="button"-->
                <!--                class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">-->
                <!--                <span class="sr-only">Emoji</span>-->
                <!--                <svg-->
                <!--                  xmlns="http://www.w3.org/2000/svg"-->
                <!--                  fill="none"-->
                <!--                  viewBox="0 0 24 24"-->
                <!--                  stroke-width="1.5"-->
                <!--                  stroke="currentColor"-->
                <!--                  class="w-6 h-6">-->
                <!--                  <path-->
                <!--                    stroke-linecap="round"-->
                <!--                    stroke-linejoin="round"-->
                <!--                    d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />-->
                <!--                </svg>-->
                <!--              </button>-->
                <!--              &lt;!&ndash; /Emoji Button &ndash;&gt;-->
                <!--            </div>-->

                <div>
                    <!-- Post Button -->
                    <button type="submit"
                        class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                        Post
                    </button>
                    <!-- /Post Button -->
                </div>
            </div>
            <!-- /Card Bottom Action Buttons -->
        </div>
        <!-- /Create Post Card Bottom -->
    </form>
    @error('body')
        <span class="text-sm text-red-600 font-semibold">{{ $message }}</span>
    @enderror
    <!-- /Barta Create Post Card -->
    @endauthor

    <!-- Newsfeed -->
    <section id="newsfeed" class="space-y-6">
        @forelse ($posts as $post)
            <!-- Barta Card -->
            @include('partials.post_card', [
                'post' => $post,
            ])
            <!-- /Barta Card -->
        @empty
            <div class="p-3 bg-red-100 text-red-800 border border-red-300 text-center">No Post added yet</div>
        @endforelse
    </section>
    <!-- /Newsfeed -->
@endsection
