<?php
require_once('/xampp/htdocs/task-managment-system/connection/connection.php');
$dba = new DatabaseManager();
$db = $dba->setDatabaseConnection();

// SQL to create mapping table
$sql = "CREATE TABLE permission_roles (
    permission INT(6) UNSIGNED NOT NULL,
    role INT(6) UNSIGNED NOT NULL,
    PRIMARY KEY (permission, role),
    FOREIGN KEY (permission) REFERENCES permissions(id),
    FOREIGN KEY (role) REFERENCES roles(id)
)";
$result = $db->query($sql);
