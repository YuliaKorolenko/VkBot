<?php

namespace App\Classes;

class Users
{
    private $conn;

    private $db_table = "`Users`";

    // Columns

    public $id;
    public $group_id;
    public $is_creator;
    public $vish_list;
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
                    (group_id, is_creator, vish_list, state_number) 
                    VALUES ('$this->group_id' , $this->is_creator, '$this->vish_list', '$this->state_number');";

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