<?php

namespace App\States;

use App\Classes\Participants;
use App\Classes\Users;
use App\Databases\Database;

class AddWishListState extends BaseState implements State
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
        $participant =
            new Participants($db, $user_id, "", 0, $data->object->message->text, 1);

        $participant->findGroupId();
        $participant->isCreator();
        $participant->update();

        if ($participant->is_creator == 1) {
            vkApiSend($user_id, STRING_WISH_LIST, CREATE_KEYBOARD);
        } else {
            vkApiSend($user_id, STRING_WISH_LIST, ENTER_KEYBOARD);
        }
    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }

    public function getName(): string
    {
        return ADD_WISH_LIST_STATE;
    }

    public function getPreviousNames(): array
    {
        return array(ADD_GROUP, CHECK_ENTER_STATE);
    }
}