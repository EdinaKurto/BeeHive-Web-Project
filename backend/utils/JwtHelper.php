<?php

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class JwtHelper {
    private static $secretKey = '12hdskj24'; 
    private static $algorithm = 'HS256';

    public static function generate($payload) {
        return JWT::encode($payload, self::$secretKey, self::$algorithm);
    }

    public static function decode($jwt) {
        return (array) JWT::decode($jwt, new Key(self::$secretKey, self::$algorithm));
    }
}
