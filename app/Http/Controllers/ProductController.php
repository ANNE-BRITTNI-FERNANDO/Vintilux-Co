<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'product_name' => 'required|string|max:255',
                'product_description' => 'required|string',
                'product_price' => 'required|numeric|min:0',
                'product_size' => 'required|string',
                'product_colors' => 'required|array|min:1',
                'product_colors.*' => 'required|string|in:Black,Brown,Tan,Navy,White,Gray,Red,Beige',
                'product_quantity' => 'required|integer',
                'product_category' => 'required|in:handbags,accessories',
                'product_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'product_gallery.*' => 'image|mimes:jpeg,png,jpg|max:2048',
                'product_gallery' => 'required|array',
                'product_status' => 'required|in:0,1'
            ]);

            // Save the product image
            $productImagePath = null;
            if ($request->hasFile('product_image')) {
                $productImagePath = $request->file('product_image')->store('products', 'public');
                // \Log::info("Product image stored at: " . $productImagePath); // Debugging log
            }

            // Save the product gallery images
            $productGalleryPaths = [];
            if ($request->hasFile('product_gallery')) {
                foreach($request->file('product_gallery') as $file) {
                    // \Log::info("Product gallery file details:");
                    // \Log::info("Original Name: " . $file->getClientOriginalName());
                    // \Log::info("MIME Type: " . $file->getClientMimeType());
                    // \Log::info("File Size: " . $file->getSize());
                    
                    $path = $file->store('product_galleries', 'public');
                    $productGalleryPaths[] = $path;
                    // \Log::info("Product gallery image stored at: " . $path); // Debugging log
                }
            }

            // Create the product record
            $product = Product::create([
                'product_name' => $validated['product_name'],
                'product_description' => $validated['product_description'],
                'product_price' => $validated['product_price'],
                'product_size' => $validated['product_size'],
                'product_colors' => $validated['product_colors'],
                'product_quantity' => $validated['product_quantity'],
                'product_category' => $validated['product_category'],
                'product_image' => $productImagePath, // Store the path to MongoDB
                'product_gallery' => $productGalleryPaths, // Store the path to MongoDB
                'product_status' => $validated['product_status']
            ]);

            return redirect()->back()->with('success_message', 'Product added successfully');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error creating product: ' . $e->getMessage());
            
            // Return error message
            return redirect()->back()
                ->withInput()
                ->with('error_message', 'Failed to create product. Please try again.');
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        $productDetails = Product::find($product['_id']);
        return view('admin.products.edit', compact('productDetails')); //['product' => $product] shorthand is compact('product') in Laravel,  creates an associative array where the key is the string 'product' and the value is the variable $product.
        // echo $product['_id']; die;
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if($request->isMethod('put')){
            // Validate basic fields
            $rules = [
                'product_name' => 'required|string|max:255',
                'product_description' => 'required|string',
                'product_price' => 'required|numeric|gt:0',
                'product_size' => 'required|string',
                'product_colors' => 'required|array|min:1',
                'product_colors.*' => 'required|string|in:Black,Brown,Tan,Navy,White,Gray,Red,Beige',
                'product_quantity' => 'required|integer',
                'product_category' => 'required|in:handbags,accessories',
                'product_status' => 'required|in:0,1'
            ];

            // Add image validation rules if new images are being uploaded
            if ($request->hasFile('product_image')) {
                $rules['product_image'] = 'image|mimes:jpeg,png,jpg|max:2048';
            }
            if ($request->hasFile('product_gallery')) {
                $rules['product_gallery.*'] = 'image|mimes:jpeg,png,jpg|max:2048';
                $rules['product_gallery'] = 'array';
            }

            $data = $request->validate($rules);

            $product = Product::find($product['_id']);
            if (!$product) {
                return redirect()->back()->with('error_message', 'Product not found');
            }

            // Handle main product image update
            if ($request->hasFile('product_image')) {
                // Delete old image if it exists
                if ($product->product_image) {
                    Storage::disk('public')->delete($product->product_image);
                }
                $data['product_image'] = $request->file('product_image')->store('products', 'public');
            }

            // Handle gallery images update
            if ($request->hasFile('product_gallery')) {
                // Delete old gallery images if they exist
                if (!empty($product->product_gallery)) {
                    foreach ($product->product_gallery as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                
                $galleryPaths = [];
                foreach($request->file('product_gallery') as $image) {
                    $galleryPaths[] = $image->store('product_galleries', 'public');
                }
                $data['product_gallery'] = $galleryPaths;
            }

            $product->update($data);

            return redirect()->route('admin.products.index')->with('success_message', 'Product updated successfully!');
        }
        
        return redirect()->back()->with('error_message', 'Invalid request method');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //delete the product
        $product = Product::find($product['_id']);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success_message', 'Product deleted successfully!');
    }

    // API Methods
    public function apiIndex()
    {
        $products = Product::all();
        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function apiShow($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    public function getNewArrivals()
    {
        $newArrivals = Product::where('product_status', '1')
                            ->orderBy('created_at', 'desc')
                            ->take(4)
                            ->get();
        return $newArrivals;
    }

    public function getAllProducts()
    {
        $allProducts = Product::where('product_status', '1')
                            ->get();
        return $allProducts;
    }

    public function getAllHandbags()
    {
        $allHandbags = Product::where('product_status', '1')
                            ->where('product_category', 'handbags')
                            ->get();
        return $allHandbags;
    }

    public function getAllAccessories()
    {
        $allAccessories = Product::where('product_status', '1')
                            ->where('product_category', 'accessories')
                            ->get();
        return $allAccessories;
    }

    public function showAllProducts()
    {
        $products = $this->getAllProducts();
        return view('shop.index', compact('products'));
    }

    public function showHandbags()
    {
        $handbags = $this->getAllHandbags();
        return view('shop.handbags', compact('handbags'));
    }

    public function showAccessories()
    {
        $accessories = $this->getAllAccessories();
        return view('shop.accessories', compact('accessories'));
    }

    public function showProductDetails($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return redirect()->route('shop')->with('error', 'Product not found');
        }

        $isInWishlist = false;
        if (auth()->check()) {
            $isInWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                ->where('product_id', $id)
                ->exists();
        }

        return view('shop.product-details', compact('product', 'isInWishlist'));
    }
}
