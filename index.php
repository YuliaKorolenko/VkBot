<?php


use App\States\AddWishListState;
use App\States\CollectStates;
use App\States\StartState;
use App\States\CreateState;
use App\Classes\Users;
use App\Databases\Database;
use App\States\AddGroupState;
use App\States\OutState;

require_once 'global.php';
require_once 'keyboards.php';
require_once 'names.php';

require __DIR__ . '/vendor/autoload.php';


callback_events();

function callback_events()
{
    if (!isset($_REQUEST)) {
        return;
    }

    log_msg("here");

    $data = json_decode(file_get_contents('php://input'));

    switch ($data->type) {
        case 'confirmation':
            echo CONFIRMATION_TOKEN;
            break;
        case 'message_new':

            $collectStates = new CollectStates(
                new StartState(),
                new CreateState(),
                new AddGroupState(),
                new AddWishListState(),
                new OutState()
            );

            log_msg("dat = " . $data->object->message->text);

            $database = new Database();
            $db = $database->getConnection();


            $user = new Users($db);
            $user->id = $data->object->message->from_id;

            if ($user->getNumberState()) {
                log_msg("GetState created successfully.");
                log_msg($user->state_number);
            } else {
                log_msg("User could not be created.");
            }

            $state = $collectStates->getState($data->object->message->text);
            if ($state != null) {
                log_msg("byName");
                $state->changeState($data);
            } else {
                log_msg("State number of user");
                log_msg($user->state_number);
                $state = $collectStates->getStateByPrev($user->state_number);
                $state->changeState($data);
            }


            log_msg("after collect");

            echo('ok');
            break;
        case 'message_event':
            break;
        default:
            log_msg("default");
    }
}