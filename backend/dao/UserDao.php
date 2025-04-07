<?php
require_once 'BaseDao.php';

class UserDao extends BaseDao {
   public function __construct() {
       parent::__construct("users");
   }

   public function getByEmail($email) {
       $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
       $stmt->bindParam(':email', $email);
       $stmt->execute();
       return $stmt->fetch();
   }
   public function getByRoleId($role_id) {
    $stmt = $this->connection->prepare("SELECT * FROM users WHERE role_id = :role_id");
    $stmt->bindParam(':role_id', $role_id);
    $stmt->execute();
    return $stmt->fetchAll();
}
}
?>