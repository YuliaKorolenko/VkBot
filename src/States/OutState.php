<?php

namespace App\States;

use App\Classes\Participants;
use App\Classes\Users;
use App\Databases\Database;

class OutState extends BaseState  implements State
{

    public function changeState($data)
    {
        $this->change($data, $this->getName());
        $this->_do($data);
    }

    public function _do($data)
    {

        $user_id = $data->object->message->from_id;

        $database = new Database();
        $db = $database->getConnection();

        $participant = new Participants($db, $user_id, "", 0, "", 0);

        $participant->changeActive();

        vkApiSend($user_id, STRING_OUT_STATE, MAIN_KEYBOARD);
    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }

    public function getName(): string
    {
        return OUT_STATE;
    }

    public function getPreviousNames(): array
    {
        return array(ADD_WISH_LIST_STATE);
    }
}