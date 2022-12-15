<?php

namespace States;

class CollectStates
{
    private array $states = [];

    public function __construct(...$states)
    {
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