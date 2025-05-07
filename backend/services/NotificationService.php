<?php
require_once __DIR__ . '/../dao/NotificationDAO.php';

class NotificationService {
    private $dao;

    public function __construct() {
        $this->dao = new NotificationDAO();
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

    public function markAsRead($id) {
        return $this->dao->markAsRead($id);
    }

    public function delete($id) {
        return $this->dao->delete($id);
    }
}
