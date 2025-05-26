<?php
require_once __DIR__ . "/BaseDao.php";

class BlogDao extends BaseDao {
    public function __construct() {
        parent::__construct("blogs");
    }

    public function get_all_blogs() {
        return $this->query("SELECT * FROM blogs ORDER BY published_at DESC", []);
    }

    public function get_blog_by_id($id) {
        return $this->query_unique("SELECT * FROM blogs WHERE blog_id = :id", ["id" => $id]);
    }

    public function add_blog($blog) {
        return $this->insert("blogs", $blog);
    }

    public function update_blog($id, $blog) {
        return $this->update("blogs", "blog_id", $id, $blog);
    }

    public function delete_blog($id) {
        return $this->delete("blogs", "blog_id", $id);
    }

    // 🗨️ COMMENTS
    public function get_comments_for_blog($blog_id) {
        return $this->query("SELECT * FROM blog_comments WHERE blog_id = :id ORDER BY created_at DESC", ["id" => $blog_id]);
    }

    public function add_comment($comment) {
        return $this->insert("blog_comments", $comment);
    }
}
