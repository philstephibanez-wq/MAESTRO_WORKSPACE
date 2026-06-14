<?php

declare(strict_types=1);

namespace Opus\Recipe\Recipes;

use Opus\Recipe\RecipeContext;
use Opus\Recipe\RecipeInterface;

/** PUBLIC RECIPE: validate the existing Lstsa/LSTSAR background smoke contract. */
final class LstsaRecipe implements RecipeInterface
{
    public function name(): string { return 'lstsa'; }

    public function run(RecipeContext $context): array
    {
        foreach ([
            \Opus\Lstsa\LstsaScheduler::class,
            \Opus\Lstsa\LstsaRunner::class,
            \Opus\Lstsa\LstsaFsmController::class,
            \Opus\Lstsa\LstsaLoadPhase::class,
            \Opus\Lstsa\LstsaSecureInputPhase::class,
            \Opus\Lstsa\LstsaTransformPhase::class,
            \Opus\Lstsa\LstsaSecureOutputPhase::class,
            \Opus\Lstsa\LstsaStorePhase::class,
            \Opus\Lstsa\LstsaArchivePhase::class,
            \Opus\Lstsa\LstsaReportPhase::class,
            \Opus\Lstsa\LstsaDatabaseStagingExecutor::class,
        ] as $class) {
            $context->assert(class_exists($class), 'OPUS_LSTSA_CLASS_NOT_LOADABLE', $class);
        }

        $script = $context->path('tools/automation/p112q2i5_lstsa_fsm_background_staging_recipe.php');
        $context->assert(is_file($script), 'OPUS_LSTSA_P112Q2I5_RECIPE_MISSING');
        $output = $context->runCommand(escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($script), 'OPUS_LSTSA_P112Q2I5_RECIPE_FAILED');
        $joined = implode("\n", $output);
        foreach (['P112Q2I5_SCHEDULED_STATUS=PENDING', 'P112Q2I5_TARGET_ROWS=2', 'P112Q2I5_Lstsa_FSM_BACKGROUND_STAGING_RECIPE_OK'] as $marker) {
            $context->assert(str_contains($joined, $marker), 'OPUS_LSTSA_MARKER_MISSING', $marker);
        }

        return ['OPUS_LSTSAR_OK'];
    }
}
