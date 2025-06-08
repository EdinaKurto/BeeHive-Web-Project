<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/config.php';

Flight::register('auth_middleware', 'AuthMiddleware');

// enable test mode
if (php_sapi_name() === 'cli') {
    define("UNIT_TESTING", true);
}

// JWT-based auth middleware before each route (except public ones)
Flight::before('start', function () {
    if (defined('UNIT_TESTING') && UNIT_TESTING) return;

    $headers = function_exists('apache_request_headers') ? apache_request_headers() : [];
    $token = null;

    $publicRoutes = [
        '/auth/login',
        '/auth/register'
    ];

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    foreach ($publicRoutes as $public) {
        if (str_ends_with($path, $public)) return;
    }

    if (isset($headers['Authorization']) && str_starts_with($headers['Authorization'], 'Bearer ')) {
        $token = str_replace('Bearer ', '', $headers['Authorization']);
    }

    Flight::auth_middleware()->verifyToken($token);
});


require_once __DIR__ . '/rest/routes/AuthRoutes.php';
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/BlogRoutes.php';
require_once __DIR__ . '/rest/routes/CartRoutes.php';
require_once __DIR__ . '/rest/routes/CategoriesRoutes.php';
require_once __DIR__ . '/rest/routes/ContactMessageRoutes.php';
require_once __DIR__ . '/rest/routes/NotificationRoutes.php';
require_once __DIR__ . '/rest/routes/OrderItemRoutes.php';
require_once __DIR__ . '/rest/routes/OrderRoutes.php';
require_once __DIR__ . '/rest/routes/PaymentRoutes.php';
require_once __DIR__ . '/rest/routes/ProductRoutes.php';

Flight::start();