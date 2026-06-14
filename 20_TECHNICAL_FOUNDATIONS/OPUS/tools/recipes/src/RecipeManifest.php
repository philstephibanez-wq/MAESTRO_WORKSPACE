<?php

declare(strict_types=1);

namespace Opus\Recipe;

use Opus\Recipe\Recipes\AclRecipe;
use Opus\Recipe\Recipes\AutoloadCacheRecipe;
use Opus\Recipe\Recipes\CoreAutoloadRecipe;
use Opus\Recipe\Recipes\DatabaseRecipe;
use Opus\Recipe\Recipes\DocsRecipe;
use Opus\Recipe\Recipes\FeatureManifestRecipe;
use Opus\Recipe\Recipes\FsmRecipe;
use Opus\Recipe\Recipes\GitStructureRecipe;
use Opus\Recipe\Recipes\I18nRecipe;
use Opus\Recipe\Recipes\LstsaRecipe;
use Opus\Recipe\Recipes\MailRecipe;
use Opus\Recipe\Recipes\NamingRecipe;
use Opus\Recipe\Recipes\PhpLintRecipe;
use Opus\Recipe\Recipes\PreflightRecipe;
use Opus\Recipe\Recipes\RealFeatureBindingRecipe;
use Opus\Recipe\Recipes\RoutingRecipe;
use Opus\Recipe\Recipes\TemplateRecipe;
use Opus\Recipe\Life\Scenarios\AclAccessLifecycleScenario;
use Opus\Recipe\Life\Scenarios\DatabaseLifecycleScenario;
use Opus\Recipe\Life\Scenarios\HttpMailLifeRobotScenario;
use Opus\Recipe\Life\Scenarios\I18nLifecycleScenario;
use Opus\Recipe\Life\Scenarios\LstsarBackgroundLifecycleScenario;
use Opus\Recipe\Life\Scenarios\LstsarConcurrencyLifecycleScenario;
use Opus\Recipe\Life\Scenarios\LstsarFailureLifecycleScenario;
use Opus\Recipe\Life\Scenarios\MaintenanceLifecycleScenario;
use Opus\Recipe\Life\Scenarios\PublicSiteLifecycleScenario;

/**
 * PUBLIC MANIFEST
 *
 * Role:
 *   Declare the global Opus recipe suite order.
 *
 * Contract:
 *   This is the single registry for the global recipe suite. No implicit test
 *   discovery is accepted for validation-critical checks.
 */
final class RecipeManifest
{
    public function createSuite(): RecipeSuite
    {
        $suite = new RecipeSuite();
        foreach ($this->recipes() as $recipe) {
            $suite->add($recipe);
        }

        return $suite;
    }

    /** @return RecipeInterface[] */
    public function recipes(): array
    {
        return [
            new PreflightRecipe(),
            new GitStructureRecipe(),
            new NamingRecipe(),
            new PhpLintRecipe(),
            new DocsRecipe(),
            new FeatureManifestRecipe(),
            new AutoloadCacheRecipe(),
            new RealFeatureBindingRecipe(),
            new CoreAutoloadRecipe(),
            new DatabaseRecipe(),
            new FsmRecipe(),
            new AclRecipe(),
            new I18nRecipe(),
            new RoutingRecipe(),
            new TemplateRecipe(),
            new MailRecipe(),
            new LstsaRecipe(),
            new PublicSiteLifecycleScenario(),
            new AclAccessLifecycleScenario(),
            new I18nLifecycleScenario(),
            new DatabaseLifecycleScenario(),
            new LstsarBackgroundLifecycleScenario(),
            new LstsarFailureLifecycleScenario(),
            new LstsarConcurrencyLifecycleScenario(),
            new MaintenanceLifecycleScenario(),
            new HttpMailLifeRobotScenario(),
        ];
    }
}
