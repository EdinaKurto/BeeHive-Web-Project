<?php
require_once __DIR__ . '/../services/OrderService.php';


Flight::set('order_service', new OrderService());
Flight::group('/order', function () {

    /**
     * @OA\Get(
     *     path="/order/user",
     *     summary="Get orders for the authenticated user",
     *     tags={"Order"},
     *     security={{"ApiKey":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User orders",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Order"))
     *     )
     * )
     */
    Flight::route('GET /user', function () {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $user_id = Flight::get('user')->id;
        $orders = Flight::get('order_service')->get_orders_by_user($user_id);
        Flight::json($orders);
    });

    /**
     * @OA\Post(
     *     path="/order/add",
     *     summary="Create new order from user cart",
     *     tags={"Order"},
     *     security={{"ApiKey":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"address", "city", "country", "phone_number"},
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="country", type="string"),
     *             @OA\Property(property="phone_number", type="string"),
     *             @OA\Property(property="notes", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order created",
     *         @OA\JsonContent(@OA\Property(property="order_id", type="integer"))
     *     )
     * )
     */
    Flight::route('POST /add', function () {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $user_id = Flight::get('user')->id;
        $data = Flight::request()->data->getData();
        $order_id = Flight::get('order_service')->add_order($user_id, $data);
        Flight::json(['message' => 'Order created successfully', 'order_id' => $order_id]);
    });

    /**
     * @OA\Put(
     *     path="/order/status",
     *     summary="Admin updates order status",
     *     tags={"Order"},
     *     security={{"ApiKey":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"order_id", "new_status_id"},
     *             @OA\Property(property="order_id", type="integer"),
     *             @OA\Property(property="new_status_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Status updated"
     *     )
     * )
     */
    Flight::route('PUT /status', function () {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
        $data = Flight::request()->data->getData();
        Flight::get('order_service')->update_order_status($data["order_id"], $data["new_status_id"]);
        Flight::json(["message" => "Order status updated"]);
    });

    /**
     * @OA\Delete(
     *     path="/order/@order_id",
     *     summary="Admin deletes an order",
     *     tags={"Order"},
     *     security={{"ApiKey":{}}},
     *     @OA\Parameter(
     *         name="order_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order deleted"
     *     )
     * )
     */
    Flight::route('DELETE /@order_id', function ($order_id) {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
        Flight::get('order_service')->delete_order($order_id);
        Flight::json(["message" => "Order deleted"]);
    });

});
