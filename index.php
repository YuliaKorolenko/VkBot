<?php


use Actions\StartState;
use States\CollectStates;

require_once 'global.php';
include_once 'databases/database.php';
include_once 'class/group.php';
include_once 'keyboards.php';
include_once 'names.php';


callback_events();

function callback_events()
{
    if (!isset($_REQUEST)) {
        return;
    }


    $data = json_decode(file_get_contents('php://input'));
    $collectStates = new CollectStates(
        new StartState()
    );


    log_msg("dat = " . $data->object->message->text);

    switch ($data->type) {
        case 'confirmation':
            echo CONFIRMATION_TOKEN;
            break;
        case 'message_new':

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
            log_msg("sucessMes");
            $state = $collectStates->getState($data->object->message->text);
            $state->do;
            log_msg("sucessMes2");


            echo('ok');
            break;
        case 'message_event':
            $request_params = array(
                'message' => "Message event, {$data->object->message->payload} {$data->object->payload}",
                'peer_id' => $data->object->message->from_id,
                'access_token' => BOT_TOKEN,
                'v' => '5.131',
                'random_id' => '0'
            );
            $get_params = http_build_query($request_params);
            file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
            break;
        default:
            log_msg("default");
    }
}