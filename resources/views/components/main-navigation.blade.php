<!-- Main Navigation Component -->
<nav class="bg-black">
    <!-- Top Bar -->
    <div class="container mx-auto px-4">
        <div class="flex justify-end py-2">
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-white text-xs tracking-wider flex items-center">
                        {{ Auth::user()->name }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="text-white space-x-2">
                    <a href="{{ route('register') }}" class="text-xs tracking-wider">REGISTER</a>
                    <span class="text-xs">/</span>
                    <a href="{{ route('login') }}" class="text-xs tracking-wider">LOGIN</a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Logo -->
    <div class="text-center py-6">
        <h1 class="text-white text-3xl tracking-[0.3em]">VINTILUX & CO.</h1>
    </div>

    <!-- Main Navigation -->
    <div class="border-t border-zinc-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-3 items-center py-4">
                <!-- Left Links -->
                <div class="flex space-x-12">
                    <a href="{{ route('shop') }}" class="text-white text-sm tracking-wider">SHOP</a>
                    <a href="{{ route('shop.handbags') }}" class="text-white text-sm tracking-wider">HANDBAGS</a>
                    <a href="{{ route('shop.accessories') }}" class="text-white text-sm tracking-wider">ACCESSORIES</a>
                </div>
                
                <!-- Right Links -->
                <div class="col-start-3 flex justify-end space-x-12 items-center">
                    <a href="#" class="text-white text-sm tracking-wider">ABOUT US</a>
                    <a href="#" class="text-white text-sm tracking-wider">CONTACT US</a>
                    <a href="{{ route('orders.index') }}" class="text-white text-sm tracking-wider">ORDER HISTORY</a>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('profile') }}" class="text-white">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="text-white">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </a>
                        <a href="{{ route('cart.index') }}" class="text-white">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 20 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
