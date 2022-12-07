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


log_msg("dat = " . $data->type);

switch ($data->type) {
    case 'confirmation':
        echo $confirmation_token;
        break;
    case 'message_new':
        $user_id = $data->object->message->from_id;
        $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&access_token={$token}&v=5.103"));
        $user_name = $user_info->response[0]->first_name;

        $database = new Database();
        log_msg("new Data");
        $db = $database->getConnection();
        log_msg("Connection");

        $item = new Group($db);
//        $data = json_decode(file_get_contents("php://input"));
        $item->id = "llllllll";
        $item->name = "message";
        $item->reg_open = 1;
        $item->price = 0;
        $item->created = date('Y-m-d H:i:s');

        if ($item->create()) {
            log_msg("Group created successfully.");
        } else {
            log_msg("Group could not be created.");
        }

        log_msg("sucess5");

        $request_params = array(
            'message' => "Ваша группа, {$user_name}, вот такая!",
            'peer_id' => $user_id,
            'access_token' => $token,
            'v' => '5.103',
            'random_id' => '0'
        );
        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
        echo('ok');
        break;
    default:
        log_msg("default");
}