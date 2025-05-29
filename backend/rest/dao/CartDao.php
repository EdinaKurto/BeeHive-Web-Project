<?php
require_once __DIR__ . "/BaseDao.php";

class CartDao extends BaseDao {
    public function __construct() {
        parent::__construct("cart");
    }

    public function add_to_cart($user_id, $product_id) {
        $existing = $this->query_unique(
            "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id",
            ["user_id" => $user_id, "product_id" => $product_id]
        );

        if ($existing) {
            $new_quantity = $existing['quantity'] + 1;
            $this->update_quantity($user_id, $product_id, $new_quantity);
        } else {
            $this->insert("cart", [
                "user_id" => $user_id,
                "product_id" => $product_id,
                "quantity" => 1
            ]);
        }
    }

    public function remove_from_cart($user_id, $product_id) {
        $this->query(
            "DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id",
            ["user_id" => $user_id, "product_id" => $product_id]
        );
    }

    public function update_quantity($user_id, $product_id, $quantity) {
        $this->query(
            "UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id",
            ["quantity" => $quantity, "user_id" => $user_id, "product_id" => $product_id]
        );
    }

    public function clear_cart($user_id): void {
        $this->query(
            "DELETE FROM cart WHERE user_id = :user_id",
            ["user_id" => $user_id]
        );
    }

    public function get_cart_summary_by_user($user_id) {
        $result = $this->query(
            "SELECT 
                SUM(c.quantity * p.price) AS total_value,
                SUM(c.quantity) AS total_count
             FROM cart c
             JOIN products p ON c.product_id = p.product_id
             WHERE c.user_id = :user_id",
            ["user_id" => $user_id]
        );

        return count($result) > 0 ? $result[0] : ["total_value" => 0, "total_count" => 0];
    }

    public function get_cart_by_user($user_id, $search = "", $sort_by = "product_name", $sort_order = "asc") {
        $allowed_sort_by = ["product_name", "price"];
        $allowed_sort_order = ["asc", "desc"];

        if (!in_array($sort_by, $allowed_sort_by)) $sort_by = "product_name";
        if (!in_array($sort_order, $allowed_sort_order)) $sort_order = "asc";

        $query = "SELECT 
                    p.product_id,
                    p.product_name AS name,
                    p.category_id,
                    p.price,
                    p.description,
                    p.image_url,
                    c.quantity AS cart_quantity
                  FROM cart c
                  JOIN products p ON c.product_id = p.product_id
                  WHERE c.user_id = :user_id";

        $params = ["user_id" => $user_id];

        if (!empty($search)) {
            $query .= " AND LOWER(p.product_name) LIKE :search";
            $params["search"] = "%" . strtolower($search) . "%";
        }

        $query .= " ORDER BY $sort_by $sort_order";
        return $this->query($query, $params);
    }
}
