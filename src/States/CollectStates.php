<?php

namespace App\States;

require_once 'global.php';

class CollectStates
{
    private array $states = [];

    public function __construct(...$states)
    {
        log_msg("CollectState");
        $this->states = $states;
    }

    public function getState(string $name): ?State
    {
        log_msg("getStateStart");
        foreach ($this->states as $state) {
            if (in_array($name, $state->getNames())) {
                log_msg($state->getNames());
                return $state;
            }
        }
        return null;
    }


}