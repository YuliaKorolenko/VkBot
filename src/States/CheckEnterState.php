<?php

namespace App\States;

use App\Classes\Group;
use App\Classes\Participants;
use App\Classes\Users;
use App\Databases\Database;

class CheckEnterState extends BaseState  implements State
{
    protected $keyboard;
    protected $phrase;

    public function changeState($data)
    {
        $this->change($data, $this->getName());
        $this->_do($data);
    }

    public function _do($data)
    {
        $database = new Database();
        $db = $database->getConnection();

        $group = new Group($db, $data->object->message->text);

        $user_id = $data->object->message->from_id;

        if ($group->find() == 1) {

            $participant =
                new Participants($db, $user_id, $data->object->message->text, 0, "", 1);

            if ($participant->find() == 0) {
                $participant->create();
                vkApiSend($user_id,RIGHT_CHECK_ENTER, ENTER_KEYBOARD);
            } else {
                if ($participant->isCreator() == 1){
                    vkApiSend($user_id, STOP_REGISTRATION, CREATE_KEYBOARD);
                    $user = new Users($db, $user_id, ENTER_FOR_CREATORS_STATE);

                    $participant->changeActiveByGroup(1);
                    if ($user->update()) {
                        log_msg("User updated successfully.");
                    } else {
                        log_msg("User could not be updated.");
                    }

                } else {
                    $this->keyboard = MAIN_KEYBOARD;
                    vkApiSend($user_id, ALREADY_IN_GROUP, MAIN_KEYBOARD);
                }
            }

        } else {
            $this->keyboard = MAIN_KEYBOARD;
            vkApiSend($user_id, WRONG_CHECKER_ENTER, MAIN_KEYBOARD);
        }

        if ($this->keyboard == MAIN_KEYBOARD) {
            $user = new Users($db, $user_id, START_STATE);

            if ($user->update()) {
                log_msg("User updated successfully.");
            } else {
                log_msg("User could not be updated.");
            }
        }
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