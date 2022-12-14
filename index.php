<?php

require_once 'global.php';
include_once 'databases/database.php';
include_once 'class/group.php';


if (!isset($_REQUEST)) {
    return;
}

$confirmation_token = 'fd3c7549';

$token = 'vk1.a.EvF6oWbm7ViH2O6IfkkybNfOxMTU-RoUFV_q924BQNm6VlUFZBc1d8n25MOmdlvZWO9XEZYb5Qhd0wBf0U925JhV7SzQPiLWqrcY482o-lohC_1JJ1wQdXmHzk8D6WyQo-QRbI-R4UQYqs6OrVlq0YVxYaHDVIwu4NNLJJDvXU8obz5IcrOklGn976tGSJtrD1GQd7vikBXbUibO3MVBrQ';


$data = json_decode(file_get_contents('php://input'));


log_msg("dat = " . $data->object->message->text);

switch ($data->type) {
    case 'confirmation':
        echo $confirmation_token;
        break;
    case 'message_new':
        $user_id = $data->object->message->from_id;
        $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&access_token={$token}&v=5.103"));
        $user_name = $user_info->response[0]->first_name;

//        $database = new Database();
//        $db = $database->getConnection();
//
//        $item = new Group($db);
//        $item->id = $data->object->message->text;
//        $item->name = $data->object->message->text;
//        $item->reg_open = 1;
//        $item->price = 0;
//        $item->created = date('Y-m-d H:i:s');
//
//        if ($item->create()) {
//            log_msg("Group created successfully.");
//        } else {
//            log_msg("Group could not be created.");
//        }
//
//        log_msg("sucess5");


        $request_params = array(
            'message' => "Ваша группа, {$user_id}, вот такая! {$data->object->message->text}",
            'peer_id' => $user_id,
            'access_token' => $token,
            'keyboard' => json_encode(MAIN_KEYBOARD, JSON_UNESCAPED_UNICODE),
            'v' => '5.131',
            'random_id' => '0',
        );

        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
        echo('ok');
        break;
    case 'message_event':
        $request_params = array(
            'message' => "Message event",
            'peer_id' => $data->object->message->from_id,
            'access_token' => $token,
            'v' => '5.103',
            'random_id' => '0'
        );
        $get_params = http_build_query($request_params);
        break;
    default:
        log_msg("default");
}