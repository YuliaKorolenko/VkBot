<?php


use States\CollectStates;
use States\StartState;
use States\State;

require_once 'global.php';
require_once 'databases/database.php';
require_once 'class/group.php';
require_once 'keyboards.php';
require_once 'names.php';
require_once 'States/CollectStates.php';
require_once 'States/StartState.php';
require_once 'States/State.php';


callback_events();

function callback_events()
{
    if (!isset($_REQUEST)) {
        return;
    }

    log_msg("here");

    $data = json_decode(file_get_contents('php://input'));

    $collectStates = new CollectStates(
        new StartState()
    );

    log_msg("sucсess");
    $state = $collectStates->getState("Войти в группу");
    if ($state != null) {
        $state->_do();
    } else {
        log_msg("State is null");
    }

    log_msg("sucessMes2");

    log_msg("after collect");

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