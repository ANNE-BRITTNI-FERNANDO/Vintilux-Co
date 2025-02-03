<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();
            
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        
        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        try {
            \Log::info('Starting checkout process');
            
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'street_address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'postal_code' => 'required|string|max:20',
                'phone_number' => 'required|string|max:20',
                'payment_method' => 'required|string|in:Cash on Delivery',
            ]);

            \Log::info('Validation passed');

            // Get cart items
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Your cart is empty.');
            }

            \Log::info('Found cart items: ' . $cartItems->count());

            // Check product availability
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                if ($product->product_quantity < $cartItem->quantity) {
                    return redirect()->back()->with('error', "Sorry, {$product->product_name} only has {$product->product_quantity} items available.");
                }
            }

            $total = $cartItems->sum(function($item) {
                return $item->quantity * $item->product->price;
            });

            \Log::info('Calculated total: ' . $total);

            // Create order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->total_amount = $total;
            $order->first_name = $validated['first_name'];
            $order->last_name = $validated['last_name'];
            $order->street_address = $validated['street_address'];
            $order->city = $validated['city'];
            $order->postal_code = $validated['postal_code'];
            $order->phone_number = $validated['phone_number'];
            $order->payment_method = $validated['payment_method'];
            $order->created_at = now();
            $order->updated_at = now();
            
            \Log::info('Saving order');
            $order->save();
            \Log::info('Order saved with ID: ' . $order->_id);

            // Create order items and update product quantities
            foreach ($cartItems as $cartItem) {
                \Log::info('Creating order item for product: ' . $cartItem->product->name);
                
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->_id;
                $orderItem->product_id = $cartItem->product->_id;
                $orderItem->product_name = $cartItem->product->name;
                $orderItem->quantity = $cartItem->quantity;
                $orderItem->price = $cartItem->product->price;
                $orderItem->color = $cartItem->color;
                $orderItem->created_at = now();
                $orderItem->updated_at = now();
                
                $orderItem->save();
                \Log::info('Order item saved');

                // Update product quantity
                $product = $cartItem->product;
                $product->product_quantity -= $cartItem->quantity;
                $product->save();
                \Log::info("Updated quantity for product {$product->product_name}: {$product->product_quantity}");
            }

            // Clear the cart
            Cart::where('user_id', Auth::id())->delete();
            \Log::info('Cart cleared');

            // Store order details in session
            session()->flash('order_id', $order->_id);
            session()->flash('order_total', $total);

            // Redirect to success page
            return redirect()->route('checkout.success');

        } catch (\Exception $e) {
            \Log::error('Checkout Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'There was an error processing your order: ' . $e->getMessage()]);
        }
    }

    public function success()
    {
        if (!session()->has('order_id')) {
            return redirect()->route('shop');
        }

        return view('checkout.success');
    }
}
