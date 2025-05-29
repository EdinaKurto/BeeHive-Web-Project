<?php

/**
 * @OA\Tag(
 *     name="users",
 *     description="API for managing users"
 * )
 */

Flight::group('/users', function () {

    /**
     * @OA\Get(
     *     path="/users",
     *     tags={"users"},
     *     summary="Get all users (ADMIN only)",
     *     security={{"ApiKey":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of users"
     *     )
     * )
     */
    Flight::route('GET /', function () {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
        Flight::json(Flight::userService()->get_all());
    });

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     tags={"users"},
     *     summary="Get user by ID (ADMIN only)",
     *     security={{"ApiKey":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Single user"
     *     )
     * )
     */
    Flight::route('GET /@id', function ($id) {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
        Flight::json(Flight::userService()->get_by_id($id));
    });

    /**
     * @OA\Post(
     *     path="/users",
     *     tags={"users"},
     *     summary="Create user (ADMIN only)",
     *     security={{"ApiKey":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User created"
     *     )
     * )
     */
    Flight::route('POST /', function () {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
        $data = Flight::request()->data->getData();
        Flight::json(Flight::userService()->add($data));
    });

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     tags={"users"},
     *     summary="Update user (ADMIN only)",
     *     security={{"ApiKey":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated"
     *     )
     * )
     */
    Flight::route('PUT /@id', function ($id) {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
        $data = Flight::request()->data->getData();
        Flight::json(Flight::userService()->update($id, $data));
    });

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     tags={"users"},
     *     summary="Delete user (ADMIN only)",
     *     security={{"ApiKey":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted"
     *     )
     * )
     */
    Flight::route('DELETE /@id', function ($id) {
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
        Flight::json(["message" => "User deleted", "data" => Flight::userService()->delete($id)]);
    });

    Flight::route('GET /me', function () {
        $user = Flight::get('user');
        Flight::json($user);
    });
});