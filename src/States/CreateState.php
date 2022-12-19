<?php

namespace App\States;

class CreateState implements State
{

    public function __construct()
    {
    }

    public function _do($data)
    {
        $user_id = $data->object->message->from_id;

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