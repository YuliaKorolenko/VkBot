<?php

namespace App\States;

use App\Classes\Users;
use App\Databases\Database;

class BaseState
{
    protected $keyboard;
    protected $phrase;

    public function __construct()
    {
    }

    public function change($data, $stateName)
    {
        log_msg("INCHANGE");
        $user_id = $data->object->message->from_id;

        $database = new Database();
        $db = $database->getConnection();

        $user = new Users($db, $user_id, $stateName);

        if ($user->update()) {
            log_msg("WishList change successfully.");
        } else {
            log_msg("WishList change not be updated.");
        }
    }
}