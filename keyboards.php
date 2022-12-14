<?php
const MAIN_KEYBOARD = [
    "one_time" => false,
    "buttons" => [[
        [["action" => [
            "type" => "text",
            "payload" => '{"command": "' . "first_command" . '"}',
            "label" => "Создать беседу"],
            "color" => "primary"]],
        [["action" => [
            "type" => "text",
            "payload" => '{"command": "' . "second_command" . '"}',
            "label" => "Войти в беседу"],
            "color" => "secondary"]]]]];