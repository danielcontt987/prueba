<?php

namespace App\Microservices;

use App\Models\Product as ModelsProduct;
use Illuminate\Support\Facades\Auth;

class Product extends Microservice
{
    public static function get($request)
    {
        $id = $request->input('id');
        $product = ModelsProduct::where('id', $id)->first();
        return $product;
    }

    public static function list($request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if (!!$typeUser === 'client') {
            return response()->json(['status' => 404, "msg", "Tu eres un cliente no pudes acceder al modulo de productos"], 404);
        }

        $store_id = $request->input('store_id');
        $product = ModelsProduct::where('store_id', $store_id)->first();
        return $product;
    }

    public static function create($request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if (!!$typeUser === 'client') {
            return response()->json(['status' => 404, "msg", "Tu eres un cliente no pudes acceder al modulo de productos"], 404);
        }

        $name = $request->input('name');
        $store_id  = $request->input('store_id');
        $price = $request->input('price');
        $stock = $request->input('stock');

        $product = ModelsProduct::create([
            'store_id' => $store_id,
            'name' => $name,
            'price' => $price,
            'stock' => $stock,
        ]);

        return $product;
    }

    public static function delete($request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if (!!$typeUser === 'client') {
            return response()->json(['status' => 404, "msg", "Tu eres un cliente no pudes acceder al modulo de productos"], 404);
        }

        $id = $request->input('id');
        $product = ModelsProduct::where('id', $id)->first();
        $product->delete();
        return $product;
    }

    public static function update($request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if (!!$typeUser === 'client') {
            return response()->json(['status' => 404, "msg", "Tu eres un cliente no pudes acceder al modulo de productos"], 404);
        }

        $name = $request->input('name');
        $store_id  = $request->input('store_id');
        $price = $request->input('price');
        $stock = $request->input('stock');
        $id = $request->input('id');

        $product = ModelsProduct::where('id', $id)->first();
        $product->name = $name;
        $product->store_id = $store_id;
        $product->price = $price;
        $product->stock = $stock;
        $product->save();
        return $product;
    }
}
