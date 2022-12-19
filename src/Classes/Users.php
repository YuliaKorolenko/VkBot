<?php

namespace App\Classes;

use PDO;

require_once 'global.php';

class Users
{
    private $conn;

    private $db_table = "`Users`";

    // Columns
    public $id;
    public $state_number;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        log_msg("In function create users");

        $sqlQuery = "INSERT INTO 
                    " . $this->db_table . " 
                    (id, state_number) 
                    VALUES ($this->id, '$this->state_number');";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update()
    {
        $sqlQuery = "UPDATE 
                    " . $this->db_table . " 
                    SET state_number = '$this->state_number'
                    WHERE id = $this->id;";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            return true;
        }

        return false;

    }

    public function getNumberState()
    {
        $sqlQuery = "SELECT state_number
                    FROM 
                    " . $this->db_table . " 
                    WHERE id= $this->id;";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);



        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->state_number=$row['state_number'];
            return true;
        }

        return false;
    }

}