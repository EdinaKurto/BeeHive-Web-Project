<?php
require_once __DIR__ . '/../services/BlogService.php';
require_once __DIR__ . '/../../utils/MessageHandler.php';

Flight::set('blog_service', new BlogService());

Flight::group('/blogs', function () {

    /**
     * @OA\Get(
     *     path="/blogs",
     *     summary="Get all blogs",
     *     tags={"Blogs"},
     *     @OA\Response(
     *         response=200,
     *         description="List of blogs"
     *     )
     * )
     */
    Flight::route("GET /", function () {
        $data = Flight::get('blog_service')->get_all();
        Flight::json($data);
    });

    /**
     * @OA\Get(
     *     path="/blogs/{id}",
     *     summary="Get a blog by ID",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Blog found")
     * )
     */
    Flight::route("GET /@id", function ($id) {
        $blog = Flight::get('blog_service')->get_by_id($id);
        Flight::json($blog);
    });

    /**
     * @OA\Post(
     *     path="/blogs",
     *     summary="Create a new blog",
     *     tags={"Blogs"},
     *     security={{"ApiKey": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title", "content", "image"},
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="content", type="string"),
     *                 @OA\Property(property="image", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Blog created")
     * )
     */
    Flight::route("POST /", function () {
        Flight::auth_middleware()->authorizeRoles([Roles::ADMIN]);

        $file = $_FILES['image'];
        $filename = uniqid() . "_" . basename($file['name']);
        $targetPath = __DIR__ . "/../../frontend/img/blogs/" . $filename;
        move_uploaded_file($file["tmp_name"], $targetPath);

        $data = Flight::request()->data->getData();
        $data['image_url'] = "frontend/img/blogs/" . $filename;
        $data['published_at'] = date("Y-m-d H:i:s");

        $response = Flight::get('blog_service')->create($data);
        Flight::json(['message' => 'Blog created', 'data' => $response]);
    });

    /**
     * @OA\Put(
     *     path="/blogs/{id}",
     *     summary="Update a blog",
     *     tags={"Blogs"},
     *     security={{"ApiKey": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Blog updated")
     * )
     */
    Flight::route("PUT /@id", function ($id) {
        Flight::auth_middleware()->authorizeRoles([Roles::ADMIN]);
        $data = Flight::request()->data->getData();
        $result = Flight::get('blog_service')->update($id, $data);
        Flight::json(["message" => "Blog updated", "data" => $result]);
    });

    /**
     * @OA\Delete(
     *     path="/blogs/{id}",
     *     summary="Delete a blog",
     *     tags={"Blogs"},
     *     security={{"ApiKey": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Blog deleted")
     * )
     */
    Flight::route("DELETE /@id", function ($id) {
        Flight::auth_middleware()->authorizeRoles([Roles::ADMIN]);
        Flight::get('blog_service')->delete($id);
        Flight::json(["message" => "Blog deleted"]);
    });

    /**
     * @OA\Post(
     *     path="/blogs/{id}/comments",
     *     summary="Post a comment on a blog",
     *     tags={"Blogs"},
     *     security={{"ApiKey": {}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"comment"},
     *             @OA\Property(property="comment", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Comment posted")
     * )
     */
    Flight::route("POST /@id/comments", function ($id) {
        Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
        $user_id = Flight::get('user')->id;
        $body = Flight::request()->data->getData();
        $comment = [
            'blog_id' => $id,
            'user_id' => $user_id,
            'comment' => $body['comment'],
            'created_at' => date("Y-m-d H:i:s")
        ];
        $res = Flight::get('blog_service')->add_comment($comment);
        Flight::json(['message' => 'Comment added', 'data' => $res]);
    });

    /**
     * @OA\Get(
     *     path="/blogs/{id}/comments",
     *     summary="Get comments for a blog",
     *     tags={"Blogs"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="List of comments")
     * )
     */
    Flight::route("GET /@id/comments", function ($id) {
        $comments = Flight::get('blog_service')->get_comments_for_blog($id);
        Flight::json($comments);
    });
});
