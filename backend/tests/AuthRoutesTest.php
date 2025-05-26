<?php

use PHPUnit\Framework\TestCase;

class AuthRoutesTest extends TestCase
{
    public function setUp(): void
    {
        require_once __DIR__ . '/../vendor/autoload.php';
        require_once __DIR__ . '/../index.php';

        Flight::halt(false); // disable halting for clean test flow
    }

    public function testRegisterRouteExists(): void
    {
        $routes = Flight::routes();

        $this->assertTrue(
            $this->routeExists($routes, 'POST', '/auth/register'),
            'POST /auth/register route does not exist'
        );
    }

    public function testLoginRouteExists(): void
    {
        $routes = Flight::routes();

        $this->assertTrue(
            $this->routeExists($routes, 'POST', '/auth/login'),
            'POST /auth/login route does not exist'
        );
    }

    private function routeExists(array $routes, string $method, string $pattern): bool
    {
        foreach ($routes as $route) {
            if ($route['method'] === $method && $route['pattern'] === $pattern) {
                return true;
            }
        }
        return false;
    }
}
