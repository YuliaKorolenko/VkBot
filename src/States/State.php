<?php

namespace App\States;

require_once 'global.php';
require_once 'keyboards.php';
require_once 'names.php';

interface State
{
    public function __construct();

    public function _do($data);

    public function getName(): string;

}