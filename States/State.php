<?php

namespace Actions;

require_once 'global.php';
include_once 'databases/database.php';
include_once 'class/group.php';
include_once 'keyboards.php';
include_once 'names.php';

interface State
{
    public function __construct();

    public function _do($data);

    public function getName(): string;

}