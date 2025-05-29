<?php

require_once __DIR__ . '/../services/OrderItemService.php';
require_once __DIR__ . '/../../utils/MessageHandler.php';

Flight::set('order_item_service', new OrderItemService());

Flight::group('/order_item', function () {

    /**
     * @OA\Post(
     *     path="/order_item",
     *     summary="Add an item to an order",
     *     tags={"Order Item"},
     *     security={{"ApiKey": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"order_id", "product_id", "quantity"},
     *             @OA\Property(property="order_id", type="integer", example=1),
     *             @OA\Property(property="product_id", type="integer", example=2),
     *             @OA\Property(property="quantity", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item added to order",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Item added to order"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Invalid input data."))
     *     )
     * )
     */
    Flight::route('POST /', function () {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $data = Flight::request()->data->getData();
        $result = Flight::get('order_item_service')->add_item_to_order($data["order_id"], $data["product_id"], $data["quantity"]);
        MessageHandler::handleServiceResponse($result, "Item added to order");
    });

});
