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

const CREATE_KEYBOARD = [
    "one_time" => false,
    "buttons" => [[
        ["action" => [
            "type" => "text",
            "payload" => "{\"button\": \"stop\"}",
            "label" => "Остановить регистрацию"],
            "color" => "secondary"],
        ["action" => [
            "type" => "text",
            "payload" => "{\"button\": \"out\"}",
            "label" => "Выйти из группы"],
            "color" => "secondary"],
    ]]];