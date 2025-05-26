<?php
require_once __DIR__ . "/BaseDao.php";

class AuthDao extends BaseDao {
    public function __construct() {
        parent::__construct("users");
    }

    public function get_user_by_email($email) {
        $query = "
            SELECT u.*, r.role_name AS role
            FROM users u
            JOIN roles r ON u.role_id = r.role_id
            WHERE u.email = :email
        ";
        return $this->query_unique($query, ['email' => $email]);
    }


    public function add($user) {
        return $this->insert("users", $user);
    }
}
