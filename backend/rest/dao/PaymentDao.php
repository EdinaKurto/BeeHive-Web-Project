<?php

require_once __DIR__ . '/BaseDao.php';

class PaymentDao extends BaseDao {

    public function __construct() {
        parent::__construct("payments");
    }

    public function add_payment($payment) {
        $stmt = $this->connection->prepare("INSERT INTO payments (user_id, amount, payment_date)
                                      VALUES (:user_id, :amount, :payment_date)");
        $stmt->execute($payment);
        return $this->connection->lastInsertId();
    }

    public function get_payments_by_user($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM payments WHERE user_id = :user_id ORDER BY payment_date DESC");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_all_payments() {
        $stmt = $this->connection->query("SELECT * FROM payments ORDER BY payment_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}