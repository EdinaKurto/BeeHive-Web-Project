<?php

require_once __DIR__ . '/../services/CategoryService.php';


$categoriesService = new CategoryService();

/**
 * @OA\Get(
 *     path="/categories",
 *     summary="Get all categories",
 *     tags={"Categories"},
 *     @OA\Response(
 *         response=200,
 *         description="List of categories",
 *         @OA\JsonContent(type="array", @OA\Items(
 *             @OA\Property(property="category_id", type="integer"),
 *             @OA\Property(property="category_name", type="string")
 *         ))
 *     )
 * )
 */
Flight::route('GET /categories', function() use ($categoriesService){
    try {
        $categories = $categoriesService->getAllCategories();
        Flight::json($categories);
    } catch(Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Get(
 *     path="/categories/{id}",
 *     summary="Get category by ID",
 *     tags={"Categories"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category found",
 *         @OA\JsonContent(
 *             @OA\Property(property="category_id", type="integer"),
 *             @OA\Property(property="category_name", type="string")
 *         )
 *     )
 * )
 */
Flight::route('GET /categories/@id', function($id) use ($categoriesService){
    try {
        $category = $categoriesService->getCategoryById($id);
        Flight::json($category);
    } catch (Exception $e){
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Post(
 *     path="/categories",
 *     summary="Create a new category",
 *     tags={"Categories"},
 *     security={{"ApiKey":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"category_name"},
 *             @OA\Property(property="category_name", type="string", example="Honey")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Category created"
 *     )
 * )
 */
Flight::route('POST /categories', function() use ($categoriesService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $data = Flight::request()->data->getData();
        $id = $categoriesService->createCategory($data);
        Flight::json(["message" => "Category created", "category_id" => $id]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/categories/{id}",
 *     summary="Update a category",
 *     tags={"Categories"},
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
 *             @OA\Property(property="category_name", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category updated"
 *     )
 * )
 */
Flight::route('PUT /categories/@id', function($id) use ($categoriesService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $data = Flight::request()->data->getData();
        $categoriesService->updateCategory($id, $data);
        Flight::json(["message" => "Category updated"]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/categories/{id}",
 *     summary="Delete a category",
 *     tags={"Categories"},
 *     security={{"ApiKey":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category deleted"
 *     )
 * )
 */
Flight::route('DELETE /categories/@id', function($id) use ($categoriesService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $categoriesService->deleteCategory($id);
        Flight::json(["message" => "Category deleted"]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});
