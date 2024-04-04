<?php
require_once('/xampp/htdocs/tassky/connection/connection.php');

use Cartalyst\Sentinel\Native\Facades\Sentinel;

class Tasks
{

    public $taskname;
    public $description;
    public $db;
    public $userId;
    public $date;
    public $time;
    public $reminder;
    public $task_id;
    public function setTasks($taskname, $description, $date, $time, $reminder)
    {
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $this->taskname =  $taskname;
        $this->description = $description;
        $this->db = $db;
        $this->date = $date;
        $this->time = $time;
        $this->reminder = $reminder;
        $tablename = 'tasks';
        $numRows = null;
        $columns = ["id", "Name", "Description", "Date", "Time", "Reminder", "userId"];
        $results = $db->where('Name', $this->taskname)->get($tablename, $numRows, $columns);
        if (count($results) > 0) {
            return "This task name is already availible";
        } else {
            if (Sentinel::check()) {
                $userId = Sentinel::getUser()->id;
            }
            $insertData = array(
                'Name'           => $this->taskname,
                'Description'    => $this->description,
                'Date'           => $this->date,
                'Time'           => $this->time,
                'Reminder'       => $this->reminder,
                'userId'         => $userId,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            );
            $newtasks = $db->insert($tablename, $insertData);
            if ($newtasks) {
                return "Success: Task Created";
            } else {
                return "Task not created";
            }
        }
    }
    // 
    public function getTasks()
    {
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $tasks = [];
        $tableName = 'tasks';
        $numRows = null;
        $columns = ["id", "Name", "Description", "Date", "Time", "Reminder", "userId"];
        // Define the condition to fetch tasks for a specific user
        // Fetch tasks from the database based on the condition
        $results = $db->get($tableName, $numRows, $columns);
        if ($db->count > 0) {
            foreach ($results as $row) {
                $tasks[] = [
                    'id'          => $row['id'],
                    'Name'        => $row['Name'],
                    'Description' => $row['Description'],
                    'Date'        => $row['Date'],
                    'Time'        => $row['Time'],
                    'Reminder'    => $row['Reminder'],
                    'userId'      => $row['userId'],
                ];
            }
            return $tasks;
        } else {
            return "Not data is not founded";
        }
    }
    // 
    public function deleteTasks($task_id)
    {
        $this->task_id = $task_id;
        // 
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $tableName = 'tasks';
        $numRows = null;
        $columns = ["id"];
        $results = $db->where('id', $this->task_id)->get($tableName, $numRows, $columns);
        if (count($results) > 0) {
            $delete = $db->where('id', $this->task_id)->delete($tableName);
            if ($delete) {
                return "Deleted Operation Is Successfully";
            } else {
                return "Deleted Operation Is Un-Successfully";
            }
        } else {
            return "Nott Data Founded";
        }
    }
    // 
    public function updateTasks($taskname, $description, $date, $time, $reminder, $tasksId)
    {
        $dba = new DatabaseManager();
        $db = $dba->setDatabaseConnection();
        $this->taskname =  $taskname;
        $this->description = $description;
        $this->db = $db;
        $this->date = $date;
        $this->time = $time;
        $this->reminder = $reminder;
        $this->task_id = $tasksId;
        // 

        // check conditions

        $tableName = 'tasks';
        $numRows = null;
        $columns = ["id"];
        $results = $db->where('id', $this->task_id)->get($tableName, $numRows, $columns);
        $counts = count($results);
        if (Sentinel::check()) {
            $userId = Sentinel::getUser()->id;
        }
        if ($counts > 0) {
            $updateData = array(
                'Name'           => $this->taskname,
                'Description'    => $this->description,
                'Date'           => $this->date,
                'Time'           => $this->time,
                'Reminder'       => $this->reminder,
                'userId'         => $userId,
                'updated_at'     => date('Y-m-d H:i:s'),
            );

            // $update = $db->where('id', $this->roleId)->update($tableName,  $updateData);
            $update = $db->where('id', $this->task_id)->update($tableName, $updateData);
            if ($update) {
                return "Updated Operation Is Un-successfully";
            } else {
                return "Updated Operation Is Un-successfully";
            }
        } else {
            return "Nott Data Founded";
        }
    }
}
