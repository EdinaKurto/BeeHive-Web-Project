<?php
require_once 'UserDao.php';
require_once 'RoleDao.php';
require_once 'CategoryDao.php';
require_once 'ProductDao.php';
require_once 'OrderStatusDao.php'; 
require_once 'OrderDao.php';
require_once 'OrderItemDao.php';
require_once 'PaymentDao.php';
require_once 'BlogDao.php';
require_once 'BlogCommentDao.php';
require_once 'ContactMessageDao.php';
require_once 'CartDao.php';
require_once 'NotificationDao.php';

// ROLE
$roleDao = new RoleDao();
$roleDao->insert(['role_name' => 'Admin']);
$roleId = $roleDao->getAll()[count($roleDao->getAll()) - 1]['id'];

// CATEGORY
$categoryDao = new CategoryDao();
$categoryDao->insert(['category_name' => 'HoneyComb']);
$categoryId = $categoryDao->getAll()[count($categoryDao->getAll()) - 1]['id'];

// ORDER STATUS
$statusDao = new OrderStatusDao();
$statusDao->insert(['status_name' => 'Pending']);
$statusId = $statusDao->getAll()[count($statusDao->getAll()) - 1]['id'];

// USER
$userDao = new UserDao();
$userDao->insert([
    'full_name' => 'Edina Eddie',
    'email' => 'edd.k@example.com',
    'password' => password_hash('password456', PASSWORD_DEFAULT),
    'phone_number' => '123456789',
    'address' => '123 Test St',
    'role_id' => $roleId
]);
$userId = $userDao->getLastInsertedId();

// PRODUCT
$productDao = new ProductDao();
$productDao->insert([
    'product_name' => 'Honey',
    'price' => 299.99,
    'stock_quantity' => 10,
    'description' => 'Brand organic Honey',
    'image_url' => 'Honey.jpg',
    'category_id' => $categoryId
]);
$productId = $productDao->getLastInsertedId();

// ORDER
$orderDao = new OrderDao();
$orderDao->insert([
    'user_id' => $userId,
    'status_id' => $statusId,
    'shipping_address' => '123 Test St',
    'order_date' => date('Y-m-d H:i:s'),
    'city' => 'Sarajevo',
    'country' => 'Bosnia',
    'phone_number' => '123456789',
    'additional_notes' => 'Order description'
]);
$orderId = $orderDao->getAll()[count($orderDao->getAll()) - 1]['id'];

// ORDERED ITEM
$orderItemDao = new OrderItemDao();
$orderItemDao->insert([
    'order_id' => $orderId,
    'product_id' => $productId,
    'quantity' => 2
]);

// PAYMENT
$paymentDao = new PaymentDao();
$paymentDao->insert([
    'user_id' => $userId,
    'payment_date' => date('Y-m-d H:i:s'),
    'amount' => 299.99 * 2
]);

// BLOG
$blogDao = new BlogDao();
$blogDao->insert([
    'title' => 'Bee Benefits',
    'content' => 'Honey has natural healing properties...',
    'author_id' => $userId,
    'published_at' => date('Y-m-d H:i:s')
]);
$blogId = $blogDao->getLastInsertedId();

// BLOG COMMENT
if ($blogId) {
    $blogCommentDao = new BlogCommentDao();
    $blogCommentDao->insert([
        'blog_id' => $blogId,
        'user_id' => $userId,
        'comment' => 'Great info about the website BeeHive, thanks!',
        'created_at' => date('Y-m-d H:i:s')
    ]);
    $blogCommentId = $blogCommentDao->getAll()[0]['id'];
} else {
    echo "Blog insertion failed. Blog ID is null.\n";
}

// CONTACT MESSAGE
$contactMessageDao = new ContactMessageDao();
$contactMessageDao->insert([
    'name' => 'Jane Doe',
    'email' => 'janey.doey@example.com',
    'phone_number' => '123456789',
    'subject' => 'I need order help',
    'message' => 'Where is my honey that I ordered?'
]);
$contactMessageId = $contactMessageDao->getAll()[0]['id'];

// CART
$cartDao = new CartDao();
$cartDao->insert([
    'user_id' => $userId,
    'product_id' => $productId,
    'quantity' => 5
]);
$cartId = $cartDao->getAll()[0]['id'];

// NOTIFICATION
$notificationDao = new NotificationDao();
$notificationDao->insert([
    'user_id' => $userId,
    'message' => 'Your order has been shipped!',
    'is_read' => 0,
    'created_at' => date('Y-m-d H:i:s')
]);
$notificationId = $notificationDao->getAll()[0]['id'];


//  OUTPUT 
echo "\n--- Roles ---\n";
print_r($roleDao->getAll());

echo "\n--- Categories ---\n";
print_r($categoryDao->getAll());

echo "\n--- Users ---\n";
print_r($userDao->getAll());

echo "\n--- Products ---\n";
print_r($productDao->getAll());

echo "\n--- Orders ---\n";
print_r($orderDao->getAll());

echo "\n--- Order Items ---\n";
print_r($orderItemDao->getAll());

echo "\n--- Payments ---\n";
print_r($paymentDao->getAll());

echo "\n--- Blogs ---\n";
print_r($blogDao->getAll());

echo "\n--- Blog Comment ---\n";
print_r($blogCommentDao->getAll());

echo "\n--- Contact Messages ---\n";
print_r($contactMessageDao->getAll());

echo "\n--- Carts ---\n";
print_r($cartDao->getAll());

echo "\n--- Notifications ---\n";
print_r($notificationDao->getAll());
?>