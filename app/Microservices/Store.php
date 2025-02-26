<?php

namespace App\Microservices;

use App\Models\Store as ModelsStore;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class Store extends Microservice
{
    public static function get($request)
    {
        $id = $request->input('id');
        $store = ModelsStore::where('id', $id)->first();
        return $store;
    }

    public static function list()
    {
        $user_id = Auth::guard('api')->user()->id;
        $store = ModelsStore::where('user_id', $user_id)->first();
        return $store;
    }

    public static function create($request)
    {
        $name = $request->input('name');
        $store = ModelsStore::create([
            'user_id' => Auth::guard('api')->user()->id,
            'name' => $name,
        ]);

        return $store;
    }

    public static function delete($request)
    {
        $id = $request->input('id');
        $store = ModelsStore::where('id', $id)->first();
        $store->delete();
        return $store;
    }

    public static function update($request)
    {
        $name = $request->input('name');
        $id = $request->input('id');
        $store = ModelsStore::where('id', $id)->first();
        $store->name = $name;
        $store->save();
        return $store;
    }
}
