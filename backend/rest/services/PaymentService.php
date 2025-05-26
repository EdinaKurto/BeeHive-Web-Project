<?php

require_once __DIR__ . '/../dao/PaymentDao.php';

class PaymentService {
    private $paymentDao;

    public function __construct() {
        $this->paymentDao = new PaymentDao();
    }

    public function add_payment($user_id, $data) {
        if (empty($data['amount'])) {
            return ['error' => 'Amount is required'];
        }

        $payment = [
            'user_id' => $user_id,
            'amount' => $data['amount'],
            'payment_date' => $data['payment_date'] ?? date('Y-m-d H:i:s')
        ];

        return $this->paymentDao->add_payment($payment);
    }

    public function get_payments_by_user($user_id) {
        return $this->paymentDao->get_payments_by_user($user_id);
    }

    public function get_all_payments() {
        return $this->paymentDao->get_all_payments();
    }
}
