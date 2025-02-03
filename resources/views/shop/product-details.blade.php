<x-app-layout>

<div class="bg-gray-50 min-h-screen">
    <!-- Product Details Section -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8 p-8">
                <!-- Product Gallery -->
                @php
                    $mainImagePath = 'products/' . basename($product->product_image);
                    $galleryImages = collect($product->product_gallery)->map(function($image) {
                        return 'product_galleries/' . basename($image);
                    })->toArray();
                    \Log::info('Product Image Path: ' . $mainImagePath);
                    \Log::info('Storage URL for Product Image: ' . Storage::url($mainImagePath));
                    \Log::info('Gallery Images: ', $galleryImages);
                @endphp
                <div x-data="{ activeImage: '{{ Storage::url($mainImagePath) }}' }">
                    <!-- Main Image -->
                    <div class="mb-4 aspect-square">
                        <img x-bind:src="activeImage" alt="{{ $product->product_name }}" class="w-full h-full object-cover rounded-lg">
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    <div class="grid grid-cols-4 gap-4">
                        <!-- Debug info -->
                        <div class="hidden">
                            Main image path: {{ $mainImagePath }}<br>
                            Storage URL: {{ Storage::url($mainImagePath) }}
                        </div>
                        
                        <button @click="activeImage = '{{ Storage::url($mainImagePath) }}'" 
                                class="aspect-square rounded-lg overflow-hidden border-2" 
                                :class="{'border-black': activeImage === '{{ Storage::url($mainImagePath) }}', 'border-transparent': activeImage !== '{{ Storage::url($mainImagePath) }}'}">
                            <img src="{{ Storage::url($mainImagePath) }}" alt="Main" class="w-full h-full object-cover">
                        </button>
                        @foreach($galleryImages as $image)
                        <button @click="activeImage = '{{ Storage::url($image) }}'" 
                                class="aspect-square rounded-lg overflow-hidden border-2" 
                                :class="{'border-black': activeImage === '{{ Storage::url($image) }}', 'border-transparent': activeImage !== '{{ Storage::url($image) }}'}">
                            <img src="{{ Storage::url($image) }}" alt="Gallery" class="w-full h-full object-cover">
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Product Info -->
                <div class="flex flex-col">
                    <!-- Back to Products Button -->
                    <div class="mb-6">
                        <a href="{{ route('shop') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Products
                        </a>
                    </div>

                    <div class="flex flex-col">
                        <div class="flex justify-between items-start">
                            <h1 class="text-3xl font-semibold text-gray-900">{{ $product->product_name }}</h1>
                            <span class="text-2xl font-bold text-gray-900">LKR {{ number_format($product->product_price, 2) }}</span>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-gray-600">{{ $product->product_description }}</p>
                        </div>

                        <!-- Shop with Confidence -->
                        <div class="mt-8 bg-gray-50 rounded-lg p-6">
                            <h3 class="text-center text-lg font-semibold mb-6">SHOP WITH CONFIDENCE</h3>
                            <div class="grid grid-cols-3 gap-6">
                                <div class="text-center">
                                    <div class="flex justify-center mb-2">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm">Colombo Based</p>
                                </div>
                                <div class="text-center">
                                    <div class="flex justify-center mb-2">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm">100% Secure Payment</p>
                                </div>
                                <div class="text-center">
                                    <div class="flex justify-center mb-2">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm">650+ 5-star Reviews</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-4 mt-8">
                            @if($product->product_quantity > 0)
                                <form 
                                    x-data="{ 
                                        selectedColor: null,
                                        quantity: 1,
                                        validateForm(e) {
                                            if (!this.selectedColor) {
                                                e.preventDefault();
                                                showToast('Please select a color first');
                                                return false;
                                            }
                                            if (this.quantity < 1 || this.quantity > {{ $product->product_quantity }}) {
                                                e.preventDefault();
                                                showToast('Invalid quantity');
                                                return false;
                                            }
                                        }
                                    }" 
                                    action="{{ route('cart.buy-now') }}" 
                                    method="POST" 
                                    @submit="validateForm($event)"
                                    class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->_id }}">
                                    <input type="hidden" name="color" x-bind:value="selectedColor">
                                    
                                    <!-- Color Selection -->
                                    <div class="mb-4">
                                        <span class="text-sm font-medium text-gray-700 uppercase tracking-wider">AVAILABLE COLORS:</span>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            @foreach($product->product_colors as $color)
                                                <button type="button" 
                                                        @click="selectedColor = '{{ $color }}'"
                                                        class="color-option flex items-center space-x-2 p-2 rounded-md hover:bg-gray-100" 
                                                        :class="{ 'ring-2 ring-black': selectedColor === '{{ $color }}' }"
                                                        data-color="{{ $color }}">
                                                    <div class="w-6 h-6 rounded-full border-2" 
                                                         :class="{ 'border-black': selectedColor === '{{ $color }}', 'border-gray-300': selectedColor !== '{{ $color }}' }"
                                                         style="background-color: {{ strtolower($color) }}">
                                                    </div>
                                                    <span class="text-sm text-gray-700">{{ $color }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                        <p x-show="selectedColor === null" class="mt-2 text-sm text-red-600">
                                            Please select a color
                                        </p>
                                    </div>

                                    <!-- Quantity Selection -->
                                    <div class="mb-4">
                                        <span class="text-sm font-medium text-gray-700 uppercase tracking-wider">QUANTITY:</span>
                                        <div class="mt-2 flex items-center space-x-3">
                                            <button type="button"
                                                    @click="quantity > 1 ? quantity-- : null"
                                                    class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                                <span class="text-gray-600">-</span>
                                            </button>
                                            <input type="number"
                                                   name="quantity"
                                                   x-model="quantity"
                                                   min="1"
                                                   max="{{ $product->product_quantity }}"
                                                   class="w-16 text-center border-gray-300 rounded-md">
                                            <button type="button"
                                                    @click="quantity < {{ $product->product_quantity }} ? quantity++ : null"
                                                    class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                                                <span class="text-gray-600">+</span>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="submit" 
                                            class="w-full bg-black text-white px-6 py-3 hover:bg-gray-800 transition-colors duration-300 rounded-lg">
                                        Buy Now
                                    </button>
                                </form>
                                <form action="{{ route('wishlist.toggle') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->_id }}">
                                    <button type="submit" id="wishlist-btn" class="w-full border border-black px-6 py-3 hover:bg-gray-100 transition-colors duration-300 rounded-lg">
                                        {{ $isInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}
                                    </button>
                                </form>
                            @else
                                <button type="button" 
                                        disabled
                                        class="flex-1 bg-gray-400 text-white px-6 py-3 rounded-lg cursor-not-allowed">
                                    Out of Stock
                                </button>
                            @endif
                        </div>

                        <!-- Toast Notification -->
                        <div id="toast" class="fixed bottom-5 right-5 bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full opacity-0 transition-all duration-300 hidden">
                            <span id="toast-message"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showToast(message) {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    
    toastMessage.textContent = message;
    toast.classList.remove('hidden');
    
    // Trigger animation
    setTimeout(() => {
        toast.classList.remove('translate-y-full', 'opacity-0');
    }, 100);
    
    // Hide after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-y-full', 'opacity-0');
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 300);
    }, 3000);
}

async function toggleWishlist() {
    try {
        const response = await fetch('{{ route("wishlist.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: '{{ $product->_id }}'
            })
        });

        if (!response.ok) {
            throw new Error('Failed to update wishlist');
        }

        const data = await response.json();
        const wishlistBtn = document.getElementById('wishlist-btn');
        wishlistBtn.textContent = data.message.includes('added') ? 'Remove from Wishlist' : 'Add to Wishlist';
        showToast(data.message);
    } catch (error) {
        showToast('Error updating wishlist. Please try again.');
    }
}

// Check initial wishlist status
document.addEventListener('DOMContentLoaded', async function() {
    try {
        const response = await fetch('{{ route("wishlist.check", ["productId" => $product->_id]) }}');
        if (!response.ok) {
            throw new Error('Failed to check wishlist status');
        }
        
        const data = await response.json();
        if (data.inWishlist) {
            document.getElementById('wishlist-btn').textContent = 'Remove from Wishlist';
        }
    } catch (error) {
        console.error('Error checking wishlist status:', error);
    }
});
</script>
@endpush

</x-app-layout>
