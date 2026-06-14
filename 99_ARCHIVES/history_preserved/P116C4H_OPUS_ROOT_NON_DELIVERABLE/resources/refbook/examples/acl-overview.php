<?php
declare(strict_types=1);

/*
 * Opus RefBook example: ACL overview.
 *
 * Purpose:
 *   Show the intended ACL vocabulary used by Opus route/security metadata.
 *
 * Contract:
 *   ACL decisions are explicit. A route or controller must never silently
 *   continue when the access decision is denied.
 */

use Opus\Acl\Acl;
use Opus\Acl\AccessContext;
use Opus\Acl\AccessControl;
use Opus\Acl\AccessDecision;
use Opus\Acl\AccessRule;
use Opus\Acl\ResourceDefinition;
use Opus\Acl\RoleDefinition;

// 1. Declare roles/resources/privileges in configuration or bootstrap code.
$acl = new Acl(
    roles: [
        new RoleDefinition('admin'),
        new RoleDefinition('reader'),
    ],
    resources: [
        new ResourceDefinition('refbook'),
    ],
    rules: [
        AccessRule::allow('admin', 'refbook', 'read'),
        AccessRule::allow('reader', 'refbook', 'read'),
    ],
);

// 2. Build a request-scoped access context.
$context = new AccessContext(
    role: 'reader',
    resource: 'refbook',
    privilege: 'read',
);

// 3. Ask the access controller for an explicit decision.
$control = new AccessControl($acl);
$decision = $control->canView($context);

if (!$decision instanceof AccessDecision || !$decision->allowed()) {
    throw new RuntimeException('OPUS_ACL_DECISION_DENIED');
}
