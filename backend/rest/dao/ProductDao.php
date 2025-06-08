<?php
require_once __DIR__ . "/BaseDao.php";

class ProductDao extends BaseDao {
    public function __construct() {
        parent::__construct("products");
    }

    public function get_all_products($search = null, $category_id = null) {
        $query = "
            SELECT 
                p.*, 
                c.category_name 
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE 1=1
        ";

        $params = [];

        if ($search) {
            $query .= " AND LOWER(p.product_name) LIKE :search";
            $params["search"] = "%" . strtolower($search) . "%";
        }

        if ($category_id) {
            $query .= " AND p.category_id = :category_id";
            $params["category_id"] = $category_id;
        }

        return $this->query($query, $params);
    }

    public function get_product_by_id($product_id) {
        return $this->query_unique(
            "SELECT * FROM products WHERE product_id = :product_id",
            ["product_id" => $product_id]
        );
    }

    public function add_product($product) {
        return $this->insert("products", $product);
    }

    public function update_product($product_id, $product) {
        return $this->update("products", $product_id, $product, "product_id");
    }

    public function delete_product($product_id) {
        return $this->delete("products", "product_id", $product_id);
    }

    public function getAllWithCategory() {
        $stmt = $this->connection->prepare("
            SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
