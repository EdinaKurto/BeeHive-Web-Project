<?php

require_once __DIR__ . '/../services/ContactMessageService.php';


Flight::set('contact_message_service', new ContactMessageService());

/**
 * @OA\Post(
 *     path="/contact",
 *     summary="Submit a contact message",
 *     tags={"Contact"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "phone_number", "subject", "message"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="phone_number", type="string", example="+387 61 222 333"),
 *             @OA\Property(property="subject", type="string", example="Order issue"),
 *             @OA\Property(property="message", type="string", example="Where is my order?")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Message submitted",
 *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Message sent successfully"))
 *     )
 * )
 */
Flight::route('POST /contact', function () {
    $data = Flight::request()->data->getData();
    $result = Flight::get('contact_message_service')->submitMessage($data);
    Flight::json(["message" => "Message sent successfully", "id" => $result]);
});

/**
 * @OA\Get(
 *     path="/contact",
 *     summary="Get all contact messages (admin only)",
 *     tags={"Contact"},
 *     security={{"ApiKey":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of messages",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="contact_id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="phone_number", type="string"),
 *             @OA\Property(property="subject", type="string"),
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="submitted_at", type="string")
 *         ))
 *     )
 * )
 */
Flight::route('GET /contact', function () {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $messages = Flight::get('contact_message_service')->getAllMessages();
    Flight::json($messages);
});
