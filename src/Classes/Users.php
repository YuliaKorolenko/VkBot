<?php

namespace App\Classes;

require_once 'global.php';

class Users
{
    private $conn;

    private $db_table = "`Users`";

    // Columns
    public $user_id;
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
                    (user_id, state_number) 
                    VALUES ($this->user_id, '$this->state_number');";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            log_msg("true");
            return true;
        }

        log_msg("false");
        return false;
    }

}