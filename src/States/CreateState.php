<?php

namespace App\States;

use App\Classes\Users;
use App\Databases\Database;

class CreateState extends BaseState implements State
{
    public function changeState($data)
    {
        $this->change($data, $this->getName());
        $this->_do($data);
    }


    public function _do($data)
    {
        $user_id = $data->object->message->from_id;

        vkApiSend($user_id, STRING_CREATE, CREATE_KEYBOARD);
    }

    public function getName(): string
    {
        return CREATE_GROUP;
    }

    public function getPreviousNames(): array
    {
        return array(START_STATE, OUT_STATE);
    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }
}