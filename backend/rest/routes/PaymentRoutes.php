<?php

require_once __DIR__ . '/../services/PaymentService.php';
require_once __DIR__ . '/../../utils/MessageHandler.php';

Flight::set('payment_service', new PaymentService());

Flight::group('/payment', function () {

    /**
     * @OA\Post(
     *     path="/payment/add",
     *     summary="Add a payment for the authenticated user",
     *     tags={"Payment"},
     *     security={{"ApiKey": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount"},
     *             @OA\Property(property="amount", type="number", example=59.99),
     *             @OA\Property(property="payment_date", type="string", format="date-time", example="2025-05-25 15:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment recorded successfully",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Payment added"))
     *     )
     * )
     */
    Flight::route('POST /add', function () {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $user_id = Flight::get('user')->id;
        $data = Flight::request()->data->getData();
        $result = Flight::get('payment_service')->add_payment($user_id, $data);
        MessageHandler::handleServiceResponse($result, 'Payment added');
    });

    /**
     * @OA\Get(
     *     path="/payment/all",
     *     summary="Get all payments (admin only)",
     *     tags={"Payment"},
     *     security={{"ApiKey": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of all payments",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="payment_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="amount", type="number"),
     *             @OA\Property(property="payment_date", type="string")
     *         ))
     *     )
     * )
     */
    Flight::route('GET /all', function () {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
        $result = Flight::get('payment_service')->get_all_payments();
        MessageHandler::handleServiceResponse($result);
    });

    /**
     * @OA\Get(
     *     path="/payment/mine",
     *     summary="Get payments for the authenticated user",
     *     tags={"Payment"},
     *     security={{"ApiKey": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of your payments",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="payment_id", type="integer"),
     *             @OA\Property(property="amount", type="number"),
     *             @OA\Property(property="payment_date", type="string")
     *         ))
     *     )
     * )
     */
    Flight::route('GET /mine', function () {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $user_id = Flight::get('user')->id;
        $result = Flight::get('payment_service')->get_payments_by_user($user_id);
        MessageHandler::handleServiceResponse($result);
    });

});
