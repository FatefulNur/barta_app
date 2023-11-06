@extends('layouts.auth')

@section('heading')
    Sign in to your account
@endsection

@section('content')
    <form class="space-y-6" action="{{ route('login') }}" method="POST">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                address</label>
            <div class="mt-2">
                <input id="email" name="email" type="text" autocomplete="email" placeholder="bruce@wayne.com"
                    class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('email')
                        !border border-red-500
                    @enderror"
                    value="{{ old('email') }}" />
                @error('email')
                    <span class="text-sm text-red-600 font-semibold">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                <div class="text-sm">
                    <a href="#" class="font-semibold text-black hover:text-black">Forgot password?</a>
                </div>
            </div>
            <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="current-password" placeholder="••••••••"
                    class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 @error('password')
                        !border border-red-500
                    @enderror" />
                @error('password')
                    <span class="text-sm text-red-600 font-semibold">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <button type="submit"
                class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                Sign in
            </button>
        </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
        Don't have an account yet?
        <a href="{{ route('register.index') }}" class="font-semibold leading-6 text-black hover:text-black">Sign
            Up</a>
    </p>
@endsection
