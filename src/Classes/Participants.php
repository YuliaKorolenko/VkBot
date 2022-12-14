<?php

namespace App\Classes;

use PDO;

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

    public function __construct($db, $user_id, $group_id, $is_creator, $wish_list, $is_active)
    {
        $this->conn = $db;
        $this->user_id = $user_id;
        $this->group_id = $group_id;
        $this->is_creator = $is_creator;
        $this->wish_list = $wish_list;
        $this->is_active = $is_active;
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

    public function update()
    {
        log_msg("In function update participants");

        $sqlQuery = "UPDATE 
                    " . $this->db_table . " 
                    SET wish_list = '$this->wish_list'
                    WHERE user_id = $this->user_id
                    AND is_active = 1
                    AND group_id = '$this->group_id';";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function changeActive($active_number)
    {
        log_msg("In function update participants");

        $sqlQuery = "UPDATE 
                    " . $this->db_table . " 
                    SET is_active = $active_number
                    WHERE user_id = $this->user_id;";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function changeActiveByGroup($active_number)
    {
        log_msg("In function update participants");

        $sqlQuery = "UPDATE 
                    " . $this->db_table . " 
                    SET is_active = $active_number
                    WHERE user_id = $this->user_id
                    AND group_id = '$this->group_id';";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function find()
    {
        log_msg("In function update participants");

        $sqlQuery = "SELECT COUNT(*) FROM
                    " . $this->db_table . " 
                    WHERE user_id = $this->user_id
                    AND group_id = '$this->group_id';";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            log_msg("COUNT");
            $count = $stmt->fetchColumn();
            log_msg($count);
            return $count;
        }

        return -1;
    }

    public function isCreator()
    {
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
            $this->is_creator = $row['is_creator'];
            return $this->is_creator;
        }

        return false;
    }

    public function findGroupId()
    {
        log_msg("In function findGroup");

        $sqlQuery = "SELECT group_id
                    FROM 
                    " . $this->db_table . " 
                    WHERE user_id= $this->user_id
                    AND   is_active = 1;";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->group_id = $row['group_id'];
            log_msg("true");
            return true;
        }

        log_msg(false);
        return false;
    }


    public function getParticipants()
    {
        log_msg("In function findGroup");

        $sqlQuery = "SELECT 
                    user_id, wish_list
                    FROM 
                    " . $this->db_table . " 
                    WHERE group_id= '$this->group_id';";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);




    }

    public function findGroupIdByCreator()
    {
        log_msg("In function findGroup");

        $sqlQuery = "SELECT group_id
                    FROM 
                    " . $this->db_table . " 
                    WHERE user_id= $this->user_id
                    AND   is_creator = 1
                    AND   is_active  = 1;";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->group_id = $row['group_id'];
            log_msg($this->group_id);
            return true;
        }



        log_msg(false);
        return false;
    }

    public function findPartCount()
    {
        log_msg("In function update participants");

        $sqlQuery = "SELECT COUNT(*) FROM
                    " . $this->db_table . " 
                    WHERE group_id = '$this->group_id';";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            log_msg("COUNT");
            $count = $stmt->fetchColumn();
            log_msg($count);
            return $count;
        }

        return -1;
    }



}