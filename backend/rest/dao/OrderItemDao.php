<?php
require_once __DIR__ . "/BaseDao.php";

class OrderItemDao extends BaseDao {
    public function __construct() {
        parent::__construct('order_items');
    }

    public function add_item_to_order($order_id, $product_id, $quantity) {
        $order_item = [
            "order_id" => $order_id,
            "product_id" => $product_id,
            "quantity" => $quantity
        ];

        return $this->insert("order_items", $order_item);
    }
}
