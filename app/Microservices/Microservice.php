<?php
namespace App\Microservices;

class Microservice
{
    /**
     * @param $data
     * @param $response
     * @return array
     */
    public static function responseFormat($data, $response)
    {
        if (!empty($data)) {
            $data  = json_decode(json_encode($data));
        }

        $response = ['request' => $data, 'response' => $response];
        return $response;
    }

    /**
     * @param $single
     * @return array
     */
    public static function checkIfExist($single)
    {
        if (!empty($single)) {
            $single = $single->toArray();
        } else {
            $single = [];
        }
        return $single;
    }
}