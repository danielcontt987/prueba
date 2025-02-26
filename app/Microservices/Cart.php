<?php

namespace App\Microservices;

use App\Models\Cart as ModelsCart;
use App\Models\CartItem;
use App\Models\Product;

class Cart extends Microservice
{
    public static function addToCart($request)
    {
        $user_id = $request->input('user_id');
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = ModelsCart::firstOrCreate(['user_id' => $user_id]);

        $product = Product::findOrFail($product_id);

        $cartItem = CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $product->id],
            ['quantity' => $quantity]
        );

        $cartItems = CartItem::where('cart_id', $cart->id)->get();

        return $cartItems;
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

}
