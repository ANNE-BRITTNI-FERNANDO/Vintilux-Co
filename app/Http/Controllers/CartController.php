<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();
            
        return view('cart.index', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'color' => 'required',
        ]);

        $product = Product::find($request->product_id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        if ($product->product_quantity < $request->quantity) {
            return response()->json([
                'message' => 'Sorry, only ' . $product->product_quantity . ' items available in stock'
            ], 400);
        }

        $cart = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'color' => $request->color,
            ],
            [
                'quantity' => $request->quantity,
                'price' => $product->product_price,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Product successfully added to your cart',
            'cart_count' => Cart::where('user_id', Auth::id())->count()
        ]);
    }

    public function buyNow(Request $request)
    {
        Log::info('Buy Now Request:', $request->all());

        try {
            $request->validate([
                'product_id' => 'required',
                'quantity' => 'required|integer|min:1',
                'color' => 'required',
            ]);

            $product = Product::findOrFail($request->product_id);
            
            if ($product->product_quantity < $request->quantity) {
                return redirect()->back()->with('error', 'Sorry, only ' . $product->product_quantity . ' items available in stock');
            }

            // Add this item to cart
            $cart = Cart::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'color' => $request->color,
                ],
                [
                    'quantity' => $request->quantity,
                    'price' => $product->product_price,
                ]
            );

            Log::info('Cart Item Created:', $cart->toArray());

            return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
        } catch (\Exception $e) {
            Log::error('Buy Now Error:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error adding product to cart: ' . $e->getMessage());
        }
    }

    public function updateQuantity(Request $request, $cartId)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $cart = Cart::findOrFail($cartId);
    $product = $cart->product;

    if ($product->product_quantity < $request->quantity) {
        return redirect()->back()->with('error', 'Requested quantity not available in stock');
    }

    $cart->update([
        'quantity' => $request->quantity,
        'price' => $product->product_price
    ]);

    return redirect()->back()->with('success', 'Cart updated successfully');
}

public function destroy($cartId)
{
    $cart = Cart::findOrFail($cartId);
    $cart->delete();

    return redirect()->back()->with('success', 'Item removed from cart');
}

public function clearCart()
{
    Cart::where('user_id', Auth::id())->delete();
    return redirect()->back()->with('success', 'Cart cleared successfully');
}

public function checkout()
{
    return redirect()->route('orders.store');
}
}
