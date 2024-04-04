<?php
require_once('/xampp/htdocs/tassky/connection/connection.php');
require_once('/xampp/htdocs/tassky/connection/Validation.php');
require_once('/xampp/htdocs/tassky/models/classes/moduleClasses.php');
// add
if (isset($_POST['btn_createModule'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    // form data inputs
    $actionName  = $con->escape($_POST['moduleName']);
    $actionSlug     = $con->escape($_POST['moduleName']);
    // validations
    $validator = new Validation();
    $actionNameValidation = $validator->name('moduleName')->value($actionName)->required();
    // $actionSlugValidation = $validator->name('actionName')->value($actionSlug)->required();
    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p> \n";
        }
        header("location:/tassky/view/list/Modules-list.php?message=" . urlencode($message));
        exit();
    } else {
        $userClass = new Modules();
        $message = $userClass->createModule($actionName, $actionSlug);
        // return message
        header("location:/tassky/view/list/Modules-list.php?message=" . urlencode($message));
        exit();
    }
}
// edit
if (isset($_POST['btn_updateModule'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    // form data inputs
    $actionName     = $con->escape($_POST['moduleName']);
    $actionSlug     = $con->escape($_POST['moduleName']);
    $actionId       = $_POST['moduleId'];
    // validations
    $validator = new Validation();
    $actionNameValidation = $validator->name('actionName')->value($actionName)->required();
    // $actionSlugValidation = $validator->name('actionName')->value($actionSlug)->required();
    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p> \n";
        }
        header("location:/tassky/view/list/Modules-list.php?message=" . urlencode($message));
        exit();
    } else {
        $userClass = new Modules();
        $message = $userClass->updateActions($actionId, $actionName, $actionSlug);
        // return message
        header("location:/tassky/view/list/Modules-list.php?message=" . urlencode($message));
        exit();
    }
}
// delete
if (isset($_POST['btn_removeModule'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    // form data inputs
    $actionId       = $_POST['moduleId'];
    // validations

    $userClass = new Modules();
    $message = $userClass->removeActions($actionId);
    // return message
    header("location:/tassky/view/list/Modules-list.php?message=" . urlencode($message));
    exit();
}
// role have access modules
if (isset($_POST['btn_assign'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    $actions        = $_POST['actions'];
    $roleId         = $_POST['roleId'];
    // 
    $assignPermissions = new Modules();
    $message = $assignPermissions->setRolesPermission($actions, $roleId);
    if ($message) {
        header("location:/tassky/view/list/roles-assign.php?message=" . urlencode($message));
    }
    exit();
}
