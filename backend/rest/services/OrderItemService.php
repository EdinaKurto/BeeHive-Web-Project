<?php
require_once __DIR__ . '/../dao/OrderItemDao.php';

class OrderItemService {
    private $orderItemDao;

    

    public function __construct() {
        $this->orderItemDao = new OrderItemDao();
    }

    public function add_item_to_order($order_id, $product_id, $quantity) {
        if (empty($order_id) || empty($product_id) || $quantity === null) {
            return ["error" => "Invalid input data."];
        }

        return $this->orderItemDao->add_item_to_order($order_id, $product_id, $quantity);
    }

    public function get_items_by_order($order_id) {
        return $this->orderItemDao->getItemsByOrder($order_id);
    }
}
