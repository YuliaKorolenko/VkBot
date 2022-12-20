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

        $participant = new Participants($db);
        $participant->user_id = $user_id;
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

        for ($i = 1; $i < $n; $i++) {
            $santa = $participants[$arr[$i]];
            log_msg($santa);
            $ward = $participants[$arr[($i + 1) % $n]];
            log_msg($ward);
            $request_params = array(
                'message' => LINK . $ward["user_id"] . STOP . $ward["wish_list"],
                'peer_id' => $santa["user_id"],
                'access_token' => BOT_TOKEN,
                'random_id' => '0',
                'keyboard' => json_encode($this->keyboard, JSON_UNESCAPED_UNICODE),
                'v' => '5.131',
            );
            $get_params = http_build_query($request_params);
            file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
        }

        $this->change($data, START_STATE);

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
        return array(ADD_WISH_LIST_STATE, START_STATE);
    }
}