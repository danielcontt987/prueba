<?php

namespace App\Http\Controllers;

use App\Microservices\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
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
            $store = Store::get($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200", "store" => $store]);
    }

    public function list()
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
            $stores = Store::list();
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
            $store = Store::create($request);
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
            $store = Store::delete($request);
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
            $store = Store::update($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200", "store" => $store]);
    }
}
