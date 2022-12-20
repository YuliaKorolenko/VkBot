<?php

namespace App\States;

use App\Classes\Group;
use App\Classes\Participants;
use App\Classes\Users;
use App\Databases\Database;

class EnterGroupState implements State
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

        $request_params = array(
            'message' => ENTER_SECRET_NAME,
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
        return ENTER_GROUP_STATE;
    }

    public function getPreviousNames(): array
    {
        return array(START_STATE);
    }
}