<?php

namespace App\databases;

use PDO;
use PDOException;

require_once 'global.php';

class Database {
    private $host = "127.0.0.1";
    private $database_name = "event";
    private $username = "root";
    private $password = "root";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            log_msg("Database could not be connected: " . $exception->getMessage());
        }
        log_msg("sucess4");
        return $this->conn;
    }
}