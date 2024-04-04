<?php


// require_once('/tassky/vendor/Illuminate\Support\Facades\Validator');

require_once('/xampp/htdocs/tassky/connection/connection.php');
require_once('/xampp/htdocs/tassky/connection/Validation.php');
require_once('/xampp/htdocs/tassky/models/classes/userClasses.php');
// form data to users register
if (isset($_POST['btn_register'])) {
    // 
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    // form data inputs
    $emailaddress  = $con->escape($_POST['emailaddress']);
    $firstname     = $con->escape($_POST['firstname']);
    $password      = $con->escape($_POST['password']);
    $lastname      = $con->escape($_POST['lastname']);
    // validations
    $validator = new Validation();
    $usernameValidation = $validator->name('firstname')->value($firstname)->required();
    $lastnameValidation = $validator->name('lastname')->value($lastname)->required();
    $emailValidation    = $validator->name('emailaddress')->value($emailaddress)->required();
    $passwordValidation = $validator->name('password')->value($password)->required();
    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p> \n";
        }
        header("location:/tassky/view/authenication/register.php?message=" . urlencode($message));
        exit();
    } else {
        $userClass = new Users();
        $message = $userClass->newUsers($firstname, $lastname, $emailaddress, $password);
        // return message
        header("location:/tassky/view/authenication/register.php?message=" . urlencode($message));
        exit();
    }
}
// form
if (isset($_POST['btn_createRoles'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    $emailaddress  = $con->escape($_POST['emailaddress']);
    $firstname     = $con->escape($_POST['firstname']);
    $password      = $con->escape($_POST['password']);
    $lastname      = $con->escape($_POST['lastname']);
    $roles         = $con->escape($_POST['roleId']);

    $validator          = new Validation();
    $usernameValidation = $validator->name('firstname')->value($firstname)->required();
    $lastnameValidation = $validator->name('lastname')->value($lastname)->required();
    $emailValidation    = $validator->name('emailaddress')->value($emailaddress)->required();
    $passwordValidation = $validator->name('password')->value($password)->required();
    $rolesValidation    = $validator->name('roleId')->value($roles)->required();

    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p> \n";
        }
        header("location:/tassky/view/list/Users-list.php?message=" . urlencode($message));
    } else {
        // create new users
        $registration = new Users();
        $message = $registration->add($firstname, $password, $emailaddress, $lastname, $roles);
        // return message
        header("location:/tassky/view/list/Users-list.php?message=" . urlencode($message));
        exit();
    }
}
// role assign
if (isset($_POST['btn_assignroles'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    // form data inputs
    $userId        = $_POST['userId'];
    $userRoles     = $_POST['userRoles'];

    // validations
    $validator = new Validation();
    $userIdValidation = $validator->name('userId')->value($userId)->required();
    $userRoleValidation = $validator->name('userRoles')->value($userRoles)->required();
    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p> \n";
        }
        header("location:/tassky/view/list/Users-list.php?message=" . urlencode($message));
        exit();
    } else {
        $userClass = new Users();
        $message = $userClass->userAssignRole($userId, $userRoles);
        // return message
        header("location:/tassky/view/list/Users-list.php?message=" . urlencode($message));
        exit();
    }
}
// login
if (isset($_POST['btn_login'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    // form data inputs
    $emailaddress  = $con->escape($_POST['emailaddress']);
    $password      = $con->escape($_POST['password']);
    $validator = new Validation();
    $emailValidation    = $validator->name('emailaddress')->value($emailaddress)->required();
    $passwordValidation = $validator->name('password')->value($password)->required();
    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p> \n";
        }
        header("location:/tassky/view/authenication/login.php?message=" . urlencode($message));
        exit();
    } else {
        $userClass = new Users();
        $message = $userClass->loginUser($emailaddress, $password);
        header("location:/tassky/view/authenication/login.php");
        // exit();
    }
}
// logout
if (isset($_POST['btn_logout'])) {
    $userClass = new Users();
    $logout = $userClass->logoutUser();
}
// remove user
if (isset($_POST['btn_removeUser'])) {
    $con         = '';
    $dba         = new DatabaseManager();
    $con         = $dba->setDatabaseConnection();
    $userid      = $con->escape($_POST['userId']);
    $userClass   = new Users();
    $message     = $userClass->removeUser($userid);
    // return message
    header("location:/tassky/view/list/Users-list.php?message=" . urlencode($message));
    exit();
}
// update Users
if (isset($_POST['btn_updateUser'])) {
    $dba = new DatabaseManager();
    $con = $dba->setDatabaseConnection();
    // form data inputs
    $emailaddress  = $con->escape($_POST['emailaddress']);
    $firstname     = $con->escape($_POST['firstname']);
    $lastname      = $con->escape($_POST['lastname']);
    $userId        = $_POST['userId'];
    // validations
    $validator = new Validation();
    $usernameValidation = $validator->name('firstname')->value($firstname)->required();
    $lastnameValidation = $validator->name('lastname')->value($lastname)->required();
    $emailValidation    = $validator->name('emailaddress')->value($emailaddress)->required();
    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        foreach ($errors as $error) {
            $message .= "<p>Error: $error</p> \n";
        }
        header("location:/tassky/view/list/Users-list.php?message=" . urlencode($message));
        exit();
    } else {
        $userClass = new Users();
        $message = $userClass->updateUser($userId, $firstname, $lastname, $emailaddress);
        // return message
        header("location:/tassky/view/list/Users-list.php?message=" . urlencode($message));
        exit();
    }
}
