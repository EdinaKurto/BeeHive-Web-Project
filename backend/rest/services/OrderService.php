<?php

require_once __DIR__ . '/../dao/OrderDao.php';

class OrderService {
    private $orderDao;

    public function __construct() {
        $this->orderDao = new OrderDao();
    }

    public function add_order($user_id, $data) {
        if (empty($data['address']) || empty($data['city']) || empty($data['country']) || empty($data['phone_number'])) {
            return ['error' => 'Missing order data'];
        }

        $cart = Flight::get('cart_service')->get_user_cart($user_id);
        if (!$cart || count($cart) == 0) {
            return ['error' => 'Your cart is empty'];
        }

        $order = [
            'user_id' => $user_id,
            'shipping_address' => $data['address'],
            'city' => $data['city'],
            'country' => $data['country'],
            'phone_number' => $data['phone_number'],
            'additional_notes' => $data['notes'] ?? null
        ];

        $items = [];
        foreach ($cart as $c) {
            $items[] = [
                'product_id' => $c['product_id'],
                'quantity' => $c['quantity']
            ];
        }

        return $this->orderDao->add_order($order, $items);
    }

    public function get_orders_by_user($user_id) {
        return $this->orderDao->get_orders_by_user($user_id);
    }

    public function count_pending_orders($user_id) {
        return $this->orderDao->count_orders_by_status($user_id, 1);
    }

    public function count_delivered_orders($user_id) {
        return $this->orderDao->count_orders_by_status($user_id, 3); 
    }

    public function count_total_orders($user_id) {
        return $this->orderDao->count_total_orders($user_id);
    }

    public function update_order_status($order_id, $status_id) {
        return $this->orderDao->update_order_status($order_id, $status_id);
    }

    public function delete_order($order_id) {
        return $this->orderDao->delete_order($order_id);
    }

    public function get_order_by_id($order_id) {
        return $this->orderDao->get_order_by_id($order_id);
    }

}
