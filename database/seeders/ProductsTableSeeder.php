<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'product_name' => 'Classic Leather Handbag',
                'product_description' => 'Elegant leather handbag perfect for everyday use',
                'product_price' => 299.99,
                'product_category' => 'handbags',
                'product_size' => 'medium',
                'product_colors' => ['black', 'brown', 'tan'],
                'product_status' => 'in_stock',
                'product_quantity' => 10,
                'product_image' => 'handbags/classic-leather.jpg',
                'product_gallery' => ['handbags/classic-leather-1.jpg', 'handbags/classic-leather-2.jpg'],
            ],
            [
                'product_name' => 'Designer Clutch',
                'product_description' => 'Stylish evening clutch with gold accents',
                'product_price' => 199.99,
                'product_category' => 'accessories',
                'product_size' => 'small',
                'product_colors' => ['gold', 'silver', 'rose_gold'],
                'product_status' => 'in_stock',
                'product_quantity' => 15,
                'product_image' => 'accessories/designer-clutch.jpg',
                'product_gallery' => ['accessories/designer-clutch-1.jpg', 'accessories/designer-clutch-2.jpg'],
            ],
            [
                'product_name' => 'Vintage Tote Bag',
                'product_description' => 'Spacious vintage-style tote perfect for work or travel',
                'product_price' => 249.99,
                'product_category' => 'handbags',
                'product_size' => 'large',
                'product_colors' => ['navy', 'burgundy', 'forest_green'],
                'product_status' => 'in_stock',
                'product_quantity' => 8,
                'product_image' => 'handbags/vintage-tote.jpg',
                'product_gallery' => ['handbags/vintage-tote-1.jpg', 'handbags/vintage-tote-2.jpg'],
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
