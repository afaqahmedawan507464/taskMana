<?php

use Cartalyst\Sentinel\Native\Facades\Sentinel;

require_once('/xampp/htdocs/tassky/connection/connection.php');
class Actions
{
    protected $actionname;
    protected $actionslug;
    protected $actionid;
    // show all actions
    public function showActions()
    {
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $tableName = "actions";
        $numRows = null;
        $columns = ["id", "name", "slug"];
        $results = $db->get($tableName, $numRows, $columns);
        $roleIds = [];
        if (count($results) > 0) {
            foreach ($results as $row) {
                $roleIds[] =
                    ['id' => $row['id'], 'name' => $row['name'], 'slug' => $row['slug']];
            }
            return $roleIds;
        } else {
            return "not roles founded";
        }
    }
    // create
    public function addActions($actionName, $actionSlug)
    {
        $this->actionname = $actionName;
        $this->actionslug = $actionSlug;
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $tableName = 'actions';
        $numRows = null;
        $columns = ["id", "name", "slug"];
        $results = $db->get($tableName, $numRows, $columns);
        // if ($results) {
        //     return "This Name Is Al-ready Availible";
        // } else {
        if ($results['name'] == $this->actionname) {
            return "This Name Is Al-ready Availible";
        } else {
            $insertData = [
                'name'       => $this->actionname,
                'slug'       => $this->actionslug,
                'created_at' => date('Y-m-d H:i'),
                'updated_at' => date('Y-m-d H:i'),
            ];
            $newAction = $db->insert($tableName, $insertData);
            if ($newAction) {
                return "Action Is Created Successfully";
            } else {
                return "Action Is Created Un-Successfully";
            }
        }
    }
    // update
    public function updateActions($actionId, $actionName, $actionSlug)
    {
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $this->actionname = $actionName;
        $this->actionslug = $actionSlug;
        $this->actionid   = $actionId;
        $tableName = 'actions';
        $numRows = null;
        $columns = ["id", "name", "slug"];
        $results = $db->where('id', $this->actionid)->get($tableName, $numRows, $columns);
        if (count($results) > 0) {
            $insertData = [
                'name'       => $this->actionname,
                'slug'       => $this->actionslug,
                'updated_at' => date('Y-m-d H:i'),
            ];
            $updateAction = $db->where('id', $this->actionid)->update($tableName, $insertData);
            if ($updateAction) {
                return "Action Is Updated Successfully";
            } else {
                return "Action Is Updated Un-Successfully";
            }
        } else {
            return "Not Data Founded";
        }
    }
    // delete
    public function removeActions($actionId)
    {
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $this->actionid   = $actionId;
        $tableName = 'actions';
        $numRows = null;
        $columns = ["id", "name", "slug"];
        $results = $db->where('id', $this->actionid)->get($tableName, $numRows, $columns);
        if (count($results) > 0) {
            $deleteAction = $db->where('id', $this->actionid)->delete($tableName);
            if ($deleteAction) {
                return "Action Is Removed Successfully";
            } else {
                return "Action Is Removed Un-Successfully";
            }
        } else {
            return "Not Data Founded";
        }
    }
}
