
<?php
require_once('/xampp/htdocs/tassky/models/classes/taskReminderClasses.php');

$localhost     = 'localhost';
$datausername  = 'root';
$password      = null;
$databasename  = 'afaq2327';

$taskReminder = new TaskReminder();
$taskReminder->sendReminderEmails($localhost, $datausername, $password, $databasename);
?>