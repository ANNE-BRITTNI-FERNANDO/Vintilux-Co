<?php

// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    public function store(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->with('items')->first();
        
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $cart->total_amount,
            'status' => 'pending'
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        // Clear cart
        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    public function index()
    {
        try {
            \Log::info('Loading orders for user: ' . Auth::id());
            
            $orders = Order::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            $ordersWithItems = [];
            foreach ($orders as $order) {
                $orderItems = OrderItem::where('order_id', $order->_id)->get();
                
                // Get product details for each item
                $items = [];
                foreach ($orderItems as $item) {
                    $product = Product::find($item->product_id);
                    
                    // Log product details for debugging
                    \Log::info('Product details:', [
                        'product_id' => $item->product_id,
                        'product' => $product ? $product->toArray() : 'not found'
                    ]);
                    
                    $items[] = [
                        'product_id' => $item->product_id,
                        'product_name' => $product ? $product->product_name : $item->product_name,
                        'quantity' => $item->quantity,
                        'price' => $product ? $product->product_price : $item->price,
                        'color' => $item->color,
                        'product_image' => $product ? $product->product_image : null,
                        'product_gallery' => $product ? $product->product_gallery : [],
                        'product_description' => $product ? $product->product_description : null,
                        'subtotal' => $item->quantity * ($product ? $product->product_price : $item->price)
                    ];
                }

                // Calculate total amount from items if not set
                $totalAmount = $order->total_amount ?? collect($items)->sum('subtotal');

                $ordersWithItems[] = [
                    '_id' => $order->_id,
                    'created_at' => $order->created_at,
                    'total_amount' => $totalAmount,
                    'first_name' => $order->first_name,
                    'last_name' => $order->last_name,
                    'street_address' => $order->street_address,
                    'city' => $order->city,
                    'postal_code' => $order->postal_code,
                    'phone_number' => $order->phone_number,
                    'payment_method' => $order->payment_method,
                    'items' => $items
                ];
            }

            \Log::info('Found ' . count($ordersWithItems) . ' orders');
            
            return view('orders.index', compact('ordersWithItems'));
            
        } catch (\Exception $e) {
            \Log::error('Error loading orders: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->route('shop')
                ->with('error', 'There was an error loading your orders. Please try again later.');
        }
    }

    public function adminIndex()
    {
        try {
            $orders = Order::with(['items', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();

            $ordersWithItems = [];
            foreach ($orders as $order) {
                $items = [];
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    $items[] = [
                        'product_id' => $item->product_id,
                        'product_name' => $product ? $product->product_name : 'Product Deleted',
                        'quantity' => $item->quantity,
                        'price' => $product ? $product->product_price : $item->price,
                        'product_image' => $product ? $product->product_image : null,
                        'subtotal' => $item->quantity * ($product ? $product->product_price : $item->price)
                    ];
                }

                $ordersWithItems[] = [
                    '_id' => $order->_id,
                    'user' => $order->user ? [
                        'name' => $order->user->name,
                        'email' => $order->user->email
                    ] : null,
                    'created_at' => $order->created_at,
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'first_name' => $order->first_name,
                    'last_name' => $order->last_name,
                    'street_address' => $order->street_address,
                    'city' => $order->city,
                    'postal_code' => $order->postal_code,
                    'phone_number' => $order->phone_number,
                    'payment_method' => $order->payment_method,
                    'items' => $items
                ];
            }

            return view('admin.orders.index', compact('ordersWithItems'));
            
        } catch (\Exception $e) {
            \Log::error('Error loading admin orders: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->route('admin.dashboard')
                ->with('error', 'There was an error loading orders. Please try again later.');
        }
    }

    public function adminShow(Order $order)
    {
        try {
            $order->load(['items', 'user']);
            
            $items = [];
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                $items[] = [
                    'product_id' => $item->product_id,
                    'product_name' => $product ? $product->product_name : 'Product Deleted',
                    'quantity' => $item->quantity,
                    'price' => $product ? $product->product_price : $item->price,
                    'product_image' => $product ? $product->product_image : null,
                    'subtotal' => $item->quantity * ($product ? $product->product_price : $item->price)
                ];
            }

            $orderDetails = [
                '_id' => $order->_id,
                'user' => $order->user ? [
                    'name' => $order->user->name,
                    'email' => $order->user->email
                ] : null,
                'created_at' => $order->created_at,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'first_name' => $order->first_name,
                'last_name' => $order->last_name,
                'street_address' => $order->street_address,
                'city' => $order->city,
                'postal_code' => $order->postal_code,
                'phone_number' => $order->phone_number,
                'payment_method' => $order->payment_method,
                'items' => $items
            ];

            return view('admin.orders.show', compact('orderDetails'));
            
        } catch (\Exception $e) {
            \Log::error('Error loading admin order details: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->route('admin.orders.index')
                ->with('error', 'There was an error loading order details. Please try again later.');
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,processing,completed,cancelled'
            ]);

            $order->update([
                'status' => $request->status
            ]);

            return redirect()->route('admin.orders.show', $order->_id)
                ->with('success', 'Order status updated successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Error updating order status: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'There was an error updating the order status.');
        }
    }
}