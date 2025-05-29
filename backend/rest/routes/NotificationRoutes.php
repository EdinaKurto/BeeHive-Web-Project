<?php
require_once __DIR__ . '/../services/NotificationService.php';

Flight::set('notification_service', new NotificationService());

Flight::group('/notification', function () {

    /**
     * @OA\Get(
     *     path="/notification",
     *     summary="Get all notifications (admin only)",
     *     tags={"Notification"},
     *     security={{"ApiKey":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of notifications",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="notification_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="is_read", type="boolean"),
     *             @OA\Property(property="created_at", type="string")
     *         ))
     *     )
     * )
     */
    Flight::route('GET /', function () {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
        $result = Flight::get('notification_service')->get_all_notifications();
        Flight::json($result);
    });

    /**
     * @OA\Post(
     *     path="/notification",
     *     summary="Create a notification (system/internal use)",
     *     tags={"Notification"},
     *     security={{"ApiKey":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "message"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="New order received.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Notification created",
     *         @OA\JsonContent(@OA\Property(property="notification_id", type="integer"))
     *     )
     * )
     */
    Flight::route('POST /', function () {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN); // restrict who can manually post
        $data = Flight::request()->data->getData();
        $id = Flight::get('notification_service')->create_notification($data);
        Flight::json(["message" => "Notification created", "notification_id" => $id]);
    });
});
