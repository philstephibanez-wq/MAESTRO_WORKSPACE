<?php

declare(strict_types=1);

use ASAP\Fsm\StateDefinition;
use ASAP\Fsm\TransitionDefinition;

// Example: the framework FSM is declared explicitly with states and transitions.
// RefBook uses Reflection for signatures and metadata/examples for explanation.

$states = [
    new StateDefinition('REQUEST_RECEIVED', 'Request received'),
    new StateDefinition('ROUTE_MATCHED', 'Route matched'),
    new StateDefinition('SECURITY_ALLOWED', 'Security allowed'),
    new StateDefinition('CONTROLLER_DISPATCHED', 'Controller dispatched'),
    new StateDefinition('RESPONSE_SENT', 'Response sent'),
];

$transitions = [
    new TransitionDefinition('REQUEST_RECEIVED', 'MATCH_ROUTE', 'ROUTE_MATCHED'),
    new TransitionDefinition('ROUTE_MATCHED', 'ALLOW_SECURITY', 'SECURITY_ALLOWED'),
    new TransitionDefinition('SECURITY_ALLOWED', 'DISPATCH_CONTROLLER', 'CONTROLLER_DISPATCHED'),
    new TransitionDefinition('CONTROLLER_DISPATCHED', 'SEND_RESPONSE', 'RESPONSE_SENT'),
];
