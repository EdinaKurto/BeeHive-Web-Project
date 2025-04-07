<?php
require_once 'BaseDao.php';

class BlogDao extends BaseDao {
    public function __construct() {
        parent::__construct("blogs");
    }

    public function getByAuthorId($author_id) {
        $stmt = $this->connection->prepare("SELECT * FROM blogs WHERE author_id = :author_id");
        $stmt->bindParam(':author_id', $author_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>