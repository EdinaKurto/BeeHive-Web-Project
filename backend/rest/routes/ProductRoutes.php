<?php
require_once __DIR__ . '/../services/ProductService.php';
require_once __DIR__ . '/../../utils/MessageHandler.php';

Flight::set('product_service', new ProductService());

Flight::group('/products', function () {

    Flight::route('GET /', function () {
        $search = Flight::request()->query['search'] ?? null;
        $category_id = Flight::request()->query['category_id'] ?? null;
        $data = Flight::get('product_service')->get_all_products($search, $category_id);
        MessageHandler::handleServiceResponse($data);
    });

    Flight::route('GET /@id', function ($id) {
        $product = Flight::get('product_service')->get_product_by_id($id);
        MessageHandler::handleServiceResponse($product);
    });

    Flight::route('POST /', function () {
        Flight::auth_middleware()->authorizeRoles(["admin"]);
        $data = Flight::request()->data->getData();

        if (!empty($_FILES['image'])) {
            $imagePath = 'uploads/products/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $data['image_url'] = $imagePath;
        }

        $result = Flight::get('product_service')->add_product($data);
        MessageHandler::handleServiceResponse($result, "Product added successfully");
    });

    Flight::route('PUT /@id', function ($id) {
        Flight::auth_middleware()->authorizeRoles(["admin"]);
        $data = Flight::request()->data->getData();
        $result = Flight::get('product_service')->update_product($id, $data);
        MessageHandler::handleServiceResponse($result, "Product updated successfully");
    });

    Flight::route('DELETE /@id', function ($id) {
        Flight::auth_middleware()->authorizeRoles(["admin"]);
        $result = Flight::get('product_service')->delete_product($id);
        MessageHandler::handleServiceResponse($result, "Product deleted successfully");
    });
});
