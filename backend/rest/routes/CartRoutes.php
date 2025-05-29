<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/../services/CartService.php';
require_once __DIR__ . '/../../utils/MessageHandler.php';

Flight::set('cart_service', new CartService());

Flight::group('/cart', function () {
    
    Flight::route('GET /', function () {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $user_id = Flight::get('user')->id;

        $search = Flight::query('search', '');
        $sort_by = Flight::query('sort_by', 'name');
        $sort_order = Flight::query('sort_order', 'asc');

        $response = Flight::get('cart_service')->get_filtered_cart($user_id, $search, $sort_by, $sort_order);
        MessageHandler::handleServiceResponse($response);
    });

    Flight::route('GET /summary', function () {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $user_id = Flight::get('user')->id;

        $summary = Flight::get('cart_service')->get_cart_summary_by_user($user_id);
        MessageHandler::handleServiceResponse($summary);
    });

    Flight::route('POST /add', function () {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $user_id = Flight::get('user')->id;
        $data = Flight::request()->data->getData();

        $result = Flight::get('cart_service')->add_to_cart($user_id, $data['product_id'] ?? null);
        MessageHandler::handleServiceResponse($result, 'Item added to cart');
    });

    Flight::route('PUT /update', function () {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $user_id = Flight::get('user')->id;
        $data = Flight::request()->data->getData();

        $result = Flight::get('cart_service')->update_quantity(
            $user_id,
            $data['product_id'] ?? null,
            $data['quantity'] ?? null
        );
        MessageHandler::handleServiceResponse($result, 'Cart updated');
    });

    Flight::route('DELETE /remove/@product_id', function ($product_id) {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $user_id = Flight::get('user')->id;

        $result = Flight::get('cart_service')->remove_from_cart($user_id, $product_id);
        MessageHandler::handleServiceResponse($result, 'Item removed from cart');
    });

    Flight::route('DELETE /clear', function () {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $user_id = Flight::get('user')->id;

        $result = Flight::get('cart_service')->clear_cart($user_id);
        MessageHandler::handleServiceResponse($result, 'Cart cleared');
    });
});
