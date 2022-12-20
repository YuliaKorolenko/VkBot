<?php

namespace App\States;

use App\Classes\Users;
use App\Databases\Database;

require_once 'global.php';

class StartState extends BaseState implements State
{

    public function __construct()
    {
        log_msg("StartState");
    }


    public function changeState($data)
    {
        $this->change($data, $this->getName());
        $this->_do($data);
    }

    public function _do($data)
    {
        $user_id = $data->object->message->from_id;

        $request_params = array(
            'message' => STRING_START,
            'peer_id' => $user_id,
            'access_token' => BOT_TOKEN,
            'random_id' => '0',
            'keyboard' => json_encode(MAIN_KEYBOARD, JSON_UNESCAPED_UNICODE),
            'v' => '5.131',
        );

        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
    }


    public function getName(): string
    {
        return START_STATE;
    }


    public function getPreviousNames(): array
    {
        return array(OUT_STATE, START_STATE, START_STATE);
    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }

}