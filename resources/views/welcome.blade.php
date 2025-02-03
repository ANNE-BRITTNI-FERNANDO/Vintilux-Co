<x-app-layout>
    <nav class="bg-black">
        <!-- Top Bar -->
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
                            <a href="#" class="text-white">
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

    <!-- Hero Section -->
    <div class="relative">
        <img src="{{ asset('storage/images/Home_Banner.png') }}" alt="Luxury Handbag" class="w-full h-[600px] object-cover">

    </div>

    <!-- Category Section -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Handbags Category -->
            <div class="relative group cursor-pointer">
                <img src="{{ asset('storage/images/Home_Handbags.png') }}" alt="Handbags" class="w-full h-[300px] object-cover">
            </div>
            <!-- Accessories Category -->
            <div class="relative group cursor-pointer">
                <img src="{{ asset('storage/images/Home_Accessories.png') }}" alt="Accessories" class="w-full h-[300px] object-cover">
            </div>
        </div>
    </div>

    <!-- Welcome Section -->
    <div class="bg-gray-100 py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-light mb-4">WELCOME TO VINTILUX & CO.</h2>
            <p class="text-gray-600 mb-6">Own a piece of luxury - bags designed for those who appreciate the finer things in life</p>
            <a href="{{ route('shop') }}" class="inline-block bg-black text-white px-8 py-3 hover:bg-gray-800 transition-colors duration-300">Learn More</a>
        </div>
    </div>

    <!-- New Arrivals Section -->
    <div class="bg-[#FFFFFF] py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-light tracking-wider mb-2">NEW ARRIVALS</h2>
                <div class="w-24 h-[1px] bg-black mx-auto"></div>
            </div>
            
            <!-- Carousel Container -->
            <div class="relative overflow-hidden" id="carousel">
                <div class="flex transition-transform duration-1000" id="carouselTrack" style="width: 100%;">
                    @foreach($newArrivals as $product)
                        <div class="flex-none w-1/4 px-4">
                            <div class="group relative">
                                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-50 shadow-sm transition-all duration-300 group-hover:shadow-md">
                                    <img src="{{ asset('storage/' . $product->product_image) }}" 
                                         alt="{{ $product->product_name }}" 
                                         class="h-[350px] w-full object-cover object-center transition-transform duration-300 group-hover:scale-105">
                                </div>
                                <div class="mt-6 text-center">
                                    <h3 class="text-sm font-medium text-gray-900 tracking-wider uppercase">{{ $product->product_name }}</h3>
                                    <p class="mt-2 text-sm text-gray-500 tracking-wide">{{ $product->product_category }}</p>
                                    <p class="mt-2 text-sm font-medium text-gray-900">LKR {{ number_format($product->product_price, 2) }}</p>
                                    <button class="mt-4 px-6 py-2 border border-black text-xs uppercase tracking-wider hover:bg-black hover:text-white transition-colors duration-300">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const track = document.getElementById('carouselTrack');
            const slides = Array.from(track.children);
            let currentPosition = 0;

            // Clone the first 4 slides and append them to the end
            slides.slice(0, 4).forEach(slide => {
                const clone = slide.cloneNode(true);
                track.appendChild(clone);
            });

            function slideNext() {
                currentPosition++;
                const slideWidth = slides[0].offsetWidth;
                
                track.style.transition = 'transform 1000ms ease';
                track.style.transform = `translateX(-${currentPosition * slideWidth}px)`;

                // When we've shown all original slides, reset to beginning
                if (currentPosition >= slides.length) {
                    setTimeout(() => {
                        track.style.transition = 'none';
                        currentPosition = 0;
                        track.style.transform = `translateX(0)`;
                        setTimeout(() => {
                            track.style.transition = 'transform 1000ms ease';
                        }, 50);
                    }, 1000);
                }
            }

            // Slide every 3 seconds
            setInterval(slideNext, 3000);

            // Handle window resize
            window.addEventListener('resize', () => {
                const slideWidth = slides[0].offsetWidth;
                track.style.transition = 'none';
                track.style.transform = `translateX(-${currentPosition * slideWidth}px)`;
            });
        });
    </script>

    @include('livewire.layout.footer')
</x-app-layout>
