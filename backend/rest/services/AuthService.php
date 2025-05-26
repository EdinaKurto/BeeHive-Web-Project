<?php

require_once 'BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService {
    private $auth_dao;

    public function __construct() {
        $this->auth_dao = new AuthDao();
        parent::__construct($this->auth_dao);
    }

    public function register($entity): array {
        if (empty($entity['email']) || empty($entity['password']) || empty($entity['full_name'])) {
            return ['success' => false, 'error' => 'Full name, email, and password are required.'];
        }

        if (!isset($entity['confirm_password']) || $entity['password'] !== $entity['confirm_password']) {
            return ['success' => false, 'error' => 'Passwords do not match.'];
        }

        $existing = $this->auth_dao->get_user_by_email($entity['email']);
        if ($existing) {
            return ['success' => false, 'error' => 'Email already registered.'];
        }

        $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);
        $entity['role_id'] = $entity['role_id'] ?? 2;

        $user = $this->auth_dao->add([
            "full_name" => $entity['full_name'],
            "email" => $entity['email'],
            "password" => $entity['password'],
            "role_id" => $entity['role_id']
        ]);

        unset($user['password']);

        return ['success' => true, 'data' => $user];
    }

    public function login($entity): array {
    if (empty($entity['email']) || empty($entity['password'])) {
        return ['success' => false, 'error' => 'Email and password are required.'];
    }

    $user = $this->auth_dao->get_user_by_email($entity['email']);
    if (!$user || !password_verify($entity['password'], $user['password'])) {
        return ['success' => false, 'error' => 'Invalid email or password.'];
    }

    unset($user['password']);

    $payload = [
        "user" => $user,
        "iat" => time(),
        "exp" => time() + (60 * 60 * 24)
    ];

    $jwt = JWT::encode($payload, Config::JWT_SECRET(), 'HS256');

    return [
        'success' => true,
        'token' => $jwt,
        'role_id' => $user['role_id'],
        'email' => $user['email'],
        'full_name' => $user['full_name']
    ];
}
}
