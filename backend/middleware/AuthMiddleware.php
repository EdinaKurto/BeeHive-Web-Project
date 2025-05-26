<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    public function verifyToken($token = null) {
        $publicRoutes = [
            '/auth/login',
            '/auth/register'
        ];
        $currentRoute = $_SERVER['REQUEST_URI'];

        foreach ($publicRoutes as $public) {
            if (str_contains($currentRoute, $public)) {
                return;
            }
        }

        if (!$token) {
            Flight::halt(401, "Missing authentication header.");
        }

        try {
            $decoded = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
            if (!isset($decoded->user)) {
                Flight::halt(401, "Invalid token structure.");
            }

            Flight::set('user', (array) $decoded->user);
            Flight::set('jwt_token', $token);
        } catch (Exception $e) {
            Flight::halt(401, "Invalid or expired token: " . $e->getMessage());
        }
    }

    public function authorizeRole($requiredRole) {
        $user = Flight::get('user');
        if (!isset($user['role_id']) || $user['role_id'] != $requiredRole) {
            Flight::halt(403, "Access denied: You do not have the required role.");
        }
    }
    public function authorizeRoles($roles) {
        $user = Flight::get('user');
        if (!isset($user['role_id']) || !in_array($user['role_id'], $roles)) {
            Flight::halt(403, "Forbidden: Role not allowed.");
        }
    }
}