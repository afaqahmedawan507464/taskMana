<?php

use Cartalyst\Sentinel\Native\Facades\Sentinel;

require_once('/xampp/htdocs/tassky/connection/connection.php');
// create user class 
class Roles
{
    protected $roleid;
    protected $rolename;
    protected $roleslug;
    // create role function
    public function createRole($rolename, $roleslug)
    {
        $this->rolename = $rolename;
        $this->roleslug = $roleslug;
        $roleData = Sentinel::getRoleRepository()->where('name', $this->rolename)->get();
        if (count($roleData) > 0) {
            return "this role name is  already exist";
        } else {
            $values = [
                'slug' => $this->roleslug,
                'name' => $this->rolename,
            ];
            $role = Sentinel::getRoleRepository()->createModel()->create($values);
            if ($role) {
                $setRole = Sentinel::getRoleRepository()->setModel('Acme\Models\Role');
                if ($setRole) {
                    return "role is created Successfully";
                } else {
                    return "role is created Un-successfully";
                }
            }
        }
    }
    // show all roles
    public function showRoles()
    {
        $roleIds = [];
        $results = Sentinel::getRoleRepository()->all();
        if ($results) {
            foreach ($results as $row) {
                $roleIds[] =
                    ['id' => $row['id'], 'name' => $row['name'], 'permissions' => $row['permissions']];
            }
            return $roleIds;
        } else {
            return "not roles founded";
        }
    }
    // 
    public function showSelectedRoles($roleid)
    {
        $this->roleid = $roleid;
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $tasks = [];
        $tableName = 'roles';
        $numRows = null;
        $columns = ["id", "slug", "name", "permissions"];
        $results = $db->where('id', $this->roleid)->get($tableName, $numRows, $columns);
        if ($results) {
            foreach ($results as $row) {
                $tasks[] = [
                    'slug'             => $row['slug'],
                    'name'             => $row['name'],
                    'permissions'      => $row['permissions'],
                ];
            }
            return $tasks;
        } else {
            return "No roles found";
        }
    }

    // 
    public function updateRoles($name, $slug, $roleId)
    {
        $this->rolename = $name;
        $this->roleslug = $slug;
        $this->roleid = $roleId;
        // 

        // check conditions

        $result = Sentinel::getRoleRepository()->where(
            'id',
            $this->roleid
        )->get();
        $counts = count($result);
        if ($counts > 0) {
            $updateData = array(
                'name' => $this->rolename,
                'slug' => $this->roleslug,
            );
            $update = Sentinel::getRoleRepository()->where(
                'id',
                $this->roleid
            )->update($updateData);
            if ($update) {
                return "Data is updated";
            } else {
                return "Data is not updated";
            }
        } else {
            return "Nott Data Founded";
        }
    }
    // 
    public function deleteRoles($roleId)
    {
        $this->roleid = $roleId;
        // 
        $result = Sentinel::getRoleRepository()->where(
            'id',
            $this->roleid
        )->get();
        $counts = count($result);
        if ($counts > 0) {
            $delete = Sentinel::getRoleRepository()->where(
                'id',
                $this->roleid
            )->delete();
            if ($delete) {
                return "Data is deleted";
            } else {
                return "Data is not deleted";
            }
        } else {
            return "Nott Data Founded";
        }
    }
    // 
    public function setRolesPermission($permissionname, $roleId)
    {
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $this->roleid = $roleId;
        $role = Sentinel::findRoleById($this->roleid);
        if ($role) {
            $role->permissions = [];
            $role->save();

            foreach ($permissionname as $perms) {
                $parts = explode('.', $perms);
                if (count($parts) == 2) {
                    $entity = $parts[0]; // model
                    $action = $parts[1]; // action
                    $moduleId = $db->where('slug', $entity)->getValue('module', 'id');
                    $actionId = $db->where('slug', $action)->getValue('actions', 'id');
                    // Check if the entry already exists in action_modules table
                    $tableName = 'action_modules';
                    $numRows = null;
                    $columns = ["module_id", "action_id", "role_id"];

                    // Check if the entry already exists
                    $existingEntry = $db->where('module_id', $moduleId)
                        ->where('action_id', $actionId)
                        ->where('role_id', $this->roleid)
                        ->get($tableName, $numRows, $columns);

                    if (count($existingEntry) == 0) {
                        // Insert new entry if it doesn't exist
                        $insertData = [
                            'module_id'  => $moduleId,
                            'action_id'  => $actionId,
                            'role_id'    => $this->roleid,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                        $db->insert($tableName, $insertData);
                    } else {
                        // Update entry if it exists
                        foreach ($existingEntry as $entry) {
                            // Check if the action_id already exists for the module_id and role_id
                            if ($entry['action_id'] == $actionId) {
                                $updateData = [
                                    'action_id'  => $actionId,
                                    'role_id'    => $this->roleid,
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ];
                                $db->where('module_id', $moduleId)
                                    ->where('action_id', $actionId)
                                    ->where('role_id', $this->roleid)
                                    ->update($tableName, $updateData);
                                break; // No need to continue looping once the update is done
                            }
                        }
                    }
                }
            }
            foreach ($permissionname as $permName) {
                $role->addPermission($permName, true);
            }
            // role table permissions access is 
            // latest permissions in this role
            $updatePerm = $role->permissions;
            $dba = new DatabaseManager();
            $db = $dba->setDatabaseConnection();
            $tableName = 'role_users';
            $numRows = null;
            $columns = ["user_id", "role_id"];
            $results = $db->where('role_id', $this->roleid)->get($tableName, $numRows, $columns);
            foreach ($results as $result) {
                $userId = $result['user_id'];
                $findUsers = Sentinel::findById($userId);
                $userPermissions = $findUsers->permissions;
                $update = [
                    'permissions' => $updatePerm,
                ];
                $updatePermissionByUser = Sentinel::update($findUsers, $update);
            }
            // Save the role
            $role->save();
            return "Successfully Updated Permissions.";
        }
    }
    // 

}
