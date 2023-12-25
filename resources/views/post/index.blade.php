@extends('layouts.app')

@section('content')
    <!--      <div class="text-center p-12 border border-gray-800 rounded-xl">-->
    <!--        <h1 class="text-3xl justify-center items-center">Welcome to Barta!</h1>-->
    <!--      </div>-->

    @include('partials.forms.create_post')

    <!-- Newsfeed -->
    <section id="newsfeed" class="space-y-6">
        @forelse ($posts as $post)
            @include('partials.post-card', [
                'post' => $post,
            ])
        @empty
            <div class="p-3 bg-red-100 text-red-800 border border-red-300 text-center">No Post added yet</div>
        @endforelse
    </section>
    <!-- /Newsfeed -->
@endsection
