@extends('layouts.app')

@section('content')
    <section
        class="bg-white border-2 p-8 border-gray-800 rounded-xl min-h-[400px] space-y-8 flex items-center flex-col justify-center">
        <!-- Profile Info -->
        <div class="flex gap-4 justify-center flex-col text-center items-center">
            <!-- Avatar -->
            <div class="relative">
                <img class="w-32 h-32 object-cover rounded-full border-2 border-gray-800"
                    src="{{ $user->getFirstMediaUrl(App\Constants\MediaCollectionName::PROFILE_IMAGE) }}" alt="AVATAR">
                <!--            <span class="bottom-2 right-4 absolute w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>-->
            </div>
            <!-- /Avatar -->

            <!-- User Meta -->
            <div>
                <h1 class="font-bold md:text-2xl">{{ $user->fullName() }}</h1>
                <p class="text-gray-700">{{ $user->bio }}</p>
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
    @include('partials.forms.create_post')
    <!-- /Barta Create Post Card -->
    @endauthor

    <!-- Newsfeed -->
    <section id="newsfeed" class="space-y-6">
        @forelse ($posts as $post)
            <!-- Barta Card -->
            @include('partials.post-card', [
                'post' => $post,
            ])
            <!-- /Barta Card -->
        @empty
            <div class="p-3 bg-red-100 text-red-800 border border-red-300 text-center">No Post added yet</div>
        @endforelse
    </section>
    <!-- /Newsfeed -->
@endsection
