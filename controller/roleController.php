<?php
require_once('/xampp/htdocs/tassky/connection/connection.php');
require_once('/xampp/htdocs/tassky/connection/Validation.php');
require_once('/xampp/htdocs/tassky/models/classes/rolesClasses.php');
// create new roles
if (isset($_POST['create_roles'])) {
    // 
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    // form data inputs
    $roleName  = $con->escape($_POST['roleName']);
    $slug      = $con->escape($_POST['roleName']);
    // validations
    $validator = new Validation();
    $usernameValidation = $validator->name('roleName')->value($roleName)->required();
    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p> \n";
        }
        header("location:/tassky/view/list/Roles-list.php?message=" . urlencode($message));
        exit();
    } else {
        $roleClass = new Roles();
        $message = $roleClass->createRole($roleName, $slug);
        // return message
        header("location:/tassky/view/list/Roles-list.php?message=" . urlencode($message));
        exit();
    }
}
// through remove roles
if (isset($_POST['removeRoles'])) {
    $con = '';
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    $roleid    = $con->escape($_POST['roleId']);
    // create new users
    $deleteRoles  = new Roles();
    $message      = $deleteRoles->deleteRoles($roleid);
    // return message
    header("location:/tassky/view/list/Roles-list.php?message=" . urlencode($message));
    // exit();
}
// through update roles
if (isset($_POST['updateRoles'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    $roleid    = $con->escape($_POST['roleId']);
    $rolename  = $con->escape($_POST['roleName']);
    $slug      = $con->escape($_POST['roleName']);
    $validator = new Validation();
    $rolenameValidation = $validator->name('roleName')->value($rolename)->required();
    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p> \n";
        }
        header("location:/xampp/htdocs/tassky/view/list/Roles-list.php?message=" . urlencode($message));
    } else {
        // create new users

        $updateRoles  = new Roles();
        $message      = $updateRoles->updateRoles($rolename, $slug, $roleid);
        // return message
        header("location:/tassky/view/list/Roles-list.php?message=" . urlencode($message));
        // exit();
    }
}
// setup roles to assign permissions
if (isset($_POST['btn_assign'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    $actions        = $_POST['actions'];
    $roleId         = $_POST['roleId'];
    // 
    $assignPermissions = new Roles();
    $message = $assignPermissions->setRolesPermission($actions, $roleId);
    if ($message) {
        header("location:/tassky/view/list/Roles-list.php?message=" . urlencode($message));
    }
    exit();
}
