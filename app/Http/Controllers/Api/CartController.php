<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;

class CartController extends Controller
{
    protected function getAuthenticatedUser(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        return User::where('api_token', hash('sha256', $token))->first();
    }

    public function index(Request $request)
    {
        try {
            $user = $this->getAuthenticatedUser($request);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            // Fetch the cart items for the authenticated user
            $cart = Cart::where('user_id', $user->_id)
                ->with(['product' => function($query) {
                    $query->select(['_id', 'product_name', 'product_price', 'product_image']);
                }])
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $cart
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = $this->getAuthenticatedUser($request);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            $request->validate([
                'product_id' => 'required|exists:products,_id', // Ensure product exists
                'quantity' => 'required|integer|min:1'
            ]);

            $product = Product::find($request->product_id);
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found'
                ], 404);
            }

            $existingCart = Cart::where('user_id', $user->_id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($existingCart) {
                // Update existing cart item if the product is already in the cart
                $existingCart->quantity = $request->quantity;
                $existingCart->save();
                $cart = $existingCart;
            } else {
                // Create a new cart item if it doesn't exist
                $cart = Cart::create([
                    'user_id' => $user->_id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price' => $product->product_price
                ]);
            }

            // Reload product data into the cart response
            $cart->load('product');

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart',
                'data' => $cart
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Cart store error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->getAuthenticatedUser($request);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            $cart = Cart::where('user_id', $user->_id)
                ->where('_id', $id)
                ->first();

            if (!$cart) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cart item not found'
                ], 404);
            }

            $cart->quantity = $request->quantity;
            $cart->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated successfully',
                'data' => $cart->load('product')
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart update error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = $this->getAuthenticatedUser($request);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            $cart = Cart::where('user_id', $user->_id)
                ->where('_id', $id)
                ->first();

            if (!$cart) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cart item not found'
                ], 404);
            }

            $cart->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Item removed from cart'
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart delete error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function clear(Request $request)
    {
        try {
            $user = $this->getAuthenticatedUser($request);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            Cart::where('user_id', $user->_id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Cart cleared successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart clear error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,_id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Add product directly to cart for checkout (buy now)
        $user = $this->getAuthenticatedUser($request);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        $cart = Cart::create([
            'user_id' => $user->_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product ready for checkout',
            'data' => $cart
        ], 201);
    }
}
