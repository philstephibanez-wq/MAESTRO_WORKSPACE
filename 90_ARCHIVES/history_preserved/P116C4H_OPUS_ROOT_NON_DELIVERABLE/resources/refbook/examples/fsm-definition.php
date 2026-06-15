<?php
declare(strict_types=1);

/*
 * Opus RefBook example: FSM definition.
 *
 * Purpose:
 *   Define a tiny state machine with explicit states and signals.
 */

use Opus\Fsm\Fsm;
use Opus\Fsm\StateDefinition;
use Opus\Fsm\SignalDefinition;
use Opus\Fsm\TransitionDefinition;

$fsm = new Fsm(
    states: [
        new StateDefinition('DRAFT', 'Draft'),
        new StateDefinition('VALIDATED', 'Validated'),
    ],
    signals: [
        new SignalDefinition('VALIDATE'),
    ],
    transitions: [
        TransitionDefinition::fromTo(
            fromState: 'DRAFT',
            signal: 'VALIDATE',
            toState: 'VALIDATED'
        ),
    ],
    initialState: 'DRAFT',
);
