<?php

namespace States;

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
            log_msg($state->getName());
            if (strcmp("Выбрать группу", $state->getName()))
            return $state;
        }
        return null;
    }


}