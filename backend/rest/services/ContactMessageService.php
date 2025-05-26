<?php

require_once __DIR__ . '/../dao/ContactMessageDao.php';

class ContactMessageService {
    private $dao;

    public function __construct() {
        $this->dao = new ContactMessageDao();
    }

    public function submitMessage($data) {
        if (
            empty($data["name"]) || empty($data["email"]) || empty($data["phone_number"]) ||
            empty($data["subject"]) || empty($data["message"])
        ) {
            throw new Exception("All fields are required.");
        }

        return $this->dao->add_message($data);
    }

    public function getAllMessages() {
        return $this->dao->get_all_messages();
    }
}