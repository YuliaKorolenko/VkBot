<?php

namespace App\States;

use App\Classes\Group;
use App\Classes\Participants;
use App\Classes\Users;
use App\Databases\Database;

class AddGroupState extends BaseState implements State
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

        $item = new Group($db, $data->object->message->text, 1);

        if ($item->create()) {
            log_msg("Group created successfully.");
        } else {
            log_msg("Group could not be created.");
        }

        $participant =
            new Participants($db, $user_id, $data->object->message->text, 1, "", 1);

        if ($participant->create()) {
            log_msg("Participant created successfully.");
        } else {
            log_msg("Participant could not be created.");
        }

        vkApiSend($user_id, STRING_ADD, CREATE_KEYBOARD);
    }

    public function getName(): string
    {
        return ADD_GROUP;
    }

    public function getPreviousNames(): array
    {
        return array(CREATE_GROUP);
    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }


}