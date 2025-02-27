<?php

namespace App\Http\Controllers;

use App\Microservices\Historical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistorialController extends Controller
{
    public function client(Request $request)
    {
        $userLogin = Auth::guard('api')->user();
        $typeUser = Auth::guard('api')->user()->type_user;
        if (!$userLogin) {
            return response()->json(['status' => 401], 401);
        }

        if ($typeUser === 'seller') {
            return response()->json(['status' => 404, "msg" =>"Tu eres un cliente no pudes acceder al modulo de productos"], 404);
        }
        
        DB::beginTransaction();
        try {
            $historical = Historical::client($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200", "historical" => $historical]);
    }

    public function sellerByStore(Request $request)
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
            $historical = Historical::sellerByStore($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200", "historical" => $historical]);
    }
}
