<?php
define('BOT_BASE_DIRECTORY', '/var/www');
define('BOT_LOGS_DIRECTORY', BOT_BASE_DIRECTORY.'/logs');
define('BOT_IMAGES_DIRECTORY', BOT_BASE_DIRECTORY.'/static');
define('BOT_AUDIO_DIRECTORY', BOT_BASE_DIRECTORY.'/audio');

function log_msg($message) {
    if (is_array($message)) {
        $message = json_encode($message);
    }

    _log_write('[INFO] ' . $message);
}

function log_error($message) {
    if (is_array($message)) {
        $message = json_encode($message);
    }

    _log_write('[ERROR] ' . $message);
}

function _log_write($message) {
    $trace = debug_backtrace();
    $function_name = isset($trace[2]) ? $trace[2]['function'] : '-';
    $mark = date("H:i:s") . ' [' . $function_name . ']';
    $log_name = BOT_LOGS_DIRECTORY.'/log_' . date("j.n.Y") . '.txt';
    file_put_contents($log_name, $mark . " : " . $message . "\n", FILE_APPEND);
}