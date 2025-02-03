<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Checkout
                        </h3>
                        
                        <!-- Order Summary -->
                        <div class="mt-5">
                            <div class="border-t border-gray-200 py-4">
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Order Summary</h4>
                                <div class="mt-4 space-y-4">
                                    @foreach($cartItems as $item)
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <img src="{{ Storage::url('products/' . basename($item->product->product_image)) }}" 
                                                     alt="{{ $item->product->product_name }}" 
                                                     class="h-16 w-16 object-cover rounded">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->product->product_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        Color: {{ $item->color }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        Quantity: {{ $item->quantity }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900">
                                                LKR {{ number_format($item->price * $item->quantity, 2) }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Total -->
                            <div class="border-t border-gray-200 py-4">
                                <div class="flex justify-between items-center">
                                    <div class="text-base font-medium text-gray-900">Total</div>
                                    <div class="text-base font-medium text-gray-900">
                                        LKR {{ number_format($total, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                         <!-- Error Messages -->
                         @if ($errors->any())
                            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Please fix the following errors:</strong>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Checkout Form -->
                        <form action="{{ route('checkout.process') }}" method="POST" class="mt-6 space-y-6">
                            @csrf
                            
                            <!-- Shipping Information -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Shipping Information</h4>
                                <div class="mt-4 grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                                        <input type="text" 
                                               name="first_name" 
                                               id="first_name" 
                                               value="{{ old('first_name') }}"
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black sm:text-sm @error('first_name') border-red-300 @enderror" 
                                               required>
                                        @error('first_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                                        <input type="text" 
                                               name="last_name" 
                                               id="last_name" 
                                               value="{{ old('last_name') }}"
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black sm:text-sm @error('last_name') border-red-300 @enderror" 
                                               required>
                                        @error('last_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6">
                                        <label for="street_address" class="block text-sm font-medium text-gray-700">Street address</label>
                                        <input type="text" 
                                               name="street_address" 
                                               id="street_address" 
                                               value="{{ old('street_address') }}"
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black sm:text-sm @error('street_address') border-red-300 @enderror" 
                                               required>
                                        @error('street_address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                        <input type="text" 
                                               name="city" 
                                               id="city" 
                                               value="{{ old('city') }}"
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black sm:text-sm @error('city') border-red-300 @enderror" 
                                               required>
                                        @error('city')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal code</label>
                                        <input type="text" 
                                               name="postal_code" 
                                               id="postal_code" 
                                               value="{{ old('postal_code') }}"
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black sm:text-sm @error('postal_code') border-red-300 @enderror" 
                                               required>
                                        @error('postal_code')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone number</label>
                                        <input type="text" 
                                               name="phone_number" 
                                               id="phone_number" 
                                               value="{{ old('phone_number') }}"
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black sm:text-sm @error('phone_number') border-red-300 @enderror" 
                                               required>
                                        @error('phone_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Payment Method</h4>
                                <div class="mt-4">
                                    <div class="flex items-center">
                                        <input id="cash_on_delivery" 
                                               name="payment_method" 
                                               type="radio" 
                                               value="Cash on Delivery" 
                                               class="focus:ring-black h-4 w-4 text-black border-gray-300 @error('payment_method') border-red-300 @enderror" 
                                               checked>
                                        <label for="cash_on_delivery" class="ml-3 block text-sm font-medium text-gray-700">
                                            Cash on Delivery
                                        </label>
                                    </div>
                                    @error('payment_method')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" 
                                        class="w-full bg-black text-white px-6 py-3 rounded-md text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                    Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
