<?php

namespace App\States;

use App\Classes\Participants;
use App\Classes\Users;
use App\Databases\Database;

class AddWishListState implements State
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
        $user->state_number=$this->getName();

        if ($user->update()) {
            log_msg("Add user updated successfully.");
        } else {
            log_msg("Add user not be updated.");
        }

        $this->_do($data);
    }

    public function _do($data)
    {
        $user_id = $data->object->message->from_id;

        $database = new Database();

        $db = $database->getConnection();

        $participant = new Participants();
        $participant->user_id = $user_id;
        $participant->wish_list = $data->object->message->from_id;
        $participant->is_active = 1;

        $participant->update($db);

        $request_params = array(
            'message' => STRING_WISH_LIST,
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
        return "Добавить пользователя";
    }

    public function getPreviousName(): string
    {
        return "Добавить группу";
    }
}