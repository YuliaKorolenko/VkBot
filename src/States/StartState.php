<?php

namespace App\States;

use App\Classes\Users;
use App\Databases\Database;

require_once 'global.php';

class StartState extends BaseState implements State
{
    public function changeState($data)
    {
        $this->change($data, $this->getName());
        $this->_do($data);
    }

    public function _do($data)
    {
        $user_id = $data->object->message->from_id;
        vkApiSend($user_id, STRING_START, MAIN_KEYBOARD);
    }


    public function getName(): string
    {
        return START_STATE;
    }


    public function getPreviousNames(): array
    {
        return array(OUT_STATE, START_STATE, START_STATE);
    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }

}