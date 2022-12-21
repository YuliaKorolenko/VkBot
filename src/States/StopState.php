<?php

namespace App\States;

use App\Classes\Participants;
use App\Databases\Database;

class StopState extends BaseState implements State
{

    public function changeState($data)
    {
        $this->change($data, $this->getName());
        $this->_do($data);
    }

    public function _do($data)
    {
//        1    6    4    2     3     5
//        u1   u2   u3   u4    u5    u6
//        u1 -> u4 -> u5 -> u3 ->  u6
        $user_id = $data->object->message->from_id;

        $database = new Database();
        $db = $database->getConnection();

        $participant = new Participants($db, $user_id, "", 0, "", 0);


        $participant->findGroupIdByCreator();
        log_msg($participant->group_id);
        $n = $participant->findPartCount();
        log_msg($n);

        $participants = $participant->getParticipants();

        $arr = array($n);
        for ($i = 0; $i < $n; $i++) {
            $arr[$i] = $i;
        }
        shuffle($arr);

        for ($i = 0; $i < $n; $i++) {
            $santa = $participants[$arr[$i]];
            $santa_user_id = intval($santa["user_id"]);

            $ward = $participants[$arr[($i + 1) % $n]];
            $ward_user_id = intval($ward["user_id"]);

            vkApiSend($santa_user_id, LINK . $ward_user_id . STOP . $ward["wish_list"], MAIN_KEYBOARD);

            $santa_participant = new Participants($db, $santa_user_id, "", 0, "", 0);
            $santa_participant->is_active = 0;
            $santa_participant->changeActive(0);

            $this->change($data, START_STATE);
        }





    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }

    public function getName(): string
    {
        return STOP_STATE;
    }

    public function getPreviousNames(): array
    {
        return array(ADD_WISH_LIST_STATE, ENTER_FOR_CREATORS_STATE);
    }
}