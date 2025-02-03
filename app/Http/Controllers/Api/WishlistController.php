<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;

class WishlistController extends Controller
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

            $wishlist = Wishlist::where('user_id', $user->_id)
                ->with(['product' => function($query) {
                    $query->select(['_id', 'product_name', 'product_price', 'product_image']);
                }])
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $wishlist
            ]);
        } catch (\Exception $e) {
            \Log::error('Wishlist error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function toggle(Request $request)
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
                'product_id' => 'required'
            ]);

            $product = Product::find($request->product_id);
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found'
                ], 404);
            }

            $existingWishlist = Wishlist::where('user_id', $user->_id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($existingWishlist) {
                $existingWishlist->delete();
                $message = 'Product removed from wishlist';
                $isInWishlist = false;
            } else {
                Wishlist::create([
                    'user_id' => $user->_id,
                    'product_id' => $request->product_id
                ]);
                $message = 'Product added to wishlist';
                $isInWishlist = true;
            }

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'is_in_wishlist' => $isInWishlist
            ]);
        } catch (\Exception $e) {
            \Log::error('Wishlist toggle error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function check(Request $request, $productId)
    {
        try {
            $user = $this->getAuthenticatedUser($request);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            $exists = Wishlist::where('user_id', $user->_id)
                ->where('product_id', $productId)
                ->exists();

            return response()->json([
                'status' => 'success',
                'is_in_wishlist' => $exists
            ]);
        } catch (\Exception $e) {
            \Log::error('Wishlist check error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
