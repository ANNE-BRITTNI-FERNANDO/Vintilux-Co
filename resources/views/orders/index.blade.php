<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Page Title -->
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Order History</h1>
                    <a href="{{ route('shop') }}" class="inline-flex items-center text-black hover:text-gray-800">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Continue Shopping
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded relative" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(count($ordersWithItems) > 0)
                    @foreach($ordersWithItems as $order)
                        <div class="bg-white shadow-lg rounded-lg mb-8 overflow-hidden">
                            <!-- Order Header -->
                            <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Order #{{ substr($order['_id'], -8) }}</h3>
                                        <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($order['created_at'])->format('F d, Y \a\t h:i A') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">{{ $order['payment_method'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h4 class="text-sm font-medium text-gray-700 uppercase tracking-wider mb-2">Shipping Details</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-900">{{ $order['first_name'] }} {{ $order['last_name'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $order['street_address'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $order['city'] }}, {{ $order['postal_code'] }}</p>
                                        <p class="text-sm text-gray-600">Phone: {{ $order['phone_number'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="px-6 py-4">
                                <h4 class="text-sm font-medium text-gray-700 uppercase tracking-wider mb-4">Order Items</h4>
                                <div class="space-y-4">
                                    @foreach($order['items'] as $item)
                                        <div class="flex items-center space-x-4 py-4 border-b border-gray-200 last:border-0">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded-md overflow-hidden">
                                                @if($item['product_image'])
                                                    @php
                                                        $mainImagePath = 'products/' . basename($item['product_image']);
                                                        \Log::info('Order Item Image Path: ' . $mainImagePath);
                                                    @endphp
                                                    <img src="{{ Storage::url($mainImagePath) }}" 
                                                         alt="{{ $item['product_name'] }}" 
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Product Details -->
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $item['product_name'] }}</h4>
                                                @if($item['product_description'])
                                                    <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $item['product_description'] }}</p>
                                                @endif
                                                <div class="mt-2 space-y-1">
                                                    <p class="text-sm text-gray-500">
                                                        <span class="font-medium">Color:</span> 
                                                        <span class="capitalize">{{ $item['color'] }}</span>
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        <span class="font-medium">Quantity:</span> 
                                                        {{ $item['quantity'] }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">
                                                        <span class="font-medium">Price:</span> 
                                                        LKR {{ number_format($item['price'], 2) }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Price -->
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-900">
                                                    LKR {{ number_format($item['subtotal'], 2) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white shadow-lg rounded-lg p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No orders yet</h3>
                        <p class="mt-2 text-sm text-gray-600">Start shopping to create your first order.</p>
                        <div class="mt-6">
                            <a href="{{ route('shop') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                Browse Products
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>