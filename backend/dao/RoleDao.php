<?php
require_once 'BaseDao.php';

class RoleDao extends BaseDao {
    public function __construct() {
        parent::__construct("roles");
    }
}
?>