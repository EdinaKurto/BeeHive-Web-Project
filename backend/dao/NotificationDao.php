<?php
require_once 'BaseDao.php';

class NotificationDao extends BaseDao {
    public function __construct() {
        parent::__construct("notifications");
    }

    public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM notifications WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>