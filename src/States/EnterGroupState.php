<?php

namespace App\States;

use App\Classes\Group;
use App\Classes\Participants;
use App\Classes\Users;
use App\Databases\Database;

class EnterGroupState extends BaseState implements State
{


    public function changeState($data)
    {
        $this->change($data, $this->getName());
        $this->_do($data);
    }

    public function _do($data)
    {
        $user_id = $data->object->message->from_id;

        vkApiSend($user_id, ENTER_SECRET_NAME, CREATE_KEYBOARD);
    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }

    public function getName(): string
    {
        return ENTER_GROUP_STATE;
    }

    public function getPreviousNames(): array
    {
        return array(START_STATE, OUT_STATE);
    }
}