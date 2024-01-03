<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlpineJS CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100">
    <header>
        <!-- Navigation -->
        <nav x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex flex-shrink-0 items-center">
                            <a href="{{ route('home') }}">
                                <h2 class="font-bold text-2xl">Barta</h2>
                            </a>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <!---- Current: "border-gray-800 text-gray-900 font-semibold", Default:
                            "border-transparent text-gray-600 hover:border-gray-300 hover:text-gray-800" ----->
                            <a href="#"
                                class="inline-flex items-center border-b-2 border-gray-800 px-1 pt-1 text-sm font-semibold text-gray-900">Discover</a>
                            <a href="#"
                                class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-600 hover:border-gray-300 hover:text-gray-800">For
                                you</a>
                            <a href="#"
                                class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-600 hover:border-gray-300 hover:text-gray-800">People</a>
                        </div>
                    </div>


                    {{-- Search Input --}}
                    <form action="{{ route('search') }}" method="GET" class="flex items-center">
                        <input type="text" name="q" placeholder="Search..."
                            class="border-2 border-gray-300 bg-white h-10 px-5 pr-10 rounded-full text-sm focus:outline-none"
                            value="{{ request()->query('q') }}">
                    </form>

                    {{-- Navigation Menu --}}
                    @include('layouts.partials.navigation')
                </div>


        </nav>
    </header>

    <main
        class="container @isset($maxContainerWidth) max-w-2xl @else max-w-xl @endisset mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">
        {{-- Message for session data --}}
        @include('layouts.partials.flash-message')

        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')
</body>

</html>
