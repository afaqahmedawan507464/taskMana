<?php
require_once('/xampp/htdocs/tassky/connection/connection.php');
require_once('/xampp/htdocs/tassky/models/classes/moduleClasses.php');
require_once('/xampp/htdocs/tassky/models/classes/actionClasses.php');
require_once('/xampp/htdocs/tassky/models/classes/rolesClasses.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Roles List
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
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
                <div class="col-10">
                    <div class="card card-user">
                        <div class="card-header">
                            <div class="mt-2 ml-2 me-3">
                                <a href="/tassky/view/list/Modules-list.php" class="text-decoration-none btn btn-outline-primary btn-round">Back</a>
                            </div>
                            <div>
                                <?php
                                if (isset($_GET['id'])) {
                                    $roleId = '';
                                    // Retrieve the ID from the URL parameter
                                    $roleId = $_GET['id'];
                                    // echo $roleId;
                                }
                                ?>
                                <h5 class="card-title text-center">Assign Role Access</h5>
                            </div>

                        </div>
                        <div class="card-body">

                            <form method="post" action="/tassky/controller/moduleController.php">
                                <div class="row px-3">
                                    <div class="col-12 px-1 d-none">
                                        <div class="form-group">
                                            <label>Roles</label>
                                            <input type="text" class="form-control" name="roleId" value="<?php echo $roleId; ?>">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center align-items-start pb-3 px-3">
                                        <?php
                                        $roldid = $roleId;
                                        $modules = new Modules();
                                        $moduleData = $modules->getModuleUsingById(
                                            $roldid
                                        );
                                        ?>
                                        <!-- ======================================== -->
                                        <?php if (is_array($moduleData) && count($moduleData) > 0) : ?>
                                            <?php foreach ($moduleData as $actionControllersz) : ?>
                                                <!-- ======================================== -->
                                                <?php
                                                $actions = new Roles();
                                                $actionController = $actions->showRoles();
                                                ?>
                                                <!-- ======================================== -->
                                                <!-- ======================================== -->
                                                <!-- ======================================== -->
                                                <!-- show all actions -->
                                                <div class="d-flex justify-content-center align-items-center flex-wrap px-3">
                                                    <!--  -->
                                                    <?php if (is_array($actionController) && count($actionController) > 0) : ?>
                                                        <?php foreach ($actionController as $actionControllersyz) : ?>
                                                            <div class="d-flex justify-content-center align-items-center py-2 px-2 checkbox">
                                                                <label style="text-transform: capitalize;" for="" class="mx-2"><?php echo $actionControllersyz['name'] ?></label>
                                                                <input class="py-1" type="checkbox" name="actions[]" value="<?php echo $actionControllersz['slug'] . '.' . $actionControllersyz['name'] ?>" class="mx-2">
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <p>No role found.</p>
                                                    <?php endif; ?>
                                                    <!--  -->
                                                </div>
                                                <!-- show all actions -->
                                                <!-- ======================================== -->
                                                <!-- ======================================== -->
                                                <!-- show all module -->
                                                <div class="mt-2" style="border:1px dotted lightgray;width:100%;"></div>
                                                <!-- ======================================== -->
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <p>No module found.</p>
                                        <?php endif; ?>
                                        <!-- ======================================== -->

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="update ml-3">
                                        <button name="btn_assign" type="submit" class="btn btn-outline-primary btn-round">Assign</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="/tassky/view/theme/assets/js/core/jquery.min.js"></script>
    <script src="/tassky/view/theme/assets/js/core/popper.min.js"></script>
    <script src="/tassky/view/theme/assets/js/core/bootstrap.min.js"></script>
    <script src="/tassky/view/theme/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="../theme/assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../theme/assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/tassky/view/theme/assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="/tassky/view/theme/assets/demo/demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>