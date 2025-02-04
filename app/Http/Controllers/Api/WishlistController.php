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
    /**
     * Get authenticated user from the token.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\User|null
     */
    protected function getAuthenticatedUser(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        return User::where('api_token', hash('sha256', $token))->first();
    }

    /**
     * Get the wishlist of an authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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

            // Fetching the wishlist items using the authenticated user and using proper ObjectId comparison
            $wishlist = Wishlist::where('user_id', new ObjectId($user->_id))
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

    /**
     * Toggle product in the user's wishlist.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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

            // Validate product_id in the request
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

            // Check if the product already exists in the wishlist
            $existingWishlist = Wishlist::where('user_id', new ObjectId($user->_id))
                ->where('product_id', new ObjectId($request->product_id))
                ->first();

            if ($existingWishlist) {
                // Remove product from the wishlist
                $existingWishlist->delete();
                $message = 'Product removed from wishlist';
                $isInWishlist = false;
            } else {
                // Add product to the wishlist
                Wishlist::create([
                    'user_id' => new ObjectId($user->_id),
                    'product_id' => new ObjectId($request->product_id)
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

    /**
     * Check if a product is in the user's wishlist.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $productId
     * @return \Illuminate\Http\Response
     */
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

            // Check if the product is already in the user's wishlist
            $exists = Wishlist::where('user_id', new ObjectId($user->_id))
                ->where('product_id', new ObjectId($productId))
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
