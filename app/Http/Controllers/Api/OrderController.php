<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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

            $orders = Order::where('user_id', $user->_id)
                ->with(['items.product' => function($query) {
                    $query->select(['_id', 'product_name', 'product_price', 'product_image']);
                }])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $orders
            ]);
        } catch (\Exception $e) {
            \Log::error('Order list error: ' . $e->getMessage());
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
                'shipping_address' => 'required',
                'payment_method' => 'required'
            ]);

            DB::beginTransaction();

            // Get cart items
            $cartItems = Cart::where('user_id', $user->_id)
                ->with('product')
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cart is empty'
                ], 400);
            }

            // Calculate total
            $total = $cartItems->sum(function($item) {
                return $item->quantity * $item->product->product_price;
            });

            // Create order
            $order = Order::create([
                'user_id' => $user->_id,
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'status' => 'pending'
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->_id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->product_price
                ]);
            }

            // Clear cart
            Cart::where('user_id', $user->_id)->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully',
                'data' => $order->load('items.product')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $user = $this->getAuthenticatedUser($request);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            $order = Order::where('user_id', $user->_id)
                ->where('_id', $id)
                ->with(['items.product' => function($query) {
                    $query->select(['_id', 'product_name', 'product_price', 'product_image']);
                }])
                ->first();

            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $order
            ]);
        } catch (\Exception $e) {
            \Log::error('Order show error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
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
                'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
            ]);

            $order = Order::where('user_id', $user->_id)
                ->where('_id', $id)
                ->first();

            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found'
                ], 404);
            }

            $order->status = $request->status;
            $order->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Order status updated',
                'data' => $order->load('items.product')
            ]);
        } catch (\Exception $e) {
            \Log::error('Order status update error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
