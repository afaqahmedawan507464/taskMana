<?php
require_once('/xampp/htdocs/tassky/connection/connection.php');
require_once('/xampp/htdocs/tassky/connection/Validation.php');
require_once('/xampp/htdocs/tassky/models/classes/actionClasses.php');
// create Actions
if (isset($_POST['btn_createAction'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    // form data inputs
    $actionName  = $con->escape($_POST['actionName']);
    $actionSlug  = $con->escape($_POST['actionName']);
    // validations
    $validator = new Validation();
    $actionNameValidation = $validator->name('actionName')->value($actionName)->required();
    // $actionSlugValidation = $validator->name('actionName')->value($actionSlug)->required();
    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p> \n";
        }
        header("location:/tassky/view/list/Actions-list.php?message=" . urlencode($message));
        exit();
    } else {
        $userClass = new Actions();
        $message = $userClass->addActions($actionName, $actionSlug);
        // return message
        header("location:/tassky/view/list/Actions-list.php?message=" . urlencode($message));
        exit();
    }
}
// update Actions
if (isset($_POST['btn_updateAction'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    // form data inputs
    $actionName     = $con->escape($_POST['actionName']);
    $actionSlug     = $con->escape($_POST['actionName']);
    $actionId       = $_POST['actionId'];
    // validations
    $validator = new Validation();
    $actionNameValidation = $validator->name('actionName')->value($actionName)->required();
    // $actionSlugValidation = $validator->name('actionName')->value($actionSlug)->required();
    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p> \n";
        }
        header("location:/tassky/view/list/Actions-list.php?message=" . urlencode($message));
        exit();
    } else {
        $userClass = new Actions();
        $message = $userClass->updateActions($actionId, $actionName, $actionSlug);
        // return message
        header("location:/tassky/view/list/Actions-list.php?message=" . urlencode($message));
        exit();
    }
}
// remove Actions
if (isset($_POST['btn_removeAction'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    // form data inputs
    $actionId       = $_POST['actionId'];
    // validations

    $userClass = new Actions();
    $message = $userClass->removeActions($actionId);
    // return message
    header("location:/tassky/view/list/Actions-list.php?message=" . urlencode($message));
    exit();
}
