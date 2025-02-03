<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Details') }} #{{ substr($orderDetails['_id'], -8) }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Orders
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                            <p><strong>Name:</strong> {{ $orderDetails['first_name'] }} {{ $orderDetails['last_name'] }}</p>
                            <p><strong>Email:</strong> {{ $orderDetails['user']['email'] ?? 'N/A' }}</p>
                            <p><strong>Phone:</strong> {{ $orderDetails['phone_number'] }}</p>
                            <p><strong>Address:</strong> {{ $orderDetails['street_address'] }}</p>
                            <p><strong>City:</strong> {{ $orderDetails['city'] }}</p>
                            <p><strong>Postal Code:</strong> {{ $orderDetails['postal_code'] }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Order Information</h3>
                            <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($orderDetails['created_at'])->format('M d, Y H:i') }}</p>
                            <p><strong>Payment Method:</strong> {{ $orderDetails['payment_method'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orderDetails['items'] as $item)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ $item['product_name'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($item['product_image'])
                                                <img src="{{ asset('storage/' . $item['product_image']) }}" 
                                                     alt="{{ $item['product_name'] }}"
                                                     class="h-20 w-20 object-cover rounded">
                                            @else
                                                <div class="h-20 w-20 bg-gray-100 flex items-center justify-center rounded">
                                                    <span class="text-gray-400">No image</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            LKR{{ number_format($item['price'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $item['quantity'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            LKR{{ number_format($item['subtotal'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td colspan="4" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                        Total:
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        LKR{{ number_format(collect($orderDetails['items'])->sum('subtotal'), 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
