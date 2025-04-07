<?php
require_once 'BaseDao.php';

class BlogCommentDao extends BaseDao {
    public function __construct() {
        parent::__construct("blog_comments");
    }

    public function getCommentsByBlogId($blog_id) {
        $stmt = $this->connection->prepare("SELECT * FROM blog_comments WHERE blog_id = :blog_id");
        $stmt->bindParam(':blog_id', $blog_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>