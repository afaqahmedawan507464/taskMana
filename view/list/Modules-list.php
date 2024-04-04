<?php
require_once('/xampp/htdocs/tassky/models/classes/rolesClasses.php');
require_once('/xampp/htdocs/tassky/models/classes/moduleClasses.php');
?>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/tassky/view/theme/assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="/tassky/view/theme/assets/demo/demo.css" rel="stylesheet" />
</head>
<?php

use Cartalyst\Sentinel\Native\Facades\Sentinel;

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
                            <div class="py-2">
                                <a class="mx-1 btn-sm btn-outline-primary text-decoration-none btn-round" href="/tassky/view/dashboard/dashboard.php">Back</a>
                            </div>
                            <h5 class="card-title">Module List</h5>
                        </div>
                        <div class="card-body">
                            <div class="py-2">
                                <a class="mx-1 btn-sm btn-outline-success text-decoration-none btn-round" data-bs-toggle="modal" data-bs-target="#rolesModal">Add</a>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" style="width:10%;">#</th>
                                        <th scope="col" class="text-start" style="width:90%;">Module Name</th>
                                        <!-- <th scope="col" class="text-center" style="width:50%;">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $actions = new Modules();
                                    $actionController = $actions->getModule();
                                    ?>
                                    <?php if (is_array($actionController) && count($actionController) > 0) : ?>
                                        <?php foreach ($actionController as $users) : ?>
                                            <tr>
                                                <th class="text-center" scope="row" style="width:10%;"><?php echo $users['id'] ?></th>
                                                <td class="text-start" style="width:40%;"><?php echo $users['name'] ?></td>
                                                
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <p>No roles found.</p>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="rolesModal" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Modules</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/tassky/controller/moduleController.php">
                        <div class="col-12 px-1 py-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Module Name</label>
                                <input type="text" class="form-control mt-2" name="moduleName" placeholder="demo Module">
                            </div>
                        </div>
                        <div class="d-flex justify-content-start align-items-center mt-3">
                            <button name="btn_createModule" class="btn btn-outline-primary btn-round mx-2" type="submit">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- edit -->
    <?php
    if (!empty($actionController)) {
        foreach ($actionController as $users) {
    ?>
            <div class="modal fade" id="edit_role_<?php echo $users['id']; ?>" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Module</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/tassky/controller/moduleController.php">
                                <div class="input-block mb-3 d-none">
                                    <label class="col-form-label">Role Id</label>
                                    <input class="form-control" type="text" name="moduleId" value="<?php echo $users['id']; ?>">
                                </div>
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Module Name </label>
                                    <input class="form-control" type="text" name="moduleName" value="<?php echo $users['name']; ?>">
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-outline-primary btn-round" name="btn_updateModule" type=" submit">Change</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
    <!-- delete -->
    <?php
    if (!empty($actionController)) {
        foreach ($actionController as $users) {
    ?>
            <div class="modal fade" id="delete_role_<?php echo $users['id']; ?>" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form method="post" action="/tassky/controller/moduleController.php">
                            <div class="modal-body">
                                <div class="input-block mb-3 d-none">
                                    <label class="col-form-label">Role Id</label>
                                    <input class="form-control" type="text" name="moduleId" value="<?php echo $users['id']; ?>">
                                </div>
                                <h5>Are you sure to delete this "<?php echo $users['name']; ?>" ? </h5>
                                <div class="d-flex justify-content-end align-items-center mt-3">
                                    <button class="btn btn-outline-success mx-2 btn-round" data-bs-dismiss="modal" type="button">No</button>
                                    <button class="btn btn-outline-danger btn-round" name="btn_removeModule" type=" submit">Yes</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
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