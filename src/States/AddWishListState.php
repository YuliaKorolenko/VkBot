<?php

namespace App\States;

use App\Classes\Participants;
use App\Classes\Users;
use App\Databases\Database;

class AddWishListState implements State
{

    public function __construct()
    {
    }

    public function changeState($data)
    {

        $user_id = $data->object->message->from_id;

        $database = new Database();
        $db = $database->getConnection();

        $user = new Users($db);
        $user->id = $user_id;
        $user->state_number=$this->getName();

        if ($user->update()) {
            log_msg("WishList change successfully.");
        } else {
            log_msg("WishList change not be updated.");
        }

        $this->_do($data);
    }

    public function _do($data)
    {
        log_msg("In Do WISHLIST");
        $user_id = $data->object->message->from_id;

        $database = new Database();

        $db = $database->getConnection();

        $participant = new Participants($db);
        $participant->user_id = $user_id;
        $participant->wish_list = $data->object->message->text;
        $participant->is_active = 1;

        log_msg("Before Find");
        $participant->findGroupId();
        log_msg("beforeCreator");
        $participant->isCreator();
        log_msg("beforeUpdate");
        $participant->update();
        
        if ($participant->is_creator == 1) {
            $request_params = array(
                'message' => STRING_WISH_LIST,
                'peer_id' => $user_id,
                'access_token' => BOT_TOKEN,
                'random_id' => '0',
                'keyboard' => json_encode(CREATE_KEYBOARD, JSON_UNESCAPED_UNICODE),
                'v' => '5.131',
            );
        } else {
            $request_params = array(
                'message' => STRING_WISH_LIST,
                'peer_id' => $user_id,
                'access_token' => BOT_TOKEN,
                'random_id' => '0',
                'keyboard' => json_encode(ENTER_KEYBOARD, JSON_UNESCAPED_UNICODE),
                'v' => '5.131',
            );
        }

        $get_params = http_build_query($request_params);
        file_get_contents('https://api.vk.com/method/messages.send?' . $get_params);


    }

    public function _error($data)
    {
        // TODO: Implement _error() method.
    }

    public function getName(): string
    {
        return ADD_WISH_LIST_STATE;
    }

    public function getPreviousNames(): array
    {
        return array(ADD_GROUP, CHECK_ENTER_STATE);
    }
}