<?php

namespace App\Http\Controllers;

use App\Microservices\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartClientController extends Controller
{
    public function addToCart (Request $request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if ($typeUser === 'seller') {
            return response()->json(['status' => 404, "msg" =>"Tu eres un cliente no pudes acceder este modulo"], 404);
        }

        DB::beginTransaction();
        try {
            $cart = Cart::addToCart($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200", "cart" => $cart]);
    }

    public function revomeToCart (Request $request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if ($typeUser === 'seller') {
            return response()->json(['status' => 404, "msg" =>"Tu eres un cliente no pudes acceder este modulo"], 404);
        }

        DB::beginTransaction();
        try {
            $cart = Cart::revomeToCart($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200", "cart" => $cart]);
    }

    public function checkout (Request $request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if ($typeUser === 'seller') {
            return response()->json(['status' => 404, "msg" =>"Tu eres un cliente no pudes acceder este modulo"], 404);
        }

        DB::beginTransaction();
        try {
            $cart = Cart::checkout($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200"]);
    }
}
