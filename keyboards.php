<?php

const MAIN_KEYBOARD = [
    "one_time" => false,
    "buttons" => [[
        ["action" => [
            "type" => "text",
            "payload" => "{\"button\": \"createGroup\"}",
            "label" => "Создать группу"],
            "color" => "secondary"],
        ["action" => [
            "type" => "text",
            "payload" => "{\"button\": \"joinGroup\"}",
            "label" => "Войти в группу"],
            "color" => "secondary"],
        ]]];