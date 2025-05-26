<?php

require_once __DIR__ . '/../dao/CategoryDao.php';

class CategoryService {
    private $categoryDao;

    public function __construct() {
        $this->categoryDao = new CategoryDao(); 
    }

    public function getAllCategories() {
        return $this->categoryDao->get_all_categories_sorted(); 
    }

    public function getCategoryById($id) {
        return $this->categoryDao->get_by_id($id);
    }

    public function createCategory($data): int {
        return $this->categoryDao->add($data);
    }

    public function updateCategory($id, $data): mixed {
        return $this->categoryDao->update("categories", $id, $data, "category_id");
    }

    public function deleteCategory($id): bool {
        return $this->categoryDao->delete("categories", $id, "category_id");
    }
}
