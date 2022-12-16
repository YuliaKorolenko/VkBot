<?php

namespace States;

use States\State;
require_once 'global.php';
require_once 'State.php';

class StartState implements State
{
  public function _do($data){
      $user_id = $data->object->message->from_id;
      $user_name = $data->response[0]->first_name;

      log_msg("sucessDo");
      $request_params = array(
          'message' => "Ваша группа, {$user_id}, вот такая! {$data->object->message->text}",
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
        return "Выбрать группу";
    }

    public function __construct()
    {
        log_msg("StartState");
    }
}