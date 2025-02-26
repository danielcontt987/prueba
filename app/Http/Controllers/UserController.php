<?php

namespace App\Http\Controllers;

use App\Microservices\User;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request) 
    {
        $input = $request->all();
        $validator = Validator::make($input,[           
            'email' => 'required|email',
            'password' => 'required',
            'type_user' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422, 
                'msg' => 'Bad request',
                "errors"=>$validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $user = User::register($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }

        DB::commit();
        return response()->json(["status" => "200", "user" => $user]);
    }

    public function login(Request $request) 
    {
        $input = $request->all();
        $validator = Validator::make($input,[           
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422, 
                'msg' => 'Bad request',
                "errors"=>$validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $user = User::login($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
        DB::commit();
        return response()->json(["status" => "200", "user" => $user]);
    }

    public function logout()
    {
        try {
            Auth::user()->tokens->each(function ($token) {
                $token->delete();
            });
            return response()->json(['message' => 'Logout exitoso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }
}
