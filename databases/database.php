<?php
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
            log_msg("sucess1");
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            log_msg("sucess2");
            $this->conn->exec("set names utf8");
            log_msg("sucess3");
        }catch(PDOException $exception){
            log_msg("Database could not be connected: " . $exception->getMessage());
        }
        log_msg("sucess4");
        return $this->conn;
    }
}