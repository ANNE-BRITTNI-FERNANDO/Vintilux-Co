<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use App\Models\Product;

class ColorSizeSelector extends Component
{
    public $product;
    public $selectedColor = null;
    public $selectedSize = null;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function selectColor($color)
    {
        $this->selectedColor = $color;
    }

    public function selectSize($size)
    {
        $this->selectedSize = $size;
    }

    public function render()
    {
        return view('shop.color-size-selector');
    }
}
