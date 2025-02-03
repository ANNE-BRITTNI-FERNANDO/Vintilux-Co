<x-app-layout>
    <!-- Page Header -->
    <div class="bg-gray-100 py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-light text-center tracking-wider">SHOPPING CART</h1>
            <p class="text-center text-gray-600 mt-4">Review and manage your selected items</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-8 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-8 text-center">
                {{ session('error') }}
            </div>
        @endif

        @if($cartItems->count() > 0)
            <div class="bg-white rounded-lg shadow-sm">
                @foreach($cartItems as $item)
                    <div class="flex items-center p-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                        <img src="{{ asset('storage/' . $item->product->product_image) }}" 
                             class="w-24 h-24 object-cover">
                        <div class="flex-1 ml-6">
                            <h2 class="text-sm font-medium tracking-wider uppercase">{{ $item->product->product_name }}</h2>
                            <p class="text-sm text-gray-500 mt-1">Color: {{ $item->color }}</p>
                            <p class="text-sm font-medium mt-1">LKR {{ number_format($item->price, 2) }}</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                       min="1" max="{{ $item->product->product_quantity }}"
                                       class="w-16 border border-gray-200 rounded px-2 py-1 text-sm">
                                <button type="submit" class="ml-2 px-4 py-1 border border-black text-xs uppercase tracking-wider hover:bg-black hover:text-white transition-colors duration-300">
                                    Update
                                </button>
                            </form>
                            
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-1 border border-red-500 text-red-500 text-xs uppercase tracking-wider hover:bg-red-500 hover:text-white transition-colors duration-300">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <div class="p-6 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-4">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-6 py-2 border border-gray-300 text-xs uppercase tracking-wider hover:bg-gray-100 transition-colors duration-300">
                                    Clear Cart
                                </button>
                            </form>
                            <a href="{{ route('shop') }}" class="px-6 py-2 border border-black text-xs uppercase tracking-wider hover:bg-black hover:text-white transition-colors duration-300 inline-block">
                                Continue Shopping
                            </a>
                        </div>

                        <div class="text-right">
                            <p class="text-sm text-gray-600 tracking-wider uppercase mb-2">Total</p>
                            <p class="text-2xl font-light tracking-wider">
                                LKR {{ number_format($cartItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}
                            </p>
                            <a href="{{ route('checkout') }}" class="mt-4 px-8 py-3 bg-black text-white text-xs uppercase tracking-wider hover:bg-gray-900 transition-colors duration-300 inline-block">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <p class="text-gray-600 tracking-wider mb-6">Your cart is empty</p>
                <a href="{{ route('shop') }}" class="px-6 py-2 border border-black text-xs uppercase tracking-wider hover:bg-black hover:text-white transition-colors duration-300 inline-block">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>

    @include('livewire.layout.footer')
</x-app-layout>