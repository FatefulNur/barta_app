@extends('layouts.app')

@section('content')
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

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
                    <!--              <div class="col-span-full mt-10 pb-10">-->
                    <!--                <label-->
                    <!--                  for="photo"-->
                    <!--                  class="block text-sm font-medium leading-6 text-gray-900"-->
                    <!--                  >Photo</label-->
                    <!--                >-->
                    <!--                <div class="mt-2 flex items-center gap-x-3">-->
                    <!--                  <input-->
                    <!--                    class="hidden"-->
                    <!--                    type="file"-->
                    <!--                    name="avatar"-->
                    <!--                    id="avatar" />-->
                    <!--                  &lt;!&ndash; <img-->
                    <!--                    class="h-12 w-12 rounded-full"-->
                    <!--                    src="https://avatars.githubusercontent.com/u/831997"-->
                    <!--                    alt="Ahmed Shamim Hasan Shaon" /> &ndash;&gt;-->
                    <!--                  <svg-->
                    <!--                    class="h-12 w-12 text-gray-300"-->
                    <!--                    viewBox="0 0 24 24"-->
                    <!--                    fill="currentColor"-->
                    <!--                    aria-hidden="true">-->
                    <!--                    <path-->
                    <!--                      fill-rule="evenodd"-->
                    <!--                      d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"-->
                    <!--                      clip-rule="evenodd" />-->
                    <!--                  </svg>-->
                    <!--                  <label for="avatar">-->
                    <!--                    <div-->
                    <!--                      class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">-->
                    <!--                      Change-->
                    <!--                    </div>-->
                    <!--                  </label>-->
                    <!--                </div>-->
                    <!--              </div>-->

                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First
                                name</label>
                            <div class="mt-2">
                                <input type="text" name="first_name" id="first_name" autocomplete="given-name"
                                    value="{{ old('first_name', $first_name) }}"
                                    class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 @error('first_name')
                                        !border border-red-500
                                    @enderror" />
                                @error('first_name')
                                    <span class="text-sm text-red-600 font-semibold">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Last
                                name</label>
                            <div class="mt-2">
                                <input type="text" name="last_name" id="last_name"
                                    value="{{ old('last_name', $last_name) }}" autocomplete="family-name"
                                    class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 @error('last_name')
                                        !border border-red-500
                                    @enderror" />
                                @error('last_name')
                                    <span class="text-sm text-red-600 font-semibold">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                                address</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="text" autocomplete="email"
                                    value="{{ old('email', $email) }}"
                                    class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 @error('email')
                                        !border border-red-500
                                    @enderror" />
                                @error('email')
                                    <span class="text-sm text-red-600 font-semibold">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                            <div class="mt-2">
                                <input type="password" name="password" id="password" autocomplete="password"
                                    class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 @error('password')
                                        !border border-red-500
                                    @enderror" />
                                @error('password')
                                    <span class="text-sm text-red-600 font-semibold">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-full">
                        <label for="bio" class="block text-sm font-medium leading-6 text-gray-900">Bio</label>
                        <div class="mt-2">
                            <textarea id="bio" name="bio" rows="3"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6 @error('bio')
                                    !border border-red-500
                                @enderror">{{ old('bio', $bio) }}</textarea>
                            @error('bio')
                                <span class="text-sm text-red-600 font-semibold">{{ $message }}</span>
                            @enderror
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
            <button type="submit"
                class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                Save
            </button>
        </div>
    </form>
@endsection
