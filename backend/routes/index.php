<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/routes/index.php';
require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../services/ProductService.php';
require_once __DIR__ . '/../services/OrderService.php';
require_once __DIR__ . '/../services/CategoryService.php';
require_once __DIR__ . '/../services/BlogService.php';
require_once __DIR__ . '/../services/BlogCommentService.php';
require_once __DIR__ . '/../services/ContactMessageService.php';
require_once __DIR__ . '/../services/NotificationService.php';
require_once __DIR__ . '/../services/PaymentService.php';
require_once __DIR__ . '/../services/CartService.php';
require_once __DIR__ . '/../services/OrderItemService.php';
require_once __DIR__ . '/../services/OrderStatusService.php';
require_once __DIR__ . '/../services/RoleService.php';



/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Get all users",
 *     @OA\Response(
 *         response=200,
 *         description="List of all users"
 *     )
 * )
 */
Flight::route('GET /users', function() {
    Flight::json(Flight::userService()->getAllUsers());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Get a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="User ID"
 *     ),
 *     @OA\Response(response=200, description="User details")
 * )
 */
Flight::route('GET /users/@id', function($id) {
    Flight::json(Flight::userService()->getUser($id));
});

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"users"},
 *     summary="Create a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="securepassword123"),
 *             @OA\Property(property="name", type="string", example="John Doe")
 *         )
 *     ),
 *     @OA\Response(response=200, description="User created")
 * )
 */
Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::userService()->createUser($data)]);
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Update a user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="User ID"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", example="updated@example.com"),
 *             @OA\Property(property="password", type="string", example="newpassword"),
 *             @OA\Property(property="name", type="string", example="Updated Name")
 *         )
 *     ),
 *     @OA\Response(response=200, description="User updated")
 * )
 */
Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::userService()->updateUser($id, $data)]);
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Delete a user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="User ID"
 *     ),
 *     @OA\Response(response=200, description="User deleted")
 * )
 */
Flight::route('DELETE /users/@id', function($id) {
    Flight::json(['deleted' => Flight::userService()->deleteUser($id)]);
});














/**
 * @OA\Get(
 *      path="/products",
 *      tags={"products"},
 *      summary="Get all products",
 *      @OA\Response(
 *           response=200,
 *           description="List of all bee products"
 *      )
 * )
 */
Flight::route('GET /products', function() {
    Flight::json(Flight::productService()->getAllProducts());
});

/**
 * @OA\Get(
 *     path="/products/{id}",
 *     tags={"products"},
 *     summary="Get a product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Product details")
 * )
 */
Flight::route('GET /products/@id', function($id) {
    Flight::json(Flight::productService()->getProduct($id));
});

/**
 * @OA\Post(
 *     path="/products",
 *     tags={"products"},
 *     summary="Create a new bee product",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "price"},
 *             @OA\Property(property="name", type="string", example="Wildflower Honey"),
 *             @OA\Property(property="price", type="number", format="float", example=19.99),
 *             @OA\Property(property="description", type="string", example="Raw wildflower honey collected in Sarajevo")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Product created")
 * )
 */
Flight::route('POST /products', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::productService()->createProduct($data)]);
});

/**
 * @OA\Put(
 *     path="/products/{id}",
 *     tags={"products"},
 *     summary="Update a product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Product ID"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "price"},
 *             @OA\Property(property="name", type="string", example="New Name"),
 *             @OA\Property(property="price", type="number", format="float", example=21.99),
 *             @OA\Property(property="description", type="string", example="Updated description")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Product updated")
 * )
 */
Flight::route('PUT /products/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::productService()->updateProduct($id, $data)]);
});

/**
 * @OA\Patch(
 *     path="/products/{id}",
 *     tags={"products"},
 *     summary="Partially update a product",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Product ID"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Only name changed"),
 *             @OA\Property(property="price", type="number", example=18.49)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Product partially updated")
 * )
 */
Flight::route('PATCH /products/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::productService()->updateProduct($id, $data)]);
});

/**
 * @OA\Delete(
 *     path="/products/{id}",
 *     tags={"products"},
 *     summary="Delete a product",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Product ID"
 *     ),
 *     @OA\Response(response=200, description="Product deleted")
 * )
 */
Flight::route('DELETE /products/@id', function($id) {
    Flight::json(['deleted' => Flight::productService()->deleteProduct($id)]);
});













/**
 * @OA\Get(
 *     path="/orders",
 *     tags={"orders"},
 *     summary="Get all orders",
 *     @OA\Response(
 *         response=200,
 *         description="List of all orders"
 *     )
 * )
 */
Flight::route('GET /orders', function() {
    Flight::json(Flight::orderService()->getAllOrders());
});

/**
 * @OA\Get(
 *     path="/orders/{id}",
 *     tags={"orders"},
 *     summary="Get an order by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Order ID"
 *     ),
 *     @OA\Response(response=200, description="Order details")
 * )
 */
Flight::route('GET /orders/@id', function($id) {
    Flight::json(Flight::orderService()->getOrder($id));
});

/**
 * @OA\Post(
 *     path="/orders",
 *     tags={"orders"},
 *     summary="Create a new order",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "status"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="status", type="string", example="pending"),
 *             @OA\Property(property="total", type="number", example=49.99)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order created")
 * )
 */
Flight::route('POST /orders', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::orderService()->createOrder($data)]);
});

/**
 * @OA\Put(
 *     path="/orders/{id}",
 *     tags={"orders"},
 *     summary="Update an order",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Order ID"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="completed"),
 *             @OA\Property(property="total", type="number", example=59.99)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order updated")
 * )
 */
Flight::route('PUT /orders/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::orderService()->updateOrder($id, $data)]);
});

/**
 * @OA\Delete(
 *     path="/orders/{id}",
 *     tags={"orders"},
 *     summary="Delete an order",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Order ID"
 *     ),
 *     @OA\Response(response=200, description="Order deleted")
 * )
 */
Flight::route('DELETE /orders/@id', function($id) {
    Flight::json(['deleted' => Flight::orderService()->deleteOrder($id)]);
});













/**
 * @OA\Get(
 *     path="/categories",
 *     tags={"categories"},
 *     summary="Get all categories",
 *     @OA\Response(
 *         response=200,
 *         description="List of all product categories"
 *     )
 * )
 */
Flight::route('GET /categories', function() {
    Flight::json(Flight::categoryService()->getAllCategories());
});












/**
 * @OA\Get(
 *     path="/blogs",
 *     tags={"blogs"},
 *     summary="Get all blog posts",
 *     @OA\Response(
 *         response=200,
 *         description="List of all blog posts"
 *     )
 * )
 */
Flight::route('GET /blogs', function() {
    Flight::json(Flight::blogService()->getAllBlogs());
});

/**
 * @OA\Get(
 *     path="/blogs/{id}",
 *     tags={"blogs"},
 *     summary="Get a blog post by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Blog ID"
 *     ),
 *     @OA\Response(response=200, description="Blog post details")
 * )
 */
Flight::route('GET /blogs/@id', function($id) {
    Flight::json(Flight::blogService()->getBlog($id));
});

/**
 * @OA\Post(
 *     path="/blogs",
 *     tags={"blogs"},
 *     summary="Create a new blog post",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "content"},
 *             @OA\Property(property="title", type="string", example="Bee Health Tips"),
 *             @OA\Property(property="content", type="string", example="Keep your bees warm during winter by..."),
 *             @OA\Property(property="author", type="string", example="Dery")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Blog post created")
 * )
 */
Flight::route('POST /blogs', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::blogService()->createBlog($data)]);
});

/**
 * @OA\Put(
 *     path="/blogs/{id}",
 *     tags={"blogs"},
 *     summary="Update a blog post",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Blog ID"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Updated Title"),
 *             @OA\Property(property="content", type="string", example="Updated blog content"),
 *             @OA\Property(property="author", type="string", example="Dery")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Blog post updated")
 * )
 */
Flight::route('PUT /blogs/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::blogService()->updateBlog($id, $data)]);
});

/**
 * @OA\Delete(
 *     path="/blogs/{id}",
 *     tags={"blogs"},
 *     summary="Delete a blog post",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Blog ID"
 *     ),
 *     @OA\Response(response=200, description="Blog post deleted")
 * )
 */
Flight::route('DELETE /blogs/@id', function($id) {
    Flight::json(['deleted' => Flight::blogService()->deleteBlog($id)]);
});














/**
 * @OA\Get(
 *     path="/comments",
 *     tags={"comments"},
 *     summary="Get all blog comments",
 *     @OA\Response(
 *         response=200,
 *         description="List of all blog comments"
 *     )
 * )
 */
Flight::route('GET /comments', function() {
    Flight::json(Flight::blogCommentService()->getAll());
});

/**
 * @OA\Get(
 *     path="/comments/{id}",
 *     tags={"comments"},
 *     summary="Get a blog comment by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Comment ID"
 *     ),
 *     @OA\Response(response=200, description="Comment details")
 * )
 */
Flight::route('GET /comments/@id', function($id) {
    Flight::json(Flight::blogCommentService()->get($id));
});

/**
 * @OA\Post(
 *     path="/comments",
 *     tags={"comments"},
 *     summary="Create a new comment on a blog post",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"blog_id", "author", "content"},
 *             @OA\Property(property="blog_id", type="integer", example=5),
 *             @OA\Property(property="author", type="string", example="Jane"),
 *             @OA\Property(property="content", type="string", example="This was a very informative post!")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Comment created")
 * )
 */
Flight::route('POST /comments', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::blogCommentService()->insert($data)]);
});

/**
 * @OA\Put(
 *     path="/comments/{id}",
 *     tags={"comments"},
 *     summary="Update a comment",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Comment ID"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="content", type="string", example="Edited comment content")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Comment updated")
 * )
 */
Flight::route('PUT /comments/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::blogCommentService()->update($id, $data)]);
});

/**
 * @OA\Delete(
 *     path="/comments/{id}",
 *     tags={"comments"},
 *     summary="Delete a comment",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Comment ID"
 *     ),
 *     @OA\Response(response=200, description="Comment deleted")
 * )
 */
Flight::route('DELETE /comments/@id', function($id) {
    Flight::json(['deleted' => Flight::blogCommentService()->delete($id)]);
});



















/**
 * @OA\Get(
 *     path="/messages",
 *     tags={"messages"},
 *     summary="Get all contact messages",
 *     @OA\Response(
 *         response=200,
 *         description="List of all contact messages"
 *     )
 * )
 */
Flight::route('GET /messages', function() {
    Flight::json(Flight::contactService()->getAll());
});

/**
 * @OA\Get(
 *     path="/messages/{id}",
 *     tags={"messages"},
 *     summary="Get a contact message by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Message ID"
 *     ),
 *     @OA\Response(response=200, description="Message details")
 * )
 */
Flight::route('GET /messages/@id', function($id) {
    Flight::json(Flight::contactService()->get($id));
});

/**
 * @OA\Post(
 *     path="/messages",
 *     tags={"messages"},
 *     summary="Submit a new contact message",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "message"},
 *             @OA\Property(property="name", type="string", example="John"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="message", type="string", example="Hello, I have a question about your honey.")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Message submitted")
 * )
 */
Flight::route('POST /messages', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::contactService()->insert($data)]);
});

/**
 * @OA\Delete(
 *     path="/messages/{id}",
 *     tags={"messages"},
 *     summary="Delete a contact message",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Message ID"
 *     ),
 *     @OA\Response(response=200, description="Message deleted")
 * )
 */
Flight::route('DELETE /messages/@id', function($id) {
    Flight::json(['deleted' => Flight::contactService()->delete($id)]);
});





















/**
 * @OA\Get(
 *     path="/notifications",
 *     tags={"notifications"},
 *     summary="Get all notifications",
 *     @OA\Response(
 *         response=200,
 *         description="List of all notifications"
 *     )
 * )
 */
Flight::route('GET /notifications', function() {
    Flight::json(Flight::notificationService()->getAll());
});

/**
 * @OA\Get(
 *     path="/notifications/{id}",
 *     tags={"notifications"},
 *     summary="Get a notification by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Notification ID"
 *     ),
 *     @OA\Response(response=200, description="Notification details")
 * )
 */
Flight::route('GET /notifications/@id', function($id) {
    Flight::json(Flight::notificationService()->get($id));
});

/**
 * @OA\Post(
 *     path="/notifications",
 *     tags={"notifications"},
 *     summary="Create a new notification",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "message"},
 *             @OA\Property(property="user_id", type="integer", example=2),
 *             @OA\Property(property="message", type="string", example="Your order has shipped!")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Notification created")
 * )
 */
Flight::route('POST /notifications', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::notificationService()->insert($data)]);
});

/**
 * @OA\Put(
 *     path="/notifications/{id}/read",
 *     tags={"notifications"},
 *     summary="Mark a notification as read",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Notification ID"
 *     ),
 *     @OA\Response(response=200, description="Notification marked as read")
 * )
 */
Flight::route('PUT /notifications/@id/read', function($id) {
    Flight::json(['updated' => Flight::notificationService()->markAsRead($id)]);
});

/**
 * @OA\Delete(
 *     path="/notifications/{id}",
 *     tags={"notifications"},
 *     summary="Delete a notification",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Notification ID"
 *     ),
 *     @OA\Response(response=200, description="Notification deleted")
 * )
 */
Flight::route('DELETE /notifications/@id', function($id) {
    Flight::json(['deleted' => Flight::notificationService()->delete($id)]);
});

















/**
 * @OA\Get(
 *     path="/payments",
 *     tags={"payments"},
 *     summary="Get all payments",
 *     @OA\Response(
 *         response=200,
 *         description="List of all payments"
 *     )
 * )
 */
Flight::route('GET /payments', function() {
    Flight::json(Flight::paymentService()->getAll());
});

/**
 * @OA\Get(
 *     path="/payments/{id}",
 *     tags={"payments"},
 *     summary="Get a payment by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Payment ID"
 *     ),
 *     @OA\Response(response=200, description="Payment details")
 * )
 */
Flight::route('GET /payments/@id', function($id) {
    Flight::json(Flight::paymentService()->get($id));
});

/**
 * @OA\Post(
 *     path="/payments",
 *     tags={"payments"},
 *     summary="Create a new payment",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"order_id", "amount", "method"},
 *             @OA\Property(property="order_id", type="integer", example=3),
 *             @OA\Property(property="amount", type="number", format="float", example=79.99),
 *             @OA\Property(property="method", type="string", example="Credit Card")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Payment created")
 * )
 */
Flight::route('POST /payments', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::paymentService()->insert($data)]);
});

/**
 * @OA\Delete(
 *     path="/payments/{id}",
 *     tags={"payments"},
 *     summary="Delete a payment",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Payment ID"
 *     ),
 *     @OA\Response(response=200, description="Payment deleted")
 * )
 */
Flight::route('DELETE /payments/@id', function($id) {
    Flight::json(['deleted' => Flight::paymentService()->delete($id)]);
});
















/**
 * @OA\Get(
 *     path="/cart",
 *     tags={"cart"},
 *     summary="Get all cart items",
 *     @OA\Response(
 *         response=200,
 *         description="List of all cart items"
 *     )
 * )
 */
Flight::route('GET /cart', function() {
    Flight::json(Flight::cartService()->getAll());
});

/**
 * @OA\Get(
 *     path="/cart/{id}",
 *     tags={"cart"},
 *     summary="Get a cart item by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Cart item ID"
 *     ),
 *     @OA\Response(response=200, description="Cart item details")
 * )
 */
Flight::route('GET /cart/@id', function($id) {
    Flight::json(Flight::cartService()->get($id));
});

/**
 * @OA\Post(
 *     path="/cart",
 *     tags={"cart"},
 *     summary="Add an item to the cart",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"product_id", "user_id", "quantity"},
 *             @OA\Property(property="product_id", type="integer", example=4),
 *             @OA\Property(property="user_id", type="integer", example=2),
 *             @OA\Property(property="quantity", type="integer", example=3)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Cart item added")
 * )
 */
Flight::route('POST /cart', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::cartService()->insert($data)]);
});

/**
 * @OA\Put(
 *     path="/cart/{id}",
 *     tags={"cart"},
 *     summary="Update a cart item",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Cart item ID"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="quantity", type="integer", example=5)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Cart item updated")
 * )
 */
Flight::route('PUT /cart/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::cartService()->update($id, $data)]);
});

/**
 * @OA\Delete(
 *     path="/cart/{id}",
 *     tags={"cart"},
 *     summary="Remove a cart item",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Cart item ID"
 *     ),
 *     @OA\Response(response=200, description="Cart item deleted")
 * )
 */
Flight::route('DELETE /cart/@id', function($id) {
    Flight::json(['deleted' => Flight::cartService()->delete($id)]);
});



















/**
 * @OA\Get(
 *     path="/order-items",
 *     tags={"order-items"},
 *     summary="Get all order items",
 *     @OA\Response(
 *         response=200,
 *         description="List of all order items"
 *     )
 * )
 */
Flight::route('GET /order-items', function() {
    Flight::json(Flight::orderItemService()->getAll());
});

/**
 * @OA\Get(
 *     path="/order-items/{id}",
 *     tags={"order-items"},
 *     summary="Get an order item by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Order item ID"
 *     ),
 *     @OA\Response(response=200, description="Order item details")
 * )
 */
Flight::route('GET /order-items/@id', function($id) {
    Flight::json(Flight::orderItemService()->get($id));
});

/**
 * @OA\Post(
 *     path="/order-items",
 *     tags={"order-items"},
 *     summary="Add a new order item",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"order_id", "product_id", "quantity"},
 *             @OA\Property(property="order_id", type="integer", example=1),
 *             @OA\Property(property="product_id", type="integer", example=2),
 *             @OA\Property(property="quantity", type="integer", example=3),
 *             @OA\Property(property="price", type="number", format="float", example=29.99)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order item added")
 * )
 */
Flight::route('POST /order-items', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::orderItemService()->insert($data)]);
});

/**
 * @OA\Put(
 *     path="/order-items/{id}",
 *     tags={"order-items"},
 *     summary="Update an order item",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Order item ID"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="quantity", type="integer", example=4),
 *             @OA\Property(property="price", type="number", format="float", example=24.99)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order item updated")
 * )
 */
Flight::route('PUT /order-items/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::orderItemService()->update($id, $data)]);
});

/**
 * @OA\Delete(
 *     path="/order-items/{id}",
 *     tags={"order-items"},
 *     summary="Delete an order item",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Order item ID"
 *     ),
 *     @OA\Response(response=200, description="Order item deleted")
 * )
 */
Flight::route('DELETE /order-items/@id', function($id) {
    Flight::json(['deleted' => Flight::orderItemService()->delete($id)]);
});

















/**
 * @OA\Get(
 *     path="/order-statuses",
 *     tags={"order-statuses"},
 *     summary="Get all order statuses",
 *     @OA\Response(
 *         response=200,
 *         description="List of all order statuses"
 *     )
 * )
 */
Flight::route('GET /order-statuses', function() {
    Flight::json(Flight::orderStatusService()->getAll());
});

/**
 * @OA\Get(
 *     path="/order-statuses/{id}",
 *     tags={"order-statuses"},
 *     summary="Get an order status by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Order status ID"
 *     ),
 *     @OA\Response(response=200, description="Order status details")
 * )
 */
Flight::route('GET /order-statuses/@id', function($id) {
    Flight::json(Flight::orderStatusService()->get($id));
});

/**
 * @OA\Post(
 *     path="/order-statuses",
 *     tags={"order-statuses"},
 *     summary="Create a new order status",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Processing")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order status created")
 * )
 */
Flight::route('POST /order-statuses', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::orderStatusService()->insert($data)]);
});

/**
 * @OA\Put(
 *     path="/order-statuses/{id}",
 *     tags={"order-statuses"},
 *     summary="Update an order status",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Order status ID"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Shipped")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Order status updated")
 * )
 */
Flight::route('PUT /order-statuses/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::orderStatusService()->update($id, $data)]);
});

/**
 * @OA\Delete(
 *     path="/order-statuses/{id}",
 *     tags={"order-statuses"},
 *     summary="Delete an order status",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Order status ID"
 *     ),
 *     @OA\Response(response=200, description="Order status deleted")
 * )
 */
Flight::route('DELETE /order-statuses/@id', function($id) {
    Flight::json(['deleted' => Flight::orderStatusService()->delete($id)]);
});


















/**
 * @OA\Get(
 *     path="/roles",
 *     tags={"roles"},
 *     summary="Get all roles",
 *     @OA\Response(
 *         response=200,
 *         description="List of all user roles"
 *     )
 * )
 */
Flight::route('GET /roles', function() {
    Flight::json(Flight::roleService()->getAll());
});

/**
 * @OA\Get(
 *     path="/roles/{id}",
 *     tags={"roles"},
 *     summary="Get a role by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Role ID"
 *     ),
 *     @OA\Response(response=200, description="Role details")
 * )
 */
Flight::route('GET /roles/@id', function($id) {
    Flight::json(Flight::roleService()->get($id));
});

/**
 * @OA\Post(
 *     path="/roles",
 *     tags={"roles"},
 *     summary="Create a new role",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="admin")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Role created")
 * )
 */
Flight::route('POST /roles', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::roleService()->insert($data)]);
});

/**
 * @OA\Put(
 *     path="/roles/{id}",
 *     tags={"roles"},
 *     summary="Update a role",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Role ID"
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="editor")
 *         )
 *     ),
 *     @OA\Response(response=200, description="Role updated")
 * )
 */
Flight::route('PUT /roles/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::roleService()->update($id, $data)]);
});

/**
 * @OA\Delete(
 *     path="/roles/{id}",
 *     tags={"roles"},
 *     summary="Delete a role",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer"),
 *         description="Role ID"
 *     ),
 *     @OA\Response(response=200, description="Role deleted")
 * )
 */
Flight::route('DELETE /roles/@id', function($id) {
    Flight::json(['deleted' => Flight::roleService()->delete($id)]);
});