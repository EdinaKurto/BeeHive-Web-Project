<?php
require_once __DIR__ . '/../dao/BlogDao.php';

class BlogService {
    private $dao;

    public function __construct() {
        $this->dao = new BlogDao();
    }

    public function get_all() {
        return $this->dao->get_all_blogs();
    }

    public function get_by_id($id) {
        return $this->dao->get_blog_by_id($id);
    }

    public function create($blog) {
        return $this->dao->add_blog($blog);
    }

    public function update($id, $blog) {
        return $this->dao->update_blog($id, $blog);
    }

    public function delete($id) {
        return $this->dao->delete_blog($id);
    }


    public function get_comments($blog_id) {
        return $this->dao->get_comments_for_blog($blog_id);
    }

    public function add_comment($comment) {
        return $this->dao->add_comment($comment);
    }
}
