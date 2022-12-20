<?php

namespace App\States;

use App\Classes\Group;
use App\Classes\Participants;
use App\Classes\Users;
use App\Databases\Database;

class CheckEnterState implements State
{
    protected $keyboard;
    protected $phrase;

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
            log_msg("Groupright");

            $participant = new Participants($db);
            $participant->id = $user_id;
            $participant->group_id = $data->object->message->text;
            $participant->is_active = 1;
            $participant->wish_list = "";
            $participant->is_creator = 0;

            if ($participant->find() == 0) {
                log_msg("newPart");
                $participant->create();
                $this->keyboard = ENTER_KEYBOARD;
                $this->phrase = RIGHT_CHECK_ENTER;
            } else {
                log_msg("oldPart");
                $this->keyboard = MAIN_KEYBOARD;
                $this->phrase = ALREADY_IN_GROUP;
            }

        } else {
            $this->keyboard = MAIN_KEYBOARD;
            $this->phrase = WRONG_CHECKER_ENTER;
        }

        $request_params = array(
            'message' => $this->phrase,
            'peer_id' => $user_id,
            'access_token' => BOT_TOKEN,
            'random_id' => '0',
            'keyboard' => json_encode($this->keyboard, JSON_UNESCAPED_UNICODE),
            'v' => '5.131',
        );

        if ($this->keyboard == MAIN_KEYBOARD) {
            $user = new Users($db);
            $user->id = $user_id;
            $user->state_number = START_STATE;

            if ($user->update()) {
                log_msg("User updated successfully.");
            } else {
                log_msg("User could not be updated.");
            }
        }

        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
    }

    public
    function _error($data)
    {
        // TODO: Implement _error() method.
    }

    public
    function getName(): string
    {
        return CHECK_ENTER_STATE;
    }

    public
    function getPreviousNames(): array
    {
        return array(ENTER_GROUP_STATE, CHECK_ENTER_STATE);
    }
}