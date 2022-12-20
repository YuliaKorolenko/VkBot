<?php

namespace App\States;

use App\Classes\Users;
use App\Databases\Database;

class BaseState
{
    protected $keyboard;
    protected $phrase;

    public function __construct($keyboard)
    {
        $this->keyboard = $keyboard;
    }

    public function change($data, $stateName)
    {
        $user_id = $data->object->message->from_id;

        $database = new Database();
        $db = $database->getConnection();

        $user = new Users($db);
        $user->id = $user_id;
        $user->state_number=$this->$stateName;

        if ($user->update()) {
            log_msg("WishList change successfully.");
        } else {
            log_msg("WishList change not be updated.");
        }
    }
}