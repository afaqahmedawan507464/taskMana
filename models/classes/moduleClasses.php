<?php

use Cartalyst\Sentinel\Native\Facades\Sentinel;

require_once('/xampp/htdocs/tassky/connection/connection.php');
class Modules
{
    // variables
    public $module_name;
    public $module_slug;
    protected $module_id;
    // create Modules
    public function createModule($module_name, $module_slug)
    {
        $this->module_name = $module_name;
        $this->module_slug = $module_slug;
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $tableName = 'module';
        $numRows = null;
        $columns = ["id", "name", "slug"];
        $oldData = $db->get($tableName, $numRows, $columns);
        if ($oldData['name'] == $this->module_name) {
            return "Module Is already exists.";
        } else {
            $values = [
                'name' => $this->module_name,
                'slug' => $this->module_slug,
            ];
            $tableName = "module";
            $dba = new DatabaseManager();
            $con = $dba->setDatabaseConnection();
            // 
            $insert = $con->insert($tableName, $values);
            if ($insert) {
                $module = Sentinel::createModel();
                if ($module) {
                    $setModule = Sentinel::setModel('Acme\Models\Module');
                    if ($setModule) {
                        return  "Module has been created successfully.";
                    }
                } else {
                    return  "Error occured while creating the Module.";
                }
            } else {
                return  "Error occured while creating the Module.";
            }
        }
    }
    // 
    public function getModule()
    {
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $modules = [];
        $tableName = 'module';
        $numRows = null;
        $columns = ["id", "name", "slug"];
        $results = $db->get($tableName, $numRows, $columns);
        if ($db->count > 0) {
            foreach ($results as $row) {
                $modules[] =
                    ['id' => $row['id'], 'name' => $row['name'], 'slug' => $row['slug']];
            }
            return $modules;
        }
    }
    // 
    public function getModuleUsingById($moduleId)
    {
        $this->module_id = $moduleId;
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $modules = [];
        $tableName = 'module';
        $numRows = null;
        $columns = ["id", "name", "slug"];
        $results = $db->where('id', $this->module_id)->get($tableName, $numRows, $columns);
        if ($db->count > 0) {
            foreach ($results as $row) {
                $modules[] =
                    ['id' => $row['id'], 'name' => $row['name'], 'slug' => $row['slug']];
            }
            return $modules;
        }
    }
    // update
    public function updateActions($module_id, $module_name, $module_slug)
    {
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $this->module_name = $module_name;
        $this->module_slug = $module_slug;
        $this->module_id  = $module_id;
        $tableName = 'module';
        $numRows = null;
        $columns = ["id", "name", "slug"];
        $results = $db->where('id', $this->module_id)->get($tableName, $numRows, $columns);
        if (count($results) > 0) {
            $insertData = [
                'name'       => $this->module_name,
                'slug'       => $this->module_slug,
                'updated_at' => date('Y-m-d H:i'),
            ];
            $updateAction = $db->where('id', $this->module_id)->update($tableName, $insertData);
            if ($updateAction) {
                return "Module Is Updated Successfully";
            } else {
                return "Module Is Updated Un-Successfully";
            }
        } else {
            return "Not Data Founded";
        }
    }
    // delete
    public function removeActions($module_id)
    {
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $this->module_id  = $module_id;
        $tableName = 'module';
        $numRows = null;
        $columns = ["id", "name", "slug"];
        $results = $db->where('id', $this->module_id)->get($tableName, $numRows, $columns);
        if (count($results) > 0) {
            $deleteAction = $db->where('id', $this->module_id)->delete($tableName);
            if ($deleteAction) {
                return "Module Is Removed Successfully";
            } else {
                return "Module Is Removed Un-Successfully";
            }
        } else {
            return "Not Data Founded";
        }
    }
    // 
    public function setRolesPermission($permissionname, $roleId)
    {
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $this->module_id = $roleId;

        // Retrieve the role by its ID
        $tableName = 'module';
        $numRows = null;
        $columns = ["id", "name", "slug"];
        $role = $db->where('id', $this->module_id)->get($tableName, $numRows, $columns);


        // Check if the role exists
        if ($role) {
            foreach ($permissionname as $perms) {
                $parts = explode('.', $perms);
                if (count($parts) == 2) {
                    $entity = $parts[0]; //module
                    $action = $parts[1]; // action
                    // find module ID by model name using $entity
                    $roleId = $db->where('slug', $action)->getValue('roles', 'id');
                    // find action ID by action name using $action
                    // $actionId = $db->where('slug', $action)->getValue('actions', 'id');
                    // Insert data into action_modules table using $moduleId and $actionId
                    $tablename = 'module_roles';
                    $insertData = [
                        'module_id'  => $this->module_id,
                        'role_id'    => $roleId,
                        // 'roleId'     => $this->roleid,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    $db->insert($tablename, $insertData);
                }
            }

            // // Add permissions to the role
            // foreach ($permissionname as $permName) {
            //     $role->addPermission($permName, true);
            // }
            // // Save the role
            // $role->save();
            return "Successfully Updated Permissions.";
        } else {
            // Role with the provided ID was not found
            return "Role with ID {$this->module_id} not found.";
        }
    }
}
