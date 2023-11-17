<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class TokenHelper
{
    public static function createToken($payload)
    {
        // $key = "tes"; // Ambil secret key dari konfigurasi Laravel
        $key =  "sipd2023";
        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    public static function decodeToken($token)
    {
        $key = "sipd2023"; // Ambil secret key dari konfigurasi Laravel
        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }
}
