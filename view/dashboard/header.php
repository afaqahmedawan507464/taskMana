<?php
require_once('/xampp/htdocs/tassky/connection/connection.php');
// require_once('../model/classes/taskClass.php');
require_once('/xampp/htdocs/tassky/models/classes/moduleClasses.php');
// require_once('../model/classes/rolesClass.php');
// session_start();
// if (isset($_SESSION['id'])) {
//     $userId = $_SESSION['id'];
// } else {
//     echo "<script>window.open('/task-managment-system/view/index.php','_self')</script>";
// }
// $newUsers = isset($_GET['newUsers']) ? $_GET['newUsers'] : null;
$message = isset($_GET['message']) ? $_GET['message'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/tassky/view/theme/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/tassky/view/theme/assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Paper Dashboard 2 by Creative Tim
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="/tassky/view/theme/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/tassky/view/theme/assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="/tassky/view/theme/assets/demo/demo.css" rel="stylesheet" />
</head>
<?php

use Cartalyst\Sentinel\Native\Facades\Sentinel;

if (isset($newUsers)) {
    echo '<div class="alert alert-info alert-dismissible fade show px-4 d-flex justify-content-center flex-column" role="alert">';
    echo "<strong>Message:</strong> " . $newUsers;
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
} else if (isset($message)) {
    echo '<div class="alert alert-info alert-dismissible fade show px-4 d-flex justify-content-center flex-column" role="alert">';
    echo "<strong>Message:</strong> " . $message;
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
} else {
}
?>

<body class="px-3 py-3" style="background-color: #f4f3ef" ;>
    <div class="main-panel">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-transparent">
            <div class="container-fluid">
                <div class="collapse navbar-collapse justify-content-end" id="navigation">
                    <ul class="navbar-nav">
                        <?php
                        $moduleName = array();
                        $modules = new Modules();
                        $moduleController = $modules->getModule();

                        foreach ($moduleController as $moduleControllers) {
                            $moduleName = $moduleControllers['name']; // Assuming you want to store the name in an array
                        ?>
                            <li class="nav-item btn-rotate dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <p class="px-2" style="font-size:12px;"><?php echo $moduleName; ?></p>
                                    <p>
                                        <span class="d-lg-none d-md-block px-2"><?php echo $moduleName; ?></span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right px-2 py-3" aria-labelledby="navbarDropdownMenuLink3">
                                    <a href="../list/<?php echo $moduleName; ?>-list.php" class="dropdown-item"><?php echo $moduleName; ?> list</a>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                        <li class="nav-item btn-rotate dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <p class="px-2" style="font-size:12px;">Modules</p>
                                <p>
                                    <span class="d-lg-none d-md-block px-2">Modules</span>
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right px-2 py-3" aria-labelledby="navbarDropdownMenuLink3">
                                <a href="../list/Modules-list.php" class="dropdown-item">Modules list</a>
                            </div>
                        </li>
                        <li class="nav-item btn-rotate dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <p class="px-2" style="font-size:12px;"><?php echo Sentinel::getUser()->first_name; ?></p>
                                <p>
                                    <span class="d-lg-none d-md-block px-2"><?php echo Sentinel::getUser()->first_name; ?></span>
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right px-2 py-3" aria-labelledby="navbarDropdownMenuLink3">
                                <form method="post" action="/tassky/controller/userController.php">
                                    <button class="dropdown-item" name="btn_logout" type="submit">Logout</button>
                                </form>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->