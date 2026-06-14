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

/** PUBLIC LIFE RECIPE: robots use FR/EN/ES locales and pluralized messages. */
final class I18nLifecycleScenario implements RecipeInterface, RobotScenario
{
    public function name(): string { return 'life_i18n'; }
    public function scenarioName(): string { return 'I18N'; }
    public function actor(): RobotActor { return new RobotActor('i18n_robot', 'system', 'fr'); }
    public function run(RecipeContext $context): array { return (new LifeScenarioRunner())->run($context, $this); }

    public function steps(): array
    {
        return [new RobotStep('simulate_locale_users', function (RecipeContext $context, RobotSession $session): void {
            $catalogs = [
                'fr' => [new \Opus\I18n\Plural\FrenchPluralRule(), 'Bonjour Ada', '2 éléments'],
                'en' => [new \Opus\I18n\Plural\EnglishPluralRule(), 'Hello Ada', '2 items'],
                'es' => [new \Opus\I18n\Plural\SpanishPluralRule(), 'Hola Ada', '2 elementos'],
            ];
            foreach ($catalogs as $locale => [$rule, $hello, $plural]) {
                $translator = new \Opus\I18n\Translator(new \Opus\I18n\TranslationCatalog(new \Opus\I18n\LocaleCode($locale), ['hello' => explode(' ', $hello)[0] . ' {name}'], ['items' => ['one' => '{count} item', 'other' => $locale === 'fr' ? '{count} éléments' : ($locale === 'es' ? '{count} elementos' : '{count} items')]]), $rule);
                $context->assert($translator->translate('hello', ['name' => 'Ada']) === $hello, 'OPUS_LIFE_I18N_TRANSLATION_FAILED', $locale);
                $context->assert($translator->plural('items', 2) === $plural, 'OPUS_LIFE_I18N_PLURAL_FAILED', $locale);
            }
        })];
    }
}
