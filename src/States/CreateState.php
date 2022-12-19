<?php

namespace App\States;

use App\Classes\Users;
use App\Databases\Database;

class CreateState implements State
{

    public function __construct()
    {
    }

    public function _do($data)
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

        $request_params = array(
            'message' => STRING_CREATE,
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
        // TODO: Implement getName() method.
        return "Создать группу";
    }
}