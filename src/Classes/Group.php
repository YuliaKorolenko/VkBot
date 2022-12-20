<?php

namespace App\Classes;

require_once 'global.php';

class Group
{
    private $conn;
    private $db_table = "`MyGroup`";
    // Columns
    public $id;
    public $name;
    public $reg_open;
    public $price;
    public $created;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        log_msg("In function create");

        $sqlQuery = "INSERT INTO 
                    " . $this->db_table . " 
                    (id, name, reg_open, price, created) 
                    VALUES ('$this->id', '$this->name' , $this->reg_open, $this->price, '$this->created');";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function find()
    {
        log_msg("In function create");

        $sqlQuery = "SELECT
                     FROM " . $this->db_table . " 
                     WHERE id = '$this->id';";

        log_msg($sqlQuery);

        $stmt = $this->conn->prepare($sqlQuery);

        if ($stmt->execute()) {
            return $stmt->rowCount();
        }

        return false;
    }

}