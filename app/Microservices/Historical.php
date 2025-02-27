<?php

namespace App\Microservices;

use App\Models\Cart as ModelsCart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Historical extends Microservice
{
    public static function client($request)
    {
        $user_id = $request->input('user_id');
        $historical = Order::with('historicals.product')->where('user_id', $user_id)->get();
        return $historical;
    }

    public static function sellerByStore($request) 
    {
        $store_id = $request->input('store_id');
        $seller_id = Auth::guard('api')->user()->id;

        $historical = Order::with('historicals.product.store')
        ->whereHas('historicals.product', function($product) use ($store_id, $seller_id){
            $product->where('store_id', $store_id)
            ->whereHas('store', function($seller) use ($store_id, $seller_id){
                $seller->where('user_id', $seller_id);
            });
        })->get();
        return $historical;
    }

}
