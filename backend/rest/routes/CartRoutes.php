<?php
$authMiddleware = new AuthMiddleware();

Flight::route("GET /cart", function () use ($authMiddleware) {
    $headers = getallheaders();
    $token = str_replace("Bearer ", "", $headers["Authorization"] ?? "");
    $authMiddleware->verifyToken($token);

    $user = Flight::get("user");
    Flight::json(Flight::cartService()->get_items_by_user($user->id));
});

Flight::route("PUT /cart/update", function () use ($authMiddleware) {
    $headers = getallheaders();
    $token = str_replace("Bearer ", "", $headers["Authorization"] ?? "");
    $authMiddleware->verifyToken($token);

    $user = Flight::get("user");
    $data = Flight::request()->data->getData();

    if (!isset($data["product_id"], $data["quantity"])) {
        Flight::halt(400, "Missing product ID or quantity.");
    }

    Flight::cartService()->update_quantity($user->id, $data["product_id"], $data["quantity"]);
    Flight::json(["message" => "Quantity updated"]);
});

Flight::route("DELETE /cart/remove/@id", function ($product_id) use ($authMiddleware) {
    $headers = getallheaders();
    $token = str_replace("Bearer ", "", $headers["Authorization"] ?? "");
    $authMiddleware->verifyToken($token);

    $user = Flight::get("user");
    Flight::cartService()->remove_item($user->id, $product_id);
    Flight::json(["message" => "Item removed"]);
});

Flight::route("DELETE /cart/clear", function () use ($authMiddleware) {
    $headers = getallheaders();
    $token = str_replace("Bearer ", "", $headers["Authorization"] ?? "");
    $authMiddleware->verifyToken($token);

    $user = Flight::get("user");
    Flight::cartService()->clear($user->id);
    Flight::json(["message" => "Cart cleared"]);
});

Flight::route("GET /cart/summary", function () use ($authMiddleware) {
    $headers = getallheaders();
    $token = str_replace("Bearer ", "", $headers["Authorization"] ?? "");
    $authMiddleware->verifyToken($token);

    $user = Flight::get("user");
    $total = Flight::cartService()->get_total_price_by_user($user->id);
    Flight::json(["total_value" => $total]);
});
