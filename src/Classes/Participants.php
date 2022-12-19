<?php

namespace App\Classes;

require_once 'global.php';
class Participants
{
    private $conn;

    private $db_table = "`Participants`";

    // Columns

    public $id;
    public $user_id;
    public $group_id;
    public $is_creator;
    public $wish_list;
    public $is_active;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        log_msg("In function create participants");

        $sqlQuery = "INSERT INTO 
                    " . $this->db_table . " 
                    (user_id, group_id, is_creator, wish_list, state_number) 
                    VALUES ($this->user_id, '$this->group_id' , $this->is_creator, '$this->wish_list', $this->is_active);";

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