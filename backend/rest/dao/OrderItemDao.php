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

    public function getItemsByOrder($orderId) {
        $stmt = $this->connection->prepare("
            SELECT oi.*, p.name, p.price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}