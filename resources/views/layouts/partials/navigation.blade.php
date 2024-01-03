<div class="hidden sm:ml-6 sm:flex gap-2 sm:items-center">
    <div class="relative ml-3" x-data="{ open: false }">
        <div>
            <button @click="open = !open" type="button"
                class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="sr-only">Open user menu</span>
                <img class="h-8 w-8 rounded-full"
                    src="{{ auth()->user()->getFirstMediaUrl(App\Constants\MediaCollectionName::PROFILE_IMAGE) }}"
                    alt="AVATAR">
            </button>
        </div>

        <!-- Dropdown menu -->
        <div x-show="open" @click.away="open = false"
            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
            <a href="{{ route('profile.index', auth()->id()) }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1"
                id="user-menu-item-0">Your Profile</a>
            <a href="{{ route('profile.edit', auth()->id()) }}"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1"
                id="user-menu-item-1">Edit Profile</a>
            <form action="{{ route('logout') }}" method="POST" role="menuitem" tabindex="-1" id="user-menu-item-2">
                @csrf

                <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign
                    out</button>
            </form>
        </div>
    </div>
</div>
<div class="-mr-2 flex items-center sm:hidden">
    <!-- Mobile menu button -->
    <button x-on:click="mobileMenuOpen = !mobileMenuOpen" type="button"
        class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-500"
        aria-controls="mobile-menu" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <!-- Icon when menu is closed -->
        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>

        <!-- Icon when menu is open -->
        <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
