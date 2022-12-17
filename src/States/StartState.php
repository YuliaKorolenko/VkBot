<?php

namespace App\States;

require_once 'global.php';
require_once 'App\Answers.php';

class StartState implements State
{

    public function __construct()
    {
        log_msg("StartState");
    }

    public function _do($data)
    {
        log_msg("sucessDo");
        $user_id = $data->object->message->from_id;
        $user_name = $data->response[0]->first_name;

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
        return "Начать";
    }


}