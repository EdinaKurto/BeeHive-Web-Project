<?php
require_once __DIR__ . '/../dao/NotificationDao.php';

class NotificationService {
    private $dao;

    public function __construct() {
        $this->dao = new NotificationDao();
    }

    public function get_all_notifications() {
        return $this->dao->get_all_notifications();
    }

    public function create_notification($data) {
        if (empty($data["user_id"]) || empty($data["message"])) {
            throw new Exception("user_id and message are required.");
        }
        return $this->dao->add_notification($data);
    }

    public function mark_as_read($id) {
        return $this->dao->markAsRead($id);
    }

    public function delete_notification($id) {
        return $this->dao->delete("notifications", $id, "notification_id");
    }
}
