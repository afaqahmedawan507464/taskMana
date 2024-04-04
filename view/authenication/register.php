<!--
=========================================================
* Paper Dashboard 2 - v2.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/paper-dashboard-2
* Copyright 2020 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Paper Dashboard 2 by Creative Tim
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <!-- <link href="/tassky/view/theme/assets/css/bootstrap.min.css" rel="stylesheet" /> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/tassky/view/theme/assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="/tassky/view/theme/assets/demo/demo.css" rel="stylesheet" />
</head>
<?php
$message = isset($_GET['message']) ? $_GET['message'] : null;
if (isset($message)) {
    echo '<div class="alert alert-info alert-dismissible fade show px-4 d-flex justify-content-center flex-column" role="alert">';
    echo "<strong>Message:</strong> " . $message;
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

?>

<body class="px-3 py-2" style="background-color: #f4f3ef;">
    <div>
        <!-- End Navbar -->
        <div class=" content">
            <div class="row d-flex justify-content-center align-items-center py-3">
                <div class="col-8">
                    <div class="card card-user">
                        <div class="card-header">
                            <h5 class="card-title">Registeration Page</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="/tassky/controller/userController.php">
                                <div class="row px-3">
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" name="firstname" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" name="emailaddress" placeholder="Email Address">
                                        </div>
                                    </div>
                                    <div class="col-md-6 px-1">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Password">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="update ml-3">
                                        <button name="btn_register" type="submit" class="btn btn-primary btn-round">Register</button>
                                    </div>

                                </div>
                                <div class="mt-2 ml-2">
                                    <a href="../authenication/login.php" class="text-decoration-none">Login Account</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../theme/assets/js/core/jquery.min.js"></script>
    <script src="../theme/assets/js/core/popper.min.js"></script>
    <script src="../theme/assets/js/core/bootstrap.min.js"></script>
    <script src="../theme/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="../view/theme/assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../view/theme/assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../view/theme/assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="../view/theme/assets/demo/demo.js"></script>
</body>

</html>