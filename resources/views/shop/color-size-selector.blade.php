<div>
    @if($product->product_colors)
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Color
            </label>
            <div class="flex flex-wrap gap-2">
                @foreach($product->product_colors as $color)
                    <button type="button"
                            wire:click="selectColor('{{ $color }}')"
                            class="px-4 py-2 border rounded-md {{ $selectedColor === $color ? 'border-black bg-gray-100' : 'border-gray-300' }}">
                        {{ ucfirst($color) }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    @if($product->product_sizes)
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Size
            </label>
            <div class="flex flex-wrap gap-2">
                @foreach($product->product_sizes as $size)
                    <button type="button"
                            wire:click="selectSize('{{ $size }}')"
                            class="px-4 py-2 border rounded-md {{ $selectedSize === $size ? 'border-black bg-gray-100' : 'border-gray-300' }}">
                        {{ strtoupper($size) }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    <input type="hidden" name="color" value="{{ $selectedColor }}" />
    <input type="hidden" name="size" value="{{ $selectedSize }}" />
</div>
