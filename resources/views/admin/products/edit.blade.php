<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Product') }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success_message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success_message') }}</span>
                </div>
            @endif

            @if(session('error_message'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error_message') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.products.update', $productDetails['_id']) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                    <input type="text" id="product_name" name="product_name" value="{{ $productDetails['product_name'] }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('product_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="product_description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="product_description" name="product_description" rows="4" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ $productDetails['product_description'] }}</textarea>
                                    @error('product_description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="product_price" class="block text-sm font-medium text-gray-700">Price</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">LKR</span>
                                        </div>
                                        <input type="number" id="product_price" name="product_price" value="{{ $productDetails['product_price'] }}"
                                            class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>
                                    @error('product_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="product_quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                    <input type="number" id="product_quantity" name="product_quantity" value="{{ $productDetails['product_quantity'] }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('product_quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="product_category" class="block text-sm font-medium text-gray-700">Category</label>
                                    <select id="product_category" name="product_category" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select Category</option>
                                        <option value="handbags" {{ $productDetails['product_category'] == 'handbags' ? 'selected' : '' }}>Handbags</option>
                                        <option value="accessories" {{ $productDetails['product_category'] == 'accessories' ? 'selected' : '' }}>Accessories</option>
                                    </select>
                                    @error('product_category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="product_status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select id="product_status" name="product_status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="1" {{ $productDetails['product_status'] == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $productDetails['product_status'] == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('product_status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="product_size" class="block text-sm font-medium text-gray-700">Size</label>
                                    <input type="text" id="product_size" name="product_size" value="{{ $productDetails['product_size'] }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('product_size')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Current Image</label>
                                    @if($productDetails['product_image'])
                                        <img src="{{ asset('storage/' . $productDetails['product_image']) }}" 
                                             alt="Current Image" 
                                             class="mt-2 h-32 w-32 object-cover rounded-lg shadow">
                                    @endif
                                    <label for="product_image" class="mt-2 block text-sm font-medium text-gray-700">Change Image</label>
                                    <input type="file" id="product_image" name="product_image"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    @error('product_image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Colors Available</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @php
                                    $colors = ['Black', 'Brown', 'Tan', 'Navy', 'White', 'Gray', 'Red', 'Beige'];
                                    $selectedColors = $productDetails['product_colors'] ?? [];
                                @endphp
                                @foreach($colors as $color)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="product_colors[]" value="{{ $color }}" 
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            {{ in_array($color, $selectedColors) ? 'checked' : '' }}>
                                        <label class="ml-2 text-sm text-gray-700">{{ $color }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('product_colors')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Gallery</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                @if(!empty($productDetails['product_gallery']))
                                    @foreach($productDetails['product_gallery'] as $galleryImage)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $galleryImage) }}" 
                                                 alt="Gallery image" 
                                                 class="h-32 w-full object-cover rounded-lg shadow">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <label for="product_gallery" class="block text-sm font-medium text-gray-700">Add Gallery Images</label>
                            <input type="file" id="product_gallery" name="product_gallery[]" multiple
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('product_gallery')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
