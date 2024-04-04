<?php

use Cartalyst\Sentinel\Native\Facades\Sentinel;

require_once('/xampp/htdocs/tassky/models/classes/userClasses.php');
require_once('/xampp/htdocs/tassky/models/classes/taskClasses.php');
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
                            <h5 class="card-title">Task List</h5>
                        </div>
                        <div class="card-body">
                            <!-- check permssions is tasks.create:true is -->
                            <?php
                            if (Sentinel::check()) {
                                $user = Sentinel::getUser();
                                if ($user->hasAccess(['tasks.create'])) { ?>
                                    <div class="py-2">
                                        <a class="mx-1 btn-sm btn-outline-success text-decoration-none btn-round" href="#" data-bs-toggle="modal" data-bs-target="#add_role">Add Tasks</a>
                                    </div> <?php
                                        } else {
                                            ?>
                                    <div class="py-2">
                                        <a class="mx-1 btn-sm btn-outline-success text-decoration-none btn-round" href="#" data-bs-toggle="modal" data-bs-target="#add_role" style="pointer-events: none;cursor: not-allowed;opacity: 0.6;">Add Tasks</a>
                                    </div>
                            <?php
                                        }
                                    }
                            ?>
                            <?php
                            $tasks = "";
                            $userId = "";
                            if (Sentinel::check()) {
                                $userId = Sentinel::getUser()->id;
                            } else {
                                echo '0';
                            }
                            $tasksData = new Tasks();
                            $allTasks = $tasksData->getTasks($userId);
                            if (isset($allTasks)) {
                                $tasks = array_filter($allTasks, function ($task) use ($userId) {
                                    return $task['userId'] == $userId;
                                });

                                if (!empty($tasks)) {
                            ?>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            <tr>
                                                <th class="text-center" scope="col" style="width:5%;">id</th>
                                                <th class="text-center" scope="col" style="width:25%;">Task Name</th>
                                                <th class="text-center" scope="col" style="width:20%;">Date</th>
                                                <th class="text-center" scope="col" style="width:10%;">Time</th>
                                                <th class="text-center" scope="col" style="width:20%;">Reminder</th>
                                                <th class="text-center" scope="col" style="width:20%;">Action</th>
                                            </tr>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($tasks as $task) : ?>
                                                <tr>
                                                    <td class="text-center" scope="row" style="width:5%;">
                                                        <?php echo $task['id'] ?>
                                                    </td>
                                                    <td class="text-center" scope="row" style="width:25%;">
                                                        <?php echo $task['Name'] ?>
                                                    </td>

                                                    <td class="text-center" scope="row" style="width:10%;">
                                                        <?php echo date('M d, Y', strtotime($task['Date'])); ?>
                                                    </td>
                                                    <td class="text-center" scope="row" style="width:20%;">
                                                        <?php
                                                        $timestamp = strtotime($task['Time']);
                                                        $formattedTime = date('h:i A', $timestamp);
                                                        echo $formattedTime;
                                                        ?>
                                                    </td>
                                                    <td class="text-center" scope="row" style="width:20%;">
                                                        <?php echo $task['Reminder'] == 1 ? "Yes" : "No"; ?>
                                                    </td>
                                                    <td class="text-center" scope="row" style="width:20%;">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <?php
                                                            if (Sentinel::check()) {
                                                                $user = Sentinel::check();
                                                                if ($user->hasAccess(['tasks.update'])) { ?>
                                                                    <a class="mx-1 btn-sm btn-outline-warning text-decoration-none btn-round " href="#" data-bs-toggle="modal" data-bs-target="#edit_role_<?php echo $task['id']; ?>">Edit</a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a class="mx-1 btn-sm btn-outline-warning text-decoration-none btn-round " href="#" data-bs-toggle="modal" data-bs-target="#edit_role_<?php echo $task['id']; ?>" style="pointer-events: none;cursor: not-allowed;opacity: 0.6;">Edit</a>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <?php
                                                            if (Sentinel::check()) {
                                                                $user = Sentinel::check();
                                                                if ($user->hasAccess(['tasks.delete'])) { ?>
                                                                    <a class="mx-1 btn-sm btn-outline-danger text-decoration-none btn-round " href="#" data-bs-toggle="modal" data-bs-target="#delete_role_<?php echo $task['id']; ?>">Remove</a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a class="mx-1 btn-sm btn-outline-danger text-decoration-none btn-round " href="#" data-bs-toggle="modal" data-bs-target="#delete_role_<?php echo $task['id']; ?>" style="pointer-events: none;cursor: not-allowed;opacity: 0.6;">Remove</a>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <p class="text-center text-danger">No tasks found.</p>
                                <?php }
                            } else { ?>
                                <p class="text-center text-danger">No tasks found.</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- add-->
    <div class="modal fade" id="add_role" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/tassky/controller/taskController.php">
                        <div class="col-12 px-1">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Task Name</label>
                                <input type="text" class="form-control" placeholder="Ex, taskname" name="taskname">
                            </div>
                        </div>
                        <div class="col-12 px-1">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" class="form-control" placeholder="Ex, taskname" name="date">
                            </div>
                        </div>
                        <div class="col-12 px-1">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Reminder</label>
                                <select name="taskReminder" id="taskReminder" class="form-control">
                                    <option value="">Select Tasks</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 px-1">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Time</label>
                                <input type="time" class="form-control" placeholder="Ex, taskname" name="time">
                            </div>
                        </div>
                        <div class="col-12 px-1">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="taskDescription" id="taskDescription" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-outline-primary btn-round" name="btn_tasks" type=" submit">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- edit -->
    <?php
    if (!empty($tasks)) {
        foreach ($tasks as $task) {
    ?>
            <div class="modal fade" id="edit_role_<?php echo $task['id']; ?>" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/tassky/controller/taskController.php">
                                <div class="input-block mb-3 d-none">
                                    <label class="col-form-label">Role Id</label>
                                    <input class="form-control" type="text" name="taskId" value="<?php echo $task['id']; ?>">
                                </div>
                                <div class="col-12 px-1">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Task Name</label>
                                        <input type="text" class="form-control" placeholder="Ex, taskname" name="taskname" value="<?php echo $task['Name']; ?>">
                                    </div>
                                </div>
                                <div class="col-12 px-1">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" class="form-control" placeholder="Ex, taskname" name="date" value="<?php echo $task['Date']; ?>">
                                    </div>
                                </div>
                                <div class="col-12 px-1">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Reminder</label>
                                        <select name="taskReminder" id="taskReminder" class="form-control">

                                            <?php
                                            if ($task['Reminder'] == 1) {
                                            ?>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            <?php } ?>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 px-1">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Time</label>
                                        <input type="time" class="form-control" placeholder="Ex, taskname" name="time" value="<?php echo $task['Time']; ?>">
                                    </div>
                                </div>
                                <div class="col-12 px-1">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="taskDescription" id="taskDescription" cols="30" rows="10" class="form-control"><?php echo $task['Description']; ?></textarea>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-outline-primary btn-round" name="updateTasks" type=" submit">Change</button>
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
    if (!empty($tasks)) {
        foreach ($tasks as $task) {
    ?>
            <div class="modal fade" id="delete_role_<?php echo $task['id']; ?>" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form method="post" action="/tassky/controller/taskController.php">
                            <div class="modal-body">
                                <div class="input-block mb-3 d-none">
                                    <label class="col-form-label">Tasks Id</label>
                                    <input class="form-control" type="text" name="tasksId" value="<?php echo $task['id'] ?>">
                                </div>
                                <h5>Are you sure to delete this "<?php echo $task['Name']; ?>" ? </h5>
                                <div class="d-flex justify-content-end align-items-center mt-3">
                                    <button class="btn btn-outline-primary mx-2 btn-round" data-bs-dismiss="modal" type="button">No</button>
                                    <button class="btn btn-outline-danger btn-round" name="removeTasks" type="submit">Yes</button>
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