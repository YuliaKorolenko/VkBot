<?php

require_once 'global.php';

class Group{
    private $conn;
    private $db_table = "MyGroup";


    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        log_msg("In function create");

        $sqlQuery = "INSERT INTO 
                        ". $this->db_table ."
                    SET
                        id = 'bbbbbbbb', 
                        name = 'ojpochemy', 
                        reg_open = 1, 
                        price = 0, 
                        created = '2012-06-01 02:12:30'";

        $stmt = $this->conn->prepare($sqlQuery);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

}