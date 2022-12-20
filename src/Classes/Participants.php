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
                    (user_id, group_id, is_creator, wish_list, is_active) 
                    VALUES ($this->user_id, '$this->group_id' , $this->is_creator, '$this->wish_list', $this->is_active);";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update(){
        log_msg("In function update participants");

        $sqlQuery = "UPDATE 
                    " . $this->db_table . " 
                    SET wish_list = '$this->wish_list'
                    WHERE user_id = $this->user_id
                    AND is_active = 1;";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function changeActive(){
        log_msg("In function update participants");

        $sqlQuery = "UPDATE 
                    " . $this->db_table . " 
                    SET is_active = 0
                    WHERE user_id = $this->user_id;";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function find(){
        log_msg("In function update participants");

        $sqlQuery = "SELECT COUNT(*) FROM
                    " . $this->db_table . " 
                    WHERE user_id = $this->user_id
                    AND group_id = '$this->group_id';";

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            log_msg("COUNT");
            $count = $stmt->fetchColumn();
            log_msg($count);
            return $count;
        }

        return -1;
    }

    public function isCreator(){
        log_msg("In function update participants");

        $sqlQuery = "SELECT is_creator
                    FROM 
                    " . $this->db_table . " 
                    WHERE user_id= $this->user_id
                    AND   group_id = '$this->group_id';";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->is_creator=$row['is_creator'];
            return $this->is_creator;
        }

        return false;
    }

}