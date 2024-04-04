<?php
require_once('/xampp/htdocs/tassky/vendor/autoload.php');
require_once('/xampp/htdocs/tassky/connection/MysqliDb.php');

// Import the necessary classes
use Dotenv\Dotenv;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Database\Capsule\Manager as Capsule;
// Include the composer autoload file
// require 'vendor/autoload.php';

// Setup a new Eloquent Capsule instance
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'tassky',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
]);

$capsule->bootEloquent();

class Database
{
    // Properties
    public $localhost;
    public $datausername;
    public $password;
    public $databasename;
    public $port;
    public $prefix;
    public $charset;

    // Constructor
    public function __construct()
    {
        // Load environment variables from .env file
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../connection/');
        $dotenv->load();
        $port = 3306;
        $prefix = '';
        $charset = 'utf8';
        // Set database connection parameters
        $this->localhost = $_ENV['DB_HOST'];
        $this->datausername = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->databasename = $_ENV['DB_NAME'];
        $this->port = $port;
        $this->prefix = $prefix;
        $this->charset = $charset;
    }

    // Set database connection function
    public function setDatabaseConnection()
    {
        // Set additional parameters

        // Connect to the database
        $db = new MysqliDb([
            'host' => $this->localhost,
            'username' => $this->datausername,
            'password' => $this->password,
            'db' => $this->databasename,
            'port' => $this->port,
            'prefix' => $this->prefix,
            'charset' => $this->charset,
        ]);

        return $db;
    }

    // Disconnect database connection
    public function disconnectDatabaseConnection($db)
    {
        $db->disconnect();
    }
}
class DatabaseManager extends Database
{
}
