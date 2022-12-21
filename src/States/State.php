<?php

namespace App\States;

require_once 'global.php';
require_once 'keyboards.php';
require_once 'names.php';
require_once 'VkApi.php';

interface State
{
    public function changeState($data);

    public function _do($data);

    public function _error($data);

    public function getName(): string;

    public function getPreviousNames(): array;

}