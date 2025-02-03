<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class SearchProducts extends Component
{
    public $search = '';
    public $results = [];

    public function mount()
    {
        $this->results = [];
    }

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->results = Product::where('product_name', 'regexp', '/' . $this->search . '/i')
                ->orWhere('product_description', 'regexp', '/' . $this->search . '/i')
                ->take(5)
                ->get();

            // Debug information
            logger()->info('Search Query:', [
                'search' => $this->search,
                'results_count' => count($this->results)
            ]);
        } else {
            $this->results = [];
        }
    }

    public function render()
    {
        return view('livewire.search-products');
    }
}
