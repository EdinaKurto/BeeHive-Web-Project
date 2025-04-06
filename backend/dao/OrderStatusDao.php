<?php
require_once 'BaseDao.php';

class OrderStatusDao extends BaseDao {
    public function __construct() {
        parent::__construct("order_statuses");
    }
}
?>