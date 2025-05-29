<?php
require_once __DIR__ . "/../dao/ProductDao.php";

class ProductService {
    private $dao;

    public function __construct() {
        $this->dao = new ProductDao();
    }

    public function get_all_products($search = null, $category_id = null) {
        return $this->dao->get_all_products($search, $category_id);
    }

    public function get_product_by_id($id) {
        return $this->dao->get_by_id($id);
    }

    public function add_product($data) {
        return $this->dao->add_product($data);
    }

    public function update_product($id, $data) {
        return $this->dao->update_product($id, $data);
    }

    public function delete_product($id) {
        return $this->dao->delete_product($id);
    }
}
