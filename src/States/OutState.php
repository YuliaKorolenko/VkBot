<?php

namespace App\States;

use App\Classes\Participants;
use App\Classes\Users;
use App\Databases\Database;

class OutState implements State
{

    public function __construct()
    {
    }

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

        $participant = new Participants($db);
        $participant->user_id = $user_id;
        $participant->is_active = 0;

        $participant->changeActive();


        $request_params = array(
            'message' => STRING_OUT_STATE,
            'peer_id' => $user_id,
            'access_token' => BOT_TOKEN,
            'random_id' => '0',
            'keyboard' => json_encode(MAIN_KEYBOARD, JSON_UNESCAPED_UNICODE),
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
        return OUT_STATE;
    }

    public function getPreviousNames(): array
    {
        return array(ADD_WISH_LIST_STATE);
    }
}