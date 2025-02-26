<?php

namespace App\Microservices;

use App\Models\Cart as ModelsCart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Cart extends Microservice
{
    public static function addToCart($request)
    {
        $user_id = $request->input('user_id');
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $cart = ModelsCart::where('user_id', $user_id)->where('completed', 'Pendiente')->orderBy('id', 'desc')->first();
        if ($cart != null) {
            $product = Product::findOrFail($product_id);

            $cartItem = CartItem::updateOrCreate(
                ['cart_id' => $cart->id, 'product_id' => $product->id],
                ['quantity' => $quantity]
            );

            $cartItems = CartItem::where('cart_id', $cart->id)->get();

            return $cartItems;
        }
    }

    public static function revomeToCart($request)
    {
        $user_id = $request->input('user_id');
        $product_id = $request->input('product_id');

        $cart = ModelsCart::where('user_id', $user_id)->first();
        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $product_id)->first();

        $cartItem->delete();

        $cartItems = CartItem::where('cart_id', $cart->id)->get();

        return $cartItems;
    }

    public static function checkout($request) 
    {
        $user_id = $request->input('user_id');
        $cart_id = $request->input('cart_id');

        $cartItems = CartItem::with('product')->where('cart_id', $cart_id)->get();

        $total = 0;

        $order = Order::create([
            'user_id' => $user_id,
            'seller_id' => Auth::guard('api')->user()->id,
            'cart_id' => $cart_id,
        ]);

        foreach ($cartItems as $value) {
            $total += floatval($value->product->price) * $value->quantity;
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $value->product_id,
                'quantity' => $value->quantity,
                'price' => floatval($value->product->price),
                'total' => floatval($value->product->price) * $value->quantity,
            ]);

            $product = Product::where('id', $value->product_id)->first();

            if ($product->stock == 0 || $value->quantity > $product->stock) {
                return "No hay stock suficiente solo hay:" . " " . $product->stock . " " . "en existencia";
            }
           
            $product->stock -= $value->quantity;
            $product->save();
        }

        $cart = ModelsCart::find($cart_id);
        $cart->completed = 'Finalizado';
        $order->total = $total;
        $order->save();
    }

}
