<?php


use App\States\CollectStates;
use App\States\StartState;
use App\States\CreateState;
use App\Classes\Users;
use App\Databases\Database;
use App\States\AddGroupState;

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
                new AddGroupState()
            );

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
                if ($state->getPreviousName() == $user->getNumberState()){
                    $state->_do($data);
                } else {
                    $statePrev = $collectStates->getState($user->getNumberState());
                    $statePrev->_error($data);
                }
            } else {
                $state = $collectStates->getStateByPrev($user->state_number);
                $state->_do($data);
            }

            log_msg("sucessMes2");

            log_msg("after collect");

            log_msg("dat = " . $data->object->message->text);

            echo('ok');
            break;
        case 'message_event':
            break;
        default:
            log_msg("default");
    }
}