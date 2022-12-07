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
                        id = 'bbbaaaaa', 
                        name = 'oj', 
                        reg_open = 0, 
                        price = 0, 
                        created = '2012-06-01 02:12:30'";

        log_msg("sql");

        $stmt = $this->conn->prepare($sqlQuery);

        if($stmt->execute()){
            log_msg("true");
            return true;
        }

        log_msg("false");
        return false;
    }

}