<?php

declare(strict_types=1);

/**
 * INTERNAL SMOKE CHECK
 *
 * Role:
 *   Validate the first modern Opus FSM + ACL PHP skeleton.
 *
 * Responsibility:
 *   Loads the documented PHP classes, verifies one allowed FSM transition,
 *   one refused FSM transition, one allowed ACL decision and one denied ACL decision.
 *
 * Side effects:
 *   Writes smoke-check status lines to STDOUT.
 *
 * Contract:
 *   No vendor, no Composer dependency, no network, no filesystem mutation beyond stdout.
 *   Failure must throw explicitly and return a non-zero process exit.
 *
 * Since:
 *   P112C4
 */

require_once __DIR__ . '/../../framework/Opus/Fsm/StateMachineException.php';
require_once __DIR__ . '/../../framework/Opus/Fsm/StateActionInterface.php';
require_once __DIR__ . '/../../framework/Opus/Fsm/StateDefinition.php';
require_once __DIR__ . '/../../framework/Opus/Fsm/SignalDefinition.php';
require_once __DIR__ . '/../../framework/Opus/Fsm/TransitionDefinition.php';
require_once __DIR__ . '/../../framework/Opus/Fsm/TransitionResult.php';
require_once __DIR__ . '/../../framework/Opus/Fsm/StateMemory.php';
require_once __DIR__ . '/../../framework/Opus/Fsm/StateMachine.php';
require_once __DIR__ . '/../../framework/Opus/Acl/AccessControlException.php';
require_once __DIR__ . '/../../framework/Opus/Acl/AccessDeniedException.php';
require_once __DIR__ . '/../../framework/Opus/Acl/AccessConditionInterface.php';
require_once __DIR__ . '/../../framework/Opus/Acl/RoleDefinition.php';
require_once __DIR__ . '/../../framework/Opus/Acl/ResourceDefinition.php';
require_once __DIR__ . '/../../framework/Opus/Acl/PrivilegeDefinition.php';
require_once __DIR__ . '/../../framework/Opus/Acl/AccessContext.php';
require_once __DIR__ . '/../../framework/Opus/Acl/AccessRule.php';
require_once __DIR__ . '/../../framework/Opus/Acl/AccessDecision.php';
require_once __DIR__ . '/../../framework/Opus/Acl/AccessControl.php';

use Opus\Fsm\StateDefinition;
use Opus\Fsm\TransitionDefinition;
use Opus\Fsm\StateMachine;
use Opus\Fsm\StateMachineException;
use Opus\Acl\RoleDefinition;
use Opus\Acl\ResourceDefinition;
use Opus\Acl\PrivilegeDefinition;
use Opus\Acl\AccessRule;
use Opus\Acl\AccessControl;

function assertTrue(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException('ASSERT_FAILED: ' . $message);
    }
}

$fsm = new StateMachine(
    [
        new StateDefinition('SITE_OPEN'),
        new StateDefinition('SITE_LOCKDOWN'),
    ],
    [
        new TransitionDefinition('SITE_OPEN', 'CONFIRMED_ATTACK', 'SITE_LOCKDOWN'),
    ],
    'SITE_OPEN'
);

$result = $fsm->apply('CONFIRMED_ATTACK');
assertTrue($result->fromState() === 'SITE_OPEN', 'FSM from state');
assertTrue($result->toState() === 'SITE_LOCKDOWN', 'FSM to state');
assertTrue($fsm->currentState() === 'SITE_LOCKDOWN', 'FSM current state');

$refused = false;
try {
    $fsm->apply('UNKNOWN_SIGNAL');
} catch (StateMachineException $exception) {
    $refused = str_contains($exception->getMessage(), StateMachineException::TRANSITION_NOT_ALLOWED);
}
assertTrue($refused, 'FSM refused transition');

$acl = new AccessControl(
    [
        new RoleDefinition('admin'),
        new RoleDefinition('public'),
    ],
    [
        new ResourceDefinition('site'),
    ],
    [
        new PrivilegeDefinition('read'),
        new PrivilegeDefinition('write'),
    ],
    [
        new AccessRule('admin', 'site', 'write', true),
    ]
);

$allowed = $acl->decide('admin', 'site', 'write');
assertTrue($allowed->allowed(), 'ACL admin write allowed');

$denied = $acl->decide('public', 'site', 'write');
assertTrue(!$denied->allowed(), 'ACL public write denied');

echo 'P112C4 FSM smoke OK' . PHP_EOL;
echo 'P112C4 ACL smoke OK' . PHP_EOL;
echo 'P112C4 Opus smoke checks OK' . PHP_EOL;
