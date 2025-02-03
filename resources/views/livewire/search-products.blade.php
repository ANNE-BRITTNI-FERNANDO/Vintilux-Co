<div class="relative">
    <div class="flex items-center bg-white rounded-lg shadow-sm">
        <input
            wire:model.live.debounce.300ms="search"
            type="text"
            placeholder="Search products..."
            class="w-full px-4 py-2 rounded-lg focus:outline-none"
        >
        <div class="px-4">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Debug Info -->
    @if(app()->environment('local'))
        <div class="mt-2 text-xs text-gray-500">
            Search term: "{{ $search }}"<br>
            Results found: {{ count($results) }}
        </div>
    @endif

    @if(!empty($search) && count($results) > 0)
        <div class="absolute z-50 w-full mt-2 bg-white rounded-lg shadow-lg">
            @foreach($results as $product)
                <a href="{{ route('shop.product.details', $product->_id) }}" class="block px-4 py-2 hover:bg-gray-100">
                    <div class="text-sm font-medium text-gray-900">{{ $product->product_name }}</div>
                    <div class="text-xs text-gray-500">{{ Str::limit($product->product_description, 50) }}</div>
                    <div class="text-xs font-medium text-gray-700">LKR {{ number_format($product->product_price, 2) }}</div>
                </a>
            @endforeach
        </div>
    @endif
</div>
