<x-app-layout>
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">My Wishlist</h1>
            <a href="{{ route('shop') }}" class="text-black hover:text-gray-600 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Continue Shopping
            </a>
        </div>

        @if($wishlistItems->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($wishlistItems as $item)
                    @php
                        $mainImagePath = 'products/' . basename($item->product->product_image);
                    @endphp
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden" id="wishlist-item-{{ $item->_id }}">
                        <div class="aspect-w-4 aspect-h-3">
                            <img src="{{ Storage::url($mainImagePath) }}" 
                                 alt="{{ $item->product->product_name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->product->product_name }}</h3>
                            <p class="text-gray-600 mt-2">LKR {{ number_format($item->product->product_price, 2) }}</p>
                            <p class="text-sm text-gray-500 mt-2">{{ Str::limit($item->product->product_description, 100) }}</p>
                            
                            <div class="mt-6 space-y-3">
                                <a href="{{ route('shop.product.details', $item->product->_id) }}" 
                                   class="block w-full bg-black text-white px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors duration-300 text-center">
                                    View Details
                                </a>
                                <button onclick="removeFromWishlist('{{ $item->_id }}')" 
                                        class="w-full border border-black text-black px-4 py-3 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                                    Remove from Wishlist
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Your wishlist is empty</h3>
                <p class="mt-1 text-sm text-gray-500">Browse our products and add items to your wishlist.</p>
                <div class="mt-6">
                    <a href="{{ route('shop') }}" class="inline-flex items-center px-6 py-3 border border-black text-base font-medium rounded-lg text-black bg-white hover:bg-gray-100 transition-colors duration-300">
                        Start Shopping
                    </a>
                </div>
            </div>
        @endif

        <!-- Color Selection Modal -->
        <div id="colorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold mb-4">Select Color</h3>
                <div id="colorOptions" class="grid grid-cols-2 gap-4 mb-6">
                    <!-- Color options will be inserted here -->
                </div>
                <div class="flex justify-end space-x-4">
                    <button onclick="closeColorModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                        Cancel
                    </button>
                    <button onclick="addToCartWithColor()" class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function removeFromWishlist(wishlistId) {
    fetch(`/wishlist/${wishlistId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === 'Product removed from wishlist') {
            const item = document.getElementById(`wishlist-item-${wishlistId}`);
            item.style.opacity = '0';
            setTimeout(() => {
                item.remove();
                // Check if wishlist is empty
                if (document.querySelectorAll('[id^="wishlist-item-"]').length === 0) {
                    location.reload(); // Reload to show empty state
                }
            }, 300);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to remove product from wishlist. Please try again.');
    });
}
</script>
@endpush

</x-app-layout>