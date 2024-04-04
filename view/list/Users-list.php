<?php
require_once('/xampp/htdocs/tassky/models/classes/userClasses.php');
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
                            <h5 class="card-title">Users List</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            if (Sentinel::check()) {
                                $user = Sentinel::getUser();
                                if ($user->hasAccess(['users.create'])) { ?>
                                    <div class="py-2">
                                        <a class="mx-1 btn-sm btn-outline-success text-decoration-none btn-round" href="#" data-bs-toggle="modal" data-bs-target="#rolesModal">Add User</a>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="py-2">
                                        <a class="mx-1 btn-sm btn-outline-success text-decoration-none btn-round" href="#" data-bs-toggle="modal" data-bs-target="#rolesModal" style="pointer-events: none;cursor: not-allowed;opacity: 0.6;">Add User</a>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" style="width:10%;">#</th>
                                        <th scope="col" class="text-start" style="width:35%;">Name</th>
                                        <th scope="col" class="text-start" style="width:35%;">Email</th>
                                        <th scope="col" class="text-center" style="width:20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $users_list = new Users();
                                    $userData =  $users_list->getUsersss();
                                    ?>
                                    <?php if (is_array($userData) && count($userData) > 0) : ?>
                                        <?php foreach ($userData as $users) : ?>
                                            <tr>
                                                <th class="text-center" scope="row" style="width:10%;"><?php echo $users['id'] ?></th>
                                                <td class="text-start" style="width:35%;"><?php echo $users['first_name'] . '  ' . $users['last_name'] ?></td>
                                                <td class="text-start" style="width:35%;"><?php echo $users['email'] ?></td>
                                                <td class="text-start" style="width:20%;">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <?php
                                                        if (Sentinel::check()) {
                                                            $user = Sentinel::check();
                                                            if ($user->hasAccess(['users.update'])) { ?>
                                                                <a class="mx-1 btn-sm btn-outline-warning text-decoration-none btn-round " href="#" data-bs-toggle="modal" data-bs-target="#edit_role_<?php echo $users['id']; ?>">Edit</a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="mx-1 btn-sm btn-outline-warning text-decoration-none btn-round " href="#" data-bs-toggle="modal" data-bs-target="#edit_role_<?php echo $users['id']; ?>" style="pointer-events: none;cursor: not-allowed;opacity: 0.6;">Edit</a>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        <?php
                                                        if (Sentinel::check()) {
                                                            $user = Sentinel::check();
                                                            if ($user->hasAccess(['users.delete'])) { ?>
                                                                <a class="mx-1 btn-sm btn-outline-danger text-decoration-none btn-round " data-bs-toggle="modal" data-bs-target="#delete_role_<?php echo $users['id']; ?>">Remove</a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="mx-1 btn-sm btn-outline-danger text-decoration-none btn-round " data-bs-toggle="modal" data-bs-target="#delete_role_<?php echo $users['id']; ?>" style="pointer-events: none;cursor: not-allowed;opacity: 0.6;">Remove</a>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        <!--  -->
                                                        <?php
                                                        $userPermission = Sentinel::findById($users['id'])->permissions;
                                                        if (empty($userPermission)) { ?>
                                                            <a href="" class="mx-1 btn-sm btn-outline-info text-decoration-none btn-round " data-bs-toggle="modal" data-bs-target="#roles_role_<?php echo $users['id']; ?>">Role</a>
                                                        <?php } else { ?>
                                                            <a href="" class="mx-1 btn-sm btn-outline-info text-decoration-none btn-round " data-bs-toggle="modal" data-bs-target="#roles_role_<?php echo $users['id']; ?>" style="pointer-events: none;cursor: not-allowed;opacity: 0.6;">Role</a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
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
    <!-- add -->
    <div class="modal fade" id="rolesModal" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Roles</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/tassky/controller/userController.php">
                        <div class="input-block mb-3">
                            <label class="col-form-label">First Name </label>
                            <input type="text" class="form-control" name="firstname" placeholder="First Name">
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Last Name </label>
                            <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Email address </label>
                            <input type="email" class="form-control" name="emailaddress" placeholder="Email Address">
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Password </label>
                            <input type="password" class="form-control" name="password" placeholder="******">
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Roles </label>
                            <select name="roleId" id="roleId" class="form-control">
                                <option value="">Select Role</option>
                                <?php
                                $roleClasses = '';
                                $roleClasses = new Roles();
                                $getRoles = $roleClasses->showRoles();
                                ?>
                                <?php if (is_array($getRoles) && count($getRoles) > 0) : ?>
                                    <?php foreach ($getRoles as $roles) : ?>
                                        <option value="<?php echo $roles['id'] ?>"><?php echo $roles['name'] ?></option>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p>No roles found.</p>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-start align-items-center mt-3">
                            <button name="btn_createRoles" class="btn btn-outline-primary mx-2 btn-round" type="submit">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- delete -->
    <?php
    if (!empty($userData)) {
        foreach ($userData as $users) {
    ?>
            <div class="modal fade" id="delete_role_<?php echo $users['id']; ?>" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form method="post" action="/tassky/controller/userController.php">
                            <div class="modal-body">
                                <div class="input-block mb-3 d-none">
                                    <label class="col-form-label">User Id</label>
                                    <input class="form-control" type="text" name="userId" value="<?php echo $users['id']; ?>">
                                </div>
                                <h5>Are you sure to delete this "<?php echo $users['first_name']; ?>" ? </h5>
                                <div class="d-flex justify-content-end align-items-center mt-3">
                                    <button class="btn btn-outline-success mx-2 btn-round" data-bs-dismiss="modal" type="button">No</button>
                                    <button class="btn btn-outline-danger btn-round" name="btn_removeUser" type=" submit">Yes</button>
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
    <!-- edit -->
    <?php
    if (!empty($userData)) {
        foreach ($userData as $users) {
    ?>
            <div class="modal fade" id="edit_role_<?php echo $users['id']; ?>" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/tassky/controller/userController.php">
                                <div class="input-block mb-3 d-none">
                                    <label class="col-form-label">Role Id</label>
                                    <input class="form-control" type="text" name="userId" value="<?php echo $users['id']; ?>">
                                </div>
                                <div class="input-block mb-3">
                                    <label class="col-form-label">First Name </label>
                                    <input type="text" class="form-control" name="firstname" placeholder="First Name" value="<?php echo $users['first_name']; ?>">
                                </div>
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Last Name </label>
                                    <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="<?php echo $users['last_name']; ?>">
                                </div>
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Email address </label>
                                    <input type="email" class="form-control" name="emailaddress" placeholder="Email Address" value="<?php echo $users['email']; ?>">
                                </div>
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Roles </label>

                                    <select name="roleId" id="roleId" class="form-control">
                                        <option value="">Select Role</option>

                                    </select>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-outline-primary btn-round" name="btn_updateUser" type=" submit">Change</button>
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
    <!-- role asssign -->
    <?php
    if (!empty($userData)) {
        foreach ($userData as $users) {
    ?>
            <div class="modal fade" id="roles_role_<?php echo $users['id']; ?>" tabindex="-1" aria-labelledby="rolesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign Role ( <?php echo $users['first_name'] . '  ' . $users['last_name'] ?> ) </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/tassky/controller/userController.php">
                                <div class="input-block mb-3 d-none">
                                    <label class="col-form-label">User Id</label>
                                    <input class="form-control" type="text" name="userId" value="<?php echo $users['id']; ?>">
                                </div>
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Roles </label>

                                    <select name="userRoles" id="userRoles" class="form-control">
                                        <option value="">Select Role</option>
                                        <?php
                                        $roleClasses = '';
                                        $roleClasses = new Roles();
                                        $getRoles = $roleClasses->showRoles();
                                        ?>
                                        <?php if (is_array($getRoles) && count($getRoles) > 0) : ?>
                                            <?php foreach ($getRoles as $roles) : ?>
                                                <option value="<?php echo $roles['id'] ?>"><?php echo $roles['name'] ?></option>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <p>No roles found.</p>
                                        <?php endif; ?>

                                    </select>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-outline-primary btn-round" name="btn_assignroles" type=" submit">Assign Role</button>
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