<?php

declare(strict_types=1);

namespace Opus\Recipe\Life\Scenarios;

use Opus\Recipe\Life\LifeScenarioRunner;
use Opus\Recipe\Life\RobotActor;
use Opus\Recipe\Life\RobotScenario;
use Opus\Recipe\Life\RobotSession;
use Opus\Recipe\Life\RobotStep;
use Opus\Recipe\RecipeContext;
use Opus\Recipe\RecipeInterface;

/** PUBLIC LIFE RECIPE: robots validate public/admin/denied access rules. */
final class AclAccessLifecycleScenario implements RecipeInterface, RobotScenario
{
    public function name(): string { return 'life_acl'; }
    public function scenarioName(): string { return 'ACL'; }
    public function actor(): RobotActor { return new RobotActor('acl_supervisor', 'system', 'fr'); }
    public function run(RecipeContext $context): array { return (new LifeScenarioRunner())->run($context, $this); }

    public function steps(): array
    {
        return [new RobotStep('simulate_access_matrix', function (RecipeContext $context, RobotSession $session): void {
            $acl = new \Opus\Acl\AccessControl(
                [new \Opus\Acl\RoleDefinition('anonymous'), new \Opus\Acl\RoleDefinition('admin'), new \Opus\Acl\RoleDefinition('denied')],
                [new \Opus\Acl\ResourceDefinition('public'), new \Opus\Acl\ResourceDefinition('admin')],
                [new \Opus\Acl\PrivilegeDefinition('view')],
                [new \Opus\Acl\AccessRule('anonymous', 'public', 'view', true), new \Opus\Acl\AccessRule('admin', 'admin', 'view', true), new \Opus\Acl\AccessRule('denied', 'admin', 'view', false)]
            );
            $context->assert($acl->decide('anonymous', 'public', 'view')->allowed(), 'OPUS_LIFE_ACL_PUBLIC_DENIED');
            $context->assert(!$acl->decide('anonymous', 'admin', 'view')->allowed(), 'OPUS_LIFE_ACL_ANONYMOUS_ADMIN_ALLOWED');
            $context->assert($acl->decide('admin', 'admin', 'view')->allowed(), 'OPUS_LIFE_ACL_ADMIN_DENIED');
            $context->assert(!$acl->decide('denied', 'admin', 'view')->allowed(), 'OPUS_LIFE_ACL_DENIED_ALLOWED');
        })];
    }
}
