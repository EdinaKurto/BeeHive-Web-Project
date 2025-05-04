<?php
require_once __DIR__ . '/../dao/ContactMessageDAO.php';

class ContactMessageService {
    private $dao;

    public function __construct() {
        $this->dao = new ContactMessageDAO();
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
