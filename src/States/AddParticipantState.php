<?php

namespace App\States;

use App\Classes\Participants;
use App\Databases\Database;

class AddParticipantState implements State
{

    public function __construct()
    {
    }

    public function changeState($data)
    {
        $user_id = $data->object->message->from_id;

        $database = new Database();
        $db = $database->getConnection();

        $user = new Users($db);
        $user->id = $user_id;
        $user->state_number = $this->getName();

        if ($user->update()) {
            log_msg("User updated successfully.");
        } else {
            log_msg("User could not be updated.");
        }

        $this->_do($data);
    }

    public function _do($data)
    {
        $user_id = $data->object->message->from_id;
        $database = new Database();
        $db = $database->getConnection();

        $participant = new Participants($db);

        $participant->user_id = $user_id;
        $participant->group_id = $data->object->message->text;
        $participant->is_active = 1;
        $participant->is_creator = 0;
        $participant->wish_list = "";

        if ($participant->create()) {
            log_msg("Participant created successfully.");
        } else {
            log_msg("Participant could not be created.");
        }

        $request_params = array(
            'message' => STRING_ADD,
            'peer_id' => $user_id,
            'access_token' => BOT_TOKEN,
            'random_id' => '0',
            'keyboard' => json_encode(CREATE_KEYBOARD, JSON_UNESCAPED_UNICODE),
            'v' => '5.131',
        );

        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }

    public function getName(): string
    {
        ENTER_GROUP_STATE;
    }

    public function getPreviousName(): string
    {
        return START_STATE;
    }
}