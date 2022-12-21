<?php

require_once 'global.php';
require_once 'keyboards.php';
require_once 'names.php';

function vkApiSend($peer_id, $message, $keyboard){
    $request_params = array(
        'message' =>$message,
        'peer_id' => $peer_id,
        'access_token' => BOT_TOKEN,
        'random_id' => '0',
        'keyboard' => json_encode($keyboard, JSON_UNESCAPED_UNICODE),
        'v' => '5.131',
    );

    $get_params = http_build_query($request_params);
    file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
}
