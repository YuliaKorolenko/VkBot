<?php


use App\States\CheckEnterState;
use App\States\EnterGroupState;
use App\States\AddWishListState;
use App\States\CollectStates;
use App\States\StartState;
use App\States\CreateState;
use App\Classes\Users;
use App\Databases\Database;
use App\States\AddGroupState;
use App\States\OutState;
use App\States\StopState;


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
                new OutState(),
                new EnterGroupState(),
                new CheckEnterState(),
                new StopState()
            );

            log_msg("dat = " . $data->object->message->text);

            $database = new Database();
            $db = $database->getConnection();

            $user = new Users($db);
            $user->id = $data->object->message->from_id;

            if ($user->getCount() < 1){
                $user->state_number=START_STATE;
                $user->create();
            }

            $user->getNumberState();
            log_msg($user->state_number);

            $state = $collectStates->getState($data->object->message->text);
            if ($state != null) {
                if (in_array($user->state_number, $state->getPreviousNames())){
                    $state->changeState($data);
                } else {
                    log_msg("problem");
                }
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