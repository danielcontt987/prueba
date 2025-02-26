<?php

namespace App\Http\Controllers;

use App\Microservices\Product;
use App\Microservices\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function get(Request $request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if ($typeUser === 'client') {
            return response()->json(['status' => 404, "msg" =>"Tu eres un cliente no pudes acceder al modulo de productos"], 404);
        }

        DB::beginTransaction();
        try {
            $store = Product::get($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200", "store" => $store]);
    }

    public function list(Request $request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if ($typeUser === 'client') {
            return response()->json(['status' => 404, "msg" =>"Tu eres un cliente no pudes acceder al modulo de productos"], 404);
        }

        DB::beginTransaction();
        try {
            $stores = Product::list($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200", "stores" => $stores]);
    }

    public function create(Request $request) 
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if ($typeUser === 'client') {
            return response()->json(['status' => 404, "msg" =>"Tu eres un cliente no pudes acceder al modulo de productos"], 404);
        }

        DB::beginTransaction();
        try {
            $store = Product::create($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200", "store" => $store]);
       
    }

    public function delete(Request $request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if ($typeUser === 'client') {
            return response()->json(['status' => 404, "msg" =>"Tu eres un cliente no pudes acceder al modulo de productos"], 404);
        }

        DB::beginTransaction();
        try {
            $store = Product::delete($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200"]);
    }

    public function update(Request $request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if ($typeUser === 'client') {
            return response()->json(['status' => 404, "msg" =>"Tu eres un cliente no pudes acceder al modulo de productos"], 404);
        }
        
        DB::beginTransaction();
        try {
            $store = Product::update($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200", "store" => $store]);
    }
}
