<?php

require_once 'global.php';

class Group
{
    private $conn;
    private $db_table = "MyGroup";


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        log_msg("In function create");

        $sqlQuery = "INSERT INTO 
                    " . $this->db_table . " 
                    (`id`, `name`, `reg_open`, `price`, `created`) 
                    VALUES ('aaaass', 'Santa', 0, 0, '2012-05-01 02:12:30');";

        log_msg("sql");

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            log_msg("true");
            return true;
        }

        log_msg("false");
        return false;
    }

}