<?php

require_once 'BaseDao.php';

class ContactMessageDao extends BaseDao {
    public function __construct() {
        parent::__construct("contact_messages");
    }

    public function add_message($message) {
        $message["submitted_at"] = date('Y-m-d H:i:s');
        return $this->insert("contact_messages", $message);
    }

    public function get_all_messages() {
        $stmt = $this->connection->prepare("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
