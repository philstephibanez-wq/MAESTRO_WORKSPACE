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

/** PUBLIC LIFE RECIPE: anonymous user opens a public route and receives rendered content. */
final class PublicSiteLifecycleScenario implements RecipeInterface, RobotScenario
{
    public function name(): string { return 'life_public_site'; }
    public function scenarioName(): string { return 'PUBLIC_SITE'; }
    public function actor(): RobotActor { return new RobotActor('anonymous_fr', 'anonymous', 'fr', ['public.view']); }
    public function run(RecipeContext $context): array { return (new LifeScenarioRunner())->run($context, $this); }

    public function steps(): array
    {
        return [
            new RobotStep('open_public_route', function (RecipeContext $context, RobotSession $session): void {
                $sandbox = $context->sandbox('life_public_site');
                $routes = $sandbox . DIRECTORY_SEPARATOR . 'routes.xml';
                $security = $sandbox . DIRECTORY_SEPARATOR . 'security.xml';
                file_put_contents($routes, '<routes><route name="home" path="/"><target controllerClass="DemoController" action="home" /></route></routes>');
                file_put_contents($security, '<security></security>');
                $site = new \Opus\Site\SiteDefinition('demo', '/demo', $routes, $security);
                $match = \Opus\Routing\Router::fromXml($routes)->match(new \Opus\Http\Request('/demo', 'GET'), $site);
                $context->assert($match->name === 'home', 'OPUS_LIFE_PUBLIC_ROUTE_MATCH_FAILED');
                $session->set('match', $match);
            }),
            new RobotStep('render_public_response', function (RecipeContext $context, RobotSession $session): void {
                $renderer = new class implements \Opus\Template\TemplateRendererInterface {
                    public function render(string $template, array $data = []): string { return 'FR:' . $template . ':' . (string)($data['route'] ?? ''); }
                };
                $response = (new \Opus\Renderer\HtmlRenderer($renderer))->render(new \Opus\Renderer\ViewModel('home.tpl', ['route' => $session->get('match')->name]));
                $context->assert($response->status === 200 && $response->body === 'FR:home.tpl:home', 'OPUS_LIFE_PUBLIC_RENDER_FAILED');
            }),
        ];
    }
}
