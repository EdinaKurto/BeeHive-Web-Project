<?php
require_once __DIR__ . '/../dao/PaymentDAO.php';

class PaymentService {
    private $dao;

    public function __construct() {
        $this->dao = new PaymentDAO();
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function get($id) {
        return $this->dao->getById($id);
    }

    public function insert($data) {
        return $this->dao->insert($data);
    }

    public function delete($id) {
        return $this->dao->delete($id);
    }
}
