<?php
require_once __DIR__ . '/../dao/ProductDAO.php';

class ProductService {
    private $productDao;

    public function __construct() {
        $this->productDao = new ProductDAO();
    }

    public function getAllProducts() {
        return $this->productDao->getAll();
    }

    public function getProduct($id) {
        return $this->productDao->getById($id);
    }

    public function createProduct($data) {
        return $this->productDao->insert($data);
    }

    public function updateProduct($id, $data) {
        return $this->productDao->update($id, $data);
    }

    public function deleteProduct($id) {
        return $this->productDao->delete($id);
    }
}
