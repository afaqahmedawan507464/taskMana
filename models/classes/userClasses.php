<?php

use Cartalyst\Sentinel\Native\Facades\Sentinel;

require_once('/xampp/htdocs/tassky/connection/connection.php');
// create user class 
class Users
{
    protected $firstname;
    protected $lastname;
    protected $emailaddress;
    protected $password;
    protected $userid;
    protected $roleId;

    // create new user by use sentinel
    public function newUsers($firstname, $lastname, $emailaddress, $password)
    {
        // check old Data

        // variables
        $this->firstname    = $firstname;
        $this->lastname     = $lastname;
        $this->emailaddress = $emailaddress;
        $this->password     = $password;
        // create functions
        $oldData = Sentinel::findByCredentials(['email' => $emailaddress]);
        if ($oldData) {
            return "Email Is already exists.";
        } else {
            $values = [
                'email'       => $this->emailaddress,
                'password'    => $this->password,
                'first_name'  => $this->firstname,
                'last_name'   => $this->lastname,
            ];
            $newUsers = Sentinel::registerAndActivate($values);
            if ($newUsers) {
                $user = Sentinel::createModel();
                if ($user) {
                    $setModel = Sentinel::setModel('Acme\Models\User');
                    if ($setModel) {
                        return  "User has been created successfully.";
                    } else {
                        return  "Error occured while creating the user.";
                    }
                } else {
                    return  "Error occured while creating the user.";
                }
            } else {
                return  "Error occured while creating the user.";
            }
        }
        // 
    }
    // add
    public function add($firstname, $password, $emailaddress, $lastname, $roles)
    {
        // $dba = new DatabaseManager();
        // $db = $dba->setDatabaseConnection();
        $this->firstname    = $firstname;
        $this->lastname     = $lastname;
        $this->emailaddress = $emailaddress;
        $this->password     = $password;
        $this->roleId       = $roles;
        $oldData = Sentinel::findByCredentials(['email' => $this->emailaddress]);
        if ($oldData) {
            return "Email Is already exists.";
        } else {
            $roleIds = Sentinel::findRoleById($this->roleId);
            $rolePermissions = $roleIds['permissions'];
            // echo "<pre>";
            // print_r($rolePermissions);
            // echo "</pre>";
            // die();
            // Register and activate the user
            $values = [
                'email'       => $this->emailaddress,
                'password'    => $this->password,
                'permissions' => $rolePermissions,
                'first_name'  => $this->firstname,
                'last_name'   => $this->lastname,
            ];
            $registeredUser = Sentinel::registerAndActivate($values);
            // model creation
            $createUserModel = Sentinel::createModel();
            if ($createUserModel) {
                // set models
                // Assign roles to the user
                $userId = $registeredUser->id;
                $userIds = Sentinel::findById($userId);
                $assignRoles = $roleIds->users()->attach($userIds);
                return 'User created successfully.';
            }
        }
    }
    // update users
    public function updateUser($userId, $firstname, $lastname, $emailaddress)
    {
        $this->userid       = $userId;
        $this->firstname    = $firstname;
        $this->lastname     = $lastname;
        $this->emailaddress = $emailaddress;
        $fetchUserId = Sentinel::findById($this->userid);
        if ($fetchUserId) {
            $values = [
                'email'      => $this->emailaddress,
                'first_name' => $this->firstname,
                'last_name'  => $this->lastname,
            ];
            $updateUsers = $fetchUserId->update($values);
            if ($updateUsers) {
                return "user is updated successfully";
            } else {
                return "user is updated Un-successfully";
            }
        }
    }
    // delete users
    public function removeUser($userId)
    {
        $this->userid = $userId;
        // $users = Sentinel::getUser();
        // $userId = $users->getUserId();
        $fetchUserId = Sentinel::findById($this->userid);
        if ($fetchUserId) {
            $deleteUsers = $fetchUserId->delete();
            if ($deleteUsers) {
                return "user is deleted successfully";
            } else {
                return "user is deleted Un-successfully";
            }
        }
    }
    // login function by using sentinel
    public function loginUser($emailaddress, $password)
    {
        $this->emailaddress = $emailaddress;
        $this->password     = $password;
        $values = [
            'email'      => $this->emailaddress,
            'password'   => $this->password,
        ];
        if (Sentinel::authenticate($values)) {
            $users = Sentinel::getUser();
            $userId = $users->getUserId();
            $findById = Sentinel::findById($userId);
            $login = Sentinel::loginAndRemember($findById);
            if ($login) {
                header("location:/tassky/view/dashboard/dashboard.php");
                exit();
            }
        } else {
            die("Wrong email or password");
        }
    }
    // logout function
    public function logoutUser()
    {
        if (Sentinel::check()) {
            $user = Sentinel::getUser(); // Retrieve authenticated user object

            $userId = $user->id; // Access the user's ID property
            // echo $userId;
            // die();

            $logout = Sentinel::logout($user, true);
            if ($logout) {
                header("location:/tassky/view/authenication/login.php");
                exit();
            }
        }
    }
    // find users
    public function getUsersss()
    {
        $users = [];
        $results = Sentinel::getUserRepository()->all();
        foreach ($results as $row) {
            $users[] =
                ['id' => $row['id'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'email' => $row['email']];
        }
        return $users;
    }
    // roles assigned
    public function userAssignRole($userId, $role_id)
    {
        // Ensure $userId is an integer
        $this->userid = $userId;
        $this->roleId = $role_id;
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $tasks = [];
        $tableName = 'role_users';
        $numRows = null;
        $columns = ["user_id", "role_id"];
        $oldData = $db->where('user_id', $this->userid)->where('role_id', $this->roleId)->get($tableName, $numRows, $columns);
        if (count($oldData) > 0) {
            return "This user is already assigned roles";
        } else {
            // Use the $userId directly as an integer
            $userIds = Sentinel::findById($this->userid);
            $roleIds = Sentinel::findRoleById($this->roleId);
            $assignRole = $roleIds->users()->attach($userIds);
            if (!$assignRole) {
                $roleIds = Sentinel::findRoleById($this->roleId);
                $rolePermissions = $roleIds['permissions'];
                $values = [
                    'permissions' => $rolePermissions,
                ];
                $userUpdate = Sentinel::update($userIds, $values);
                if ($userUpdate) {
                    return "roles assigned";
                } else {
                    return "roles is not assigned";
                }
            } else {
                return "roles is not assigned";
            }
        }
    }
    // find role by id
    public function findByRoleId($userId)
    {
        $this->userid = $userId;
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $role_user = [];
        $tableName = 'role_users';
        $numRows = null;
        $columns = ["user_id", "role_id"];
        $results = $db->where('user_id', $this->userid)->get($tableName, $numRows, $columns);
        if ($db->count > 0) {
            foreach ($results as $row) {
                $role_user[] = [
                    'user_id'        => $row['user_id'],
                    'role_id'        => $row['role_id'],
                ];
            }
            return $role_user;
        }
    }
}
