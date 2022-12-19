<?php

namespace App\States;

use App\Classes\Group;
use App\Databases\Database;

class AddGroupState implements State
{

    public function __construct()
    {
    }

    public function _do($data)
    {
        $database = new Database();
        $db = $database->getConnection();

        $item = new Group($db);
        $item->id = $data->object->message->text;
        $item->name = "empty";
        $item->reg_open = 1;
        $item->price = 0;
        $item->created = date('Y-m-d H:i:s');

        if ($item->create()) {
            log_msg("Group created successfully.");
        } else {
            log_msg("Group could not be created.");
        }
    }

    public function getName(): string
    {
        return "";
    }

    public function getPreviousName(): string
    {
        return "Создать группу";
    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }
}