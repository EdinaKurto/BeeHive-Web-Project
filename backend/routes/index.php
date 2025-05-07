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



Flight::register('userService', 'UserService');
Flight::route('GET /users', function() {
    Flight::json(Flight::userService()->getAllUsers());
});

Flight::route('GET /users/@id', function($id) {
    Flight::json(Flight::userService()->getUser($id));
});

Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::userService()->createUser($data)]);
});

Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::userService()->updateUser($id, $data)]);
});

Flight::route('DELETE /users/@id', function($id) {
    Flight::json(['deleted' => Flight::userService()->deleteUser($id)]);
});





Flight::register('productService', 'ProductService');
Flight::route('GET /products', function() {
    Flight::json(Flight::productService()->getAllProducts());
});

Flight::route('GET /products/@id', function($id) {
    Flight::json(Flight::productService()->getProduct($id));
});

Flight::route('POST /products', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::productService()->createProduct($data)]);
});

Flight::route('PUT /products/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::productService()->updateProduct($id, $data)]);
});

Flight::route('DELETE /products/@id', function($id) {
    Flight::json(['deleted' => Flight::productService()->deleteProduct($id)]);
});





Flight::register('orderService', 'OrderService');
Flight::route('GET /orders', function() {
    Flight::json(Flight::orderService()->getAllOrders());
});

Flight::route('GET /orders/@id', function($id) {
    Flight::json(Flight::orderService()->getOrder($id));
});

Flight::route('POST /orders', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::orderService()->createOrder($data)]);
});

Flight::route('PUT /orders/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::orderService()->updateOrder($id, $data)]);
});

Flight::route('DELETE /orders/@id', function($id) {
    Flight::json(['deleted' => Flight::orderService()->deleteOrder($id)]);
});





Flight::register('categoryService', 'CategoryService');
Flight::route('GET /categories', function() {
    Flight::json(Flight::categoryService()->getAllCategories());
});





Flight::register('blogService', 'BlogService');
Flight::route('GET /blogs', function() {
    Flight::json(Flight::blogService()->getAllBlogs());
});

Flight::route('GET /blogs/@id', function($id) {
    Flight::json(Flight::blogService()->getBlog($id));
});

Flight::route('POST /blogs', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::blogService()->createBlog($data)]);
});

Flight::route('PUT /blogs/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::blogService()->updateBlog($id, $data)]);
});

Flight::route('DELETE /blogs/@id', function($id) {
    Flight::json(['deleted' => Flight::blogService()->deleteBlog($id)]);
});




Flight::register('blogCommentService', 'BlogCommentService');
Flight::route('GET /comments', function() {
    Flight::json(Flight::blogCommentService()->getAll());
});

Flight::route('GET /comments/@id', function($id) {
    Flight::json(Flight::blogCommentService()->get($id));
});

Flight::route('POST /comments', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::blogCommentService()->insert($data)]);
});

Flight::route('PUT /comments/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::blogCommentService()->update($id, $data)]);
});

Flight::route('DELETE /comments/@id', function($id) {
    Flight::json(['deleted' => Flight::blogCommentService()->delete($id)]);
});




Flight::register('contactService', 'ContactMessageService');
Flight::route('GET /messages', function() {
    Flight::json(Flight::contactService()->getAll());
});

Flight::route('GET /messages/@id', function($id) {
    Flight::json(Flight::contactService()->get($id));
});

Flight::route('POST /messages', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::contactService()->insert($data)]);
});

Flight::route('DELETE /messages/@id', function($id) {
    Flight::json(['deleted' => Flight::contactService()->delete($id)]);
});




Flight::register('notificationService', 'NotificationService');
Flight::route('GET /notifications', function() {
    Flight::json(Flight::notificationService()->getAll());
});

Flight::route('GET /notifications/@id', function($id) {
    Flight::json(Flight::notificationService()->get($id));
});

Flight::route('POST /notifications', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::notificationService()->insert($data)]);
});

Flight::route('PUT /notifications/@id/read', function($id) {
    Flight::json(['updated' => Flight::notificationService()->markAsRead($id)]);
});

Flight::route('DELETE /notifications/@id', function($id) {
    Flight::json(['deleted' => Flight::notificationService()->delete($id)]);
});




Flight::register('paymentService', 'PaymentService');
Flight::route('GET /payments', function() {
    Flight::json(Flight::paymentService()->getAll());
});

Flight::route('GET /payments/@id', function($id) {
    Flight::json(Flight::paymentService()->get($id));
});

Flight::route('POST /payments', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::paymentService()->insert($data)]);
});

Flight::route('DELETE /payments/@id', function($id) {
    Flight::json(['deleted' => Flight::paymentService()->delete($id)]);
});





Flight::register('cartService', 'CartService');
Flight::route('GET /cart', function() {
    Flight::json(Flight::cartService()->getAll());
});

Flight::route('GET /cart/@id', function($id) {
    Flight::json(Flight::cartService()->get($id));
});

Flight::route('POST /cart', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::cartService()->insert($data)]);
});

Flight::route('PUT /cart/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::cartService()->update($id, $data)]);
});

Flight::route('DELETE /cart/@id', function($id) {
    Flight::json(['deleted' => Flight::cartService()->delete($id)]);
});




Flight::register('orderItemService', 'OrderItemService');
Flight::route('GET /order-items', function() {
    Flight::json(Flight::orderItemService()->getAll());
});

Flight::route('GET /order-items/@id', function($id) {
    Flight::json(Flight::orderItemService()->get($id));
});

Flight::route('POST /order-items', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::orderItemService()->insert($data)]);
});

Flight::route('PUT /order-items/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::orderItemService()->update($id, $data)]);
});

Flight::route('DELETE /order-items/@id', function($id) {
    Flight::json(['deleted' => Flight::orderItemService()->delete($id)]);
});





Flight::register('orderStatusService', 'OrderStatusService');
Flight::route('GET /order-statuses', function() {
    Flight::json(Flight::orderStatusService()->getAll());
});

Flight::route('GET /order-statuses/@id', function($id) {
    Flight::json(Flight::orderStatusService()->get($id));
});

Flight::route('POST /order-statuses', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::orderStatusService()->insert($data)]);
});

Flight::route('PUT /order-statuses/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::orderStatusService()->update($id, $data)]);
});

Flight::route('DELETE /order-statuses/@id', function($id) {
    Flight::json(['deleted' => Flight::orderStatusService()->delete($id)]);
});




Flight::register('roleService', 'RoleService');

Flight::route('GET /roles', function() {
    Flight::json(Flight::roleService()->getAll());
});

Flight::route('GET /roles/@id', function($id) {
    Flight::json(Flight::roleService()->get($id));
});

Flight::route('POST /roles', function() {
    $data = Flight::request()->data->getData();
    Flight::json(['id' => Flight::roleService()->insert($data)]);
});

Flight::route('PUT /roles/@id', function($id) {
    $data = Flight::request()->data->getData();
    Flight::json(['updated' => Flight::roleService()->update($id, $data)]);
});

Flight::route('DELETE /roles/@id', function($id) {
    Flight::json(['deleted' => Flight::roleService()->delete($id)]);
});
