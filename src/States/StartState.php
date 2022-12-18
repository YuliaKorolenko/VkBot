<?php

namespace App\States;

use App\Classes\Users;
use App\Databases\Database;
use Couchbase\User;

require_once 'global.php';

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

        $database = new Database();
        $db = $database->getConnection();

        $user = new Users($db);
        $user->id = $user_id;
        $user->group_id = 'empty';
        $user->is_creator = 0;
        $user->state_number = $this->getName();
        $user->vish_list = 'empty';

        if ($user->create()) {
            log_msg("User created successfully.");
        } else {
            log_msg("User could not be created.");
        }

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