<?php


use App\States\CollectStates;
use App\States\StartState;

require_once 'global.php';
require_once 'keyboards.php';
require_once 'names.php';

require __DIR__ . '/vendor/autoload.php';


callback_events();
new CollectStates();

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
    $state = $collectStates->getState("Начать");
    if ($state != null) {
        $state->_do($data);
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


            echo('ok');
            break;
        case 'message_event':
            $user_id = $data->object->message->from_id;
            $user_name = $data->response[0]->first_name;

            $request_params = array(
                'message' => "Message event, {$user_id}, вот такая! {$data->object->message->text}",
                'peer_id' => $user_id,
                'access_token' => BOT_TOKEN,
                'random_id' => '0',
                'keyboard' => json_encode(MAIN_KEYBOARD, JSON_UNESCAPED_UNICODE),
                'v' => '5.131',
            );

            $get_params = http_build_query($request_params);
            file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);
            break;
        default:
            log_msg("default");
    }
}