<?php
require_once 'BaseDao.php';

class NotificationDao extends BaseDao {
    public function __construct() {
        parent::__construct("notifications");
    }

    public function get_all_notifications() {
        $stmt = $this->connection->prepare("SELECT * FROM notifications ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add_notification($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['is_read'] = false;
        return $this->insert("notifications", $data);
    }

    public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAsRead($id) {
        $stmt = $this->connection->prepare("UPDATE notifications SET is_read = 1 WHERE notification_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
