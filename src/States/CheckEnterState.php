<?php

namespace App\States;

use App\Classes\Group;
use App\Classes\Users;
use App\Databases\Database;

class CheckEnterState implements State
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
        $database = new Database();
        $db = $database->getConnection();

        $group = new Group($db);
        $group->id = $data->object->message->text;
        $user_id = $data->object->message->from_id;

        if ($group->find() == 1) {
            $request_params = array(
                'message' => RIGHT_CHECK_ENTER,
                'peer_id' => $user_id,
                'access_token' => BOT_TOKEN,
                'random_id' => '0',
                'keyboard' => json_encode(ENTER_KEYBOARD, JSON_UNESCAPED_UNICODE),
                'v' => '5.131',
            );

            log_msg("After find");
            $add = new AddParticipantState();
            $add->changeState($data);

        } else {
            $request_params = array(
                'message' => WRONG_CHECKER_ENTER,
                'peer_id' => $user_id,
                'access_token' => BOT_TOKEN,
                'random_id' => '0',
                'keyboard' => json_encode(MAIN_KEYBOARD, JSON_UNESCAPED_UNICODE),
                'v' => '5.131',
            );
        }

        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }

    public function getName(): string
    {
        return CHECK_ENTER_STATE;
    }

    public function getPreviousNames(): array
    {
        return array(ENTER_GROUP_STATE, CHECK_ENTER_STATE);
    }
}