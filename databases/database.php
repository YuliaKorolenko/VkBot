<?php
require_once 'global.php';

class Database {
    private $host = "109.120.183.78";
    private $database_name = "event";
    private $username = "root";
    private $password = "root";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            log_msg("sucess1");
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            log_msg("sucess2");
            $this->conn->exec("set names utf8");
            log_msg("sucess3");
        }catch(PDOException $exception){
            log_msg("Database could not be connected: " . $exception->getMessage());
        }
        return $this->conn;
    }
}