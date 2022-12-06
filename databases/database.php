<?php
require_once 'global.php';

class Database {
    private $host = "22";
    private $database_name = "phpapidb";
    private $username = "root";
    private $password = "ubuntu";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            log_msg("Database could not be connected: " . $exception->getMessage());
        }
        return $this->conn;
    }
}