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
        foreach ($this->states as $state) {
            if ($name==$state->getName()) {
                return $state;
            }
        }
        return null;
    }



}