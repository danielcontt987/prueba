<?php

namespace App\Microservices;

use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Microservice
{
    public static function register($request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $type_user = $request->input('type_user');
        $password = $request->input('password');

        $user = ModelsUser::create([
            'name' => $name,
            'email' => $email,
            'type_user' => $type_user,
            'password' => Hash::make($password),
        ]);

        return $user;
    }


    public static function login($request)
    {
        $checkUser = ModelsUser::where('email', '=',$request['email'])->first();
        if (isset($checkUser)) {
            $psw = $request['password'];
            if (Hash::check($psw, $checkUser['password'])) {
                $response['token'] = $checkUser->createToken('users')->accessToken;
                $response['user'] = $checkUser;
                $response['msg'] = 'Inicio de sesion exitoso';
                $response['status'] = 200;
                return $response;
            }
            else{
                $response['msg'] = 'Verifica bien tus credenciales';
                $response['status'] = 401;
                return $response;
            }
        }
    }

    public static function logout($request)
    {
        $userSession = Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });
    }
}
