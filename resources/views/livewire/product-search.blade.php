<div>
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search Input -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input wire:model.live="search" type="text" id="search" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    placeholder="Search products...">
            </div>

            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                <select wire:model.live="category" id="category" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <option value="">All Categories</option>
                    <option value="handbags">Handbags</option>
                    <option value="accessories">Accessories</option>
                </select>
            </div>

            <!-- Price Range -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Price Range</label>
                <div class="flex gap-2">
                    <input wire:model.live="minPrice" type="number" placeholder="Min" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <input wire:model.live="maxPrice" type="number" placeholder="Max" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
            </div>

            <!-- Sort By -->
            <div>
                <label for="sortBy" class="block text-sm font-medium text-gray-700">Sort By</label>
                <select wire:model.live="sortBy" id="sortBy" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <option value="newest">Newest</option>
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                    <option value="name">Name</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800">{{ $product->product_name }}</h3>
                <p class="text-gray-600 mt-1">Rs. {{ number_format($product->product_price, 2) }}</p>
                <div class="mt-4 flex justify-between items-center">
                    <a href="{{ route('shop.show', $product->_id) }}" class="text-primary hover:text-primary-dark">View Details</a>
                    <button onclick="addToCart('{{ $product->_id }}')" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
