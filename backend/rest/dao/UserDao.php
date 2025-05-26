<?php
require_once 'BaseDao.php';

class UserDao extends BaseDao {
    public function __construct()
    {
        parent::__construct('users');
    }

    public function add_user($user) {
        return $this->insert("users", $user);
    }

    public function get_user_by_email($email) {
    $stmt = $this->connection->prepare("SELECT u.*, r.name AS role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function get_user_by_id($id) {
        return $this->query_unique("SELECT * FROM users WHERE user_id = :id", ["id" => $id]);
    }

    public function update_user($id, $user) {
        return $this->update("users", $id, $user, "user_id");
    }

    public function delete_user($id) {
        return $this->delete("users", $id, "user_id");
    }

    public function get_all() {
        return $this->query("SELECT * FROM users", []);
    }
}
?>