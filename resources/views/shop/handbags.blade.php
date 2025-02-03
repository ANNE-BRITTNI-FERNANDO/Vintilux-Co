<x-app-layout>
    <nav class="bg-black">
        <!-- Top Bar -->
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-2">
                <div class="w-1/3">
                    @livewire('search-products')
                </div>
                <div class="flex justify-end">
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
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('profile') }}" class="text-white">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-white">
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

    <!-- Page Header -->
    <div class="bg-gray-100 py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-light text-center tracking-wider">HANDBAGS</h1>
            <p class="text-center text-gray-600 mt-4">Discover our collection of luxury handbags</p>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach($handbags as $product)
                <div class="group">
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-50 shadow-sm transition-all duration-300 group-hover:shadow-md">
                        <img src="{{ asset('storage/' . $product->product_image) }}" 
                             alt="{{ $product->product_name }}" 
                             class="h-[400px] w-full object-cover object-center transition-transform duration-300 group-hover:scale-105">
                    </div>
                    <div class="mt-6 text-center">
                        <h3 class="text-sm font-medium text-gray-900 tracking-wider uppercase">{{ $product->product_name }}</h3>
                        <p class="mt-2 text-sm text-gray-500 tracking-wide">{{ $product->product_category }}</p>
                        <p class="mt-2 text-sm font-medium text-gray-900">LKR {{ number_format($product->product_price, 2) }}</p>
                        <a href="{{ route('shop.product.details', $product->_id) }}" class="mt-4 inline-block px-6 py-2 border border-black text-xs uppercase tracking-wider hover:bg-black hover:text-white transition-colors duration-300">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('livewire.layout.footer')
</x-app-layout>
