<?php

declare(strict_types=1);

namespace Opus\Recipe\Recipes;

use Opus\Recipe\RecipeContext;
use Opus\Recipe\RecipeInterface;

/** PUBLIC RECIPE: validate FSM explicit transitions and forbidden signal failure. */
final class FsmRecipe implements RecipeInterface
{
    public function name(): string { return 'fsm'; }

    public function run(RecipeContext $context): array
    {
        $fsm = new \Opus\Fsm\StateMachine(
            [new \Opus\Fsm\StateDefinition('DRAFT'), new \Opus\Fsm\StateDefinition('REVIEW'), new \Opus\Fsm\StateDefinition('PUBLISHED')],
            [new \Opus\Fsm\TransitionDefinition('DRAFT', 'SUBMIT', 'REVIEW'), new \Opus\Fsm\TransitionDefinition('REVIEW', 'APPROVE', 'PUBLISHED')],
            'DRAFT'
        );
        $context->assert($fsm->currentState() === 'DRAFT', 'OPUS_FSM_INITIAL_STATE_INVALID');
        $context->assert($fsm->apply('SUBMIT')->toState() === 'REVIEW', 'OPUS_FSM_SUBMIT_TRANSITION_INVALID');
        try {
            $fsm->apply('SUBMIT');
            $context->assert(false, 'OPUS_FSM_FORBIDDEN_TRANSITION_DID_NOT_FAIL');
        } catch (\Opus\Fsm\StateMachineException) {
        }
        $context->assert($fsm->apply('APPROVE')->toState() === 'PUBLISHED', 'OPUS_FSM_APPROVE_TRANSITION_INVALID');

        return ['OPUS_FSM_OK'];
    }
}
