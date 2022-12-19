<?php

namespace App\States;

use App\Classes\Users;
use App\Databases\Database;

require_once 'global.php';

class StartState implements State
{

    public function __construct()
    {
        log_msg("StartState");
    }


    public function changeState($data)
    {
        log_msg("sucessDo");
        $user_id = $data->object->message->from_id;

        $database = new Database();
        $db = $database->getConnection();

        log_msg($user_id);

        $user = new Users($db);
        $user->id = $user_id;
        $user->state_number = $this->getName();

        if ($user->create()) {
            log_msg("User created successfully.");
        } else {
            log_msg("User could not be created.");
        }

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
        return "Начать";
    }


    public function getPreviousName(): string
    {
        return "";
    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }

}