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
            if ($name == $state->getName()) {
                return $state;
            }
        }
        return null;
    }


    public function getStateByPrev(string $name): ?State
    {
        log_msg("getStateByPrevStart");
        foreach ($this->states as $state) {
            if ($name == $state->getPreviousName()) {
                return $state;
            }
        }
        return null;
    }


}