<?php

namespace App\States;

use App\Classes\Group;
use App\Classes\Participants;
use App\Classes\Users;
use App\Databases\Database;

class AddGroupState implements State
{

    public function changeState($data)
    {
        $user_id = $data->object->message->from_id;

        $database = new Database();
        $db = $database->getConnection();

        $user = new Users($db);
        $user->id = $user_id;
        $user->state_number=$this->getName();

        if ($user->update()) {
            log_msg("User updated successfully.");
        } else {
            log_msg("User could not be updated.");
        }

        $this->_do($data);
    }
    public function __construct()
    {
    }

    public function _do($data)
    {
        $user_id = $data->object->message->from_id;
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

        $participant = new Participants($db);
        $participant->user_id=$user_id;
        $participant->group_id=$data->object->message->text;
        $participant->is_active=1;
        $participant->is_creator=1;
        $participant->wish_list="";

        if ($participant->create()) {
            log_msg("Participant created successfully.");
        } else {
            log_msg("Participant could not be created.");
        }


        $request_params = array(
            'message' =>  STRING_ADD,
            'peer_id' => $user_id,
            'access_token' => BOT_TOKEN,
            'random_id' => '0',
            'keyboard' => json_encode(CREATE_KEYBOARD, JSON_UNESCAPED_UNICODE),
            'v' => '5.131',
        );

        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
    }

    public function getName(): string
    {
        return "Добавить группу";
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