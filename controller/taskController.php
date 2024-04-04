<?php
require_once('/xampp/htdocs/tassky/connection/connection.php');
require_once('/xampp/htdocs/tassky/connection/Validation.php');
require_once('/xampp/htdocs/tassky/models/classes/taskClasses.php');

$message = '';
// add tasks
if (isset($_POST['btn_tasks'])) {
    $dba            = new DatabaseManager();
    $con            = $dba->setDatabaseConnection();
    $taskname       = $con->escape($_POST['taskname'] ?? '');
    // $time = $_POST['time'] ?? '';
    $time           = $con->escape($_POST['time']);
    // $time           = \Carbon\Carbon::now();
    $date           = $con->escape($_POST['date']);
    $reminder       = $con->escape($_POST['taskReminder'] ?? '');
    // $userId         = $con->escape($_POST['userId'] ?? '');
    $description    = $con->escape($_POST['taskDescription'] ?? '');
    // echo "<pre>";
    // print_r($time);
    // echo "</pre>";
    // die();
    $validator                = new Validation();
    $taskNameValidation       = $validator->name('taskname')->value($taskname)->required();
    $timeValidation           = $validator->name('time')->value($time)->required();
    $dateValidation           = $validator->name('date')->value($date)->required();
    $reminderValidation       = $validator->name('taskReminder')->value($reminder)->required()->pattern('int');
    // $userIdValidation         = $validator->name('userId')->value($userId)->required()->pattern('int');
    $descriptionValidation    = $validator->name('taskDescription')->value($description)->required();


    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p>";
        }
        header("location:/tassky/view/list/Tasks-list.php?message=" . urlencode($message));
        exit();
    } else {

        $tasks = new Tasks();
        $message = $tasks->setTasks($taskname, $description, $date, $time, $reminder);
        header("location:/tassky/view/list/Tasks-list.php?message=" . urlencode($message));
        exit();
    }
}
// delete tasks
if (isset($_POST['removeTasks'])) {
    $dba            = new DatabaseManager();
    $con            = $dba->setDatabaseConnection();
    $tasksId       = $con->escape($_POST['tasksId'] ?? '');
    $validator                = new Validation();
    $taskNameValidation       = $validator->name('tasksId')->value($tasksId)->required();
    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p>";
        }
        header("location:/tassky/view/list/Tasks-list.php?message=" . urlencode($message));
        exit();
    } else {

        $tasks = new Tasks();
        $message = $tasks->deleteTasks($tasksId);
        header("location:/tassky/view/list/Tasks-list.php?message=" . urlencode($message));
        exit();
    }
}
// update
if (isset($_POST['updateTasks'])) {
    $dba            = new DatabaseManager();
    $con            = $dba->setDatabaseConnection();
    $taskname       = $con->escape($_POST['taskname'] ?? '');
    $time           = $con->escape($_POST['time']);
    $date           = $con->escape($_POST['date']);
    $reminder       = $con->escape($_POST['taskReminder'] ?? '');
    $taskId         = $con->escape($_POST['taskId'] ?? '');
    $description    = $con->escape($_POST['taskDescription'] ?? '');
    $validator                = new Validation();
    $taskNameValidation       = $validator->name('taskname')->value($taskname)->required();
    $timeValidation           = $validator->name('time')->value($time)->required();
    $dateValidation           = $validator->name('date')->value($date)->required();
    $reminderValidation       = $validator->name('taskReminder')->value($reminder)->required()->pattern('int');
    $taskIdValidation         = $validator->name('taskId')->value($taskId)->required()->pattern('int');
    $descriptionValidation    = $validator->name('taskDescription')->value($description)->required();


    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p>";
        }
        header("location:/tassky/view/list/Tasks-list.php?message=" . urlencode($message));
        exit();
    } else {

        $tasks = new Tasks();
        $message = $tasks->updateTasks($taskname, $description, $date, $time, $reminder, $taskId);
        header("location:/tassky/view/list/Tasks-list.php?message=" . urlencode($message));
        exit();
    }
}
