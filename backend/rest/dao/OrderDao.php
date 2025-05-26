<?php

require_once __DIR__ . '/BaseDao.php';

class OrderDao extends BaseDao {

    public function __construct() {
        parent::__construct("orders");
    }

    public function add_order($order, $items) {
        try {
            $this->connection->beginTransaction();

            $stmt = $this->connection->prepare("INSERT INTO orders (
                user_id, status_id, shipping_address, order_date, phone_number, city, country, additional_notes
            ) VALUES (
                :user_id, 1, :shipping_address, NOW(), :phone_number, :city, :country, :additional_notes
            )");

            $stmt->execute($order);
            $order_id = $this->connection->lastInsertId();

            $item_stmt = $this->connection->prepare("INSERT INTO order_items (
                order_id, product_id, quantity
            ) VALUES (
                :order_id, :product_id, :quantity
            )");

            foreach ($items as $item) {
                $item['order_id'] = $order_id;
                $item_stmt->execute($item);
            }

            $this->connection->commit();
            return $order_id;
        } catch (Exception $e) {
            $this->connection->rollBack();
            error_log("Order insert error: " . $e->getMessage());
            throw $e;
        }
    }

    public function get_orders_by_user($user_id) {
        $stmt = $this->connection->prepare("
            SELECT 
                o.order_id,
                o.order_date,
                GROUP_CONCAT(p.product_name) AS product_names,
                GROUP_CONCAT(oi.quantity) AS quantities,
                SUM(p.price * oi.quantity) AS total_price,
                s.status_name
            FROM orders o
            JOIN order_items oi ON o.order_id = oi.order_id
            JOIN products p ON oi.product_id = p.product_id
            JOIN order_statuses s ON o.status_id = s.status_id
            WHERE o.user_id = :user_id
            GROUP BY o.order_id, o.order_date, s.status_name
            ORDER BY o.order_date DESC
        ");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count_orders_by_status($user_id, $status_id) {
        $stmt = $this->connection->prepare("
            SELECT COUNT(*) as total FROM orders 
            WHERE user_id = :user_id AND status_id = :status_id
        ");
        $stmt->execute(['user_id' => $user_id, 'status_id' => $status_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function count_total_orders($user_id) {
        $stmt = $this->connection->prepare("SELECT COUNT(*) as total FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update_order_status($order_id, $new_status_id) {
        $stmt = $this->connection->prepare("UPDATE orders SET status_id = :status_id WHERE order_id = :order_id");
        return $stmt->execute([
            'status_id' => $new_status_id,
            'order_id' => $order_id
        ]);
    }

    public function delete_order($order_id) {
        $stmt = $this->connection->prepare("DELETE FROM order_items WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $order_id]);

        $stmt = $this->connection->prepare("DELETE FROM orders WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $order_id]);
    }
}
