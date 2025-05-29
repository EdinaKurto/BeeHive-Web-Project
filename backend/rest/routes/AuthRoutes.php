<?php
error_log(" AuthRoutes.php loaded");

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../../utils/MessageHandler.php';

use Firebase\JWT\JWT;

Flight::set('auth_service', new AuthService());

Flight::group('/auth', function() {

    Flight::route('POST /login', function() {
        $payload = Flight::request()->data->getData();

        try {
            $auth = Flight::get('auth_service')->login($payload);
            if (!$auth['success']) {
                Flight::halt(401, $auth['error']);
            }

            unset($auth['success']); 
            Flight::json($auth);
        } catch (Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    });
    
    Flight::route('POST /register', function() {
        $data = Flight::request()->data->getData();

        try {
            $result = Flight::get('auth_service')->register($data);

            if (!$result['success']) {
                Flight::halt(400, $result['error']);
            }

            $user = $result['data'];

            $payload = [
                'user_id' => $user['user_id'],
                'email' => $user['email'],
                'role' => $user['role'] ?? 'user',
                'exp' => time() + 3600
            ];

            $token = JWT::encode($payload, Config::JWT_SECRET(), 'HS256');
            Flight::json(array_merge($user, ['token' => $token]));
        } catch (Exception $e) {
            Flight::halt(400, $e->getMessage());
        }
    });

});
