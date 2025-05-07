<?php
require_once __DIR__ . '/../dao/BlogDAO.php';

class BlogService {
    private $blogDao;

    public function __construct() {
        $this->blogDao = new BlogDAO();
    }

    public function getAllBlogs() {
        return $this->blogDao->getAll();
    }

    public function getBlog($id) {
        return $this->blogDao->getById($id);
    }

    public function createBlog($data) {
        return $this->blogDao->insert($data);
    }

    public function updateBlog($id, $data) {
        return $this->blogDao->update($id, $data);
    }

    public function deleteBlog($id) {
        return $this->blogDao->delete($id);
    }
}
