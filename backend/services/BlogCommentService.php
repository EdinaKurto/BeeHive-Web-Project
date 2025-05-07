<?php
require_once __DIR__ . '/../dao/BlogCommentDAO.php';

class BlogCommentService {
    private $dao;

    public function __construct() {
        $this->dao = new BlogCommentDAO();
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

    public function update($id, $data) {
        return $this->dao->update($id, $data);
    }

    public function delete($id) {
        return $this->dao->delete($id);
    }
}
