<?php
require_once __DIR__ . '/../dao/OrderDAO.php';

class OrderService {
    private $orderDao;

    public function __construct() {
        $this->orderDao = new OrderDAO();
    }

    public function getAllOrders() {
        return $this->orderDao->getAll();
    }

    public function getOrder($id) {
        return $this->orderDao->getById($id);
    }

    public function createOrder($data) {
        return $this->orderDao->insert($data);
    }

    public function updateOrder($id, $data) {
        return $this->orderDao->update($id, $data);
    }

    public function deleteOrder($id) {
        return $this->orderDao->delete($id);
    }
}
