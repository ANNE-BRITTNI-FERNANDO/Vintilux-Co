<nav class="bg-black">
        Top Bar
        <div class="container mx-auto px-4">
            <div class="flex justify-end py-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-white text-xs tracking-wider">DASHBOARD</a>
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
                        <div class="flex items-center space-x-4">
                            <a href="profile" class="text-white">
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