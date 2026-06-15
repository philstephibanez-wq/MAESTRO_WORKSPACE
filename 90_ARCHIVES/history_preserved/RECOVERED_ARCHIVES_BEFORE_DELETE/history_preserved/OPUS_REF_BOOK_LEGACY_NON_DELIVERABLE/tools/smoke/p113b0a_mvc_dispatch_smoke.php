<?php
declare(strict_types=1);

$root = dirname(__DIR__, 2);
require_once $root . '/bootstrap/autoload.php';

use Opus\Application\ApplicationPaths;
use Opus\Controller\ControllerDispatcher;
use Opus\Http\Request;
use Opus\Renderer\HtmlRenderer;
use Opus\Routing\Router;
use Opus\Site\SiteResolver;
use Opus\Template\TemplateRendererInterface;

final class P113B0ATestTemplateRenderer implements TemplateRendererInterface
{
    public function render(string $template, array $data): string
    {
        return 'TEMPLATE=' . $template . ';TITLE=' . (string)($data['title'] ?? '');
    }
}

$paths = new ApplicationPaths($root, 'opus-reference');
$site = (new SiteResolver($paths->sitesRoot))->resolve(new Request('/OPUS_REF_BOOK/api-reference'));
$match = Router::fromXml($site->routesFile)->match(new Request('/OPUS_REF_BOOK/api-reference'), $site);

$renderer = new P113B0ATestTemplateRenderer();
$response = (new ControllerDispatcher($paths, $renderer, new HtmlRenderer($renderer)))
    ->dispatch(new Request('/OPUS_REF_BOOK/api-reference'), $match);

if ($response->status !== 200) {
    fwrite(STDERR, 'P113B0A_DISPATCH_STATUS_INVALID=' . $response->status . PHP_EOL);
    exit(1);
}

if (!str_contains($response->body, 'TEMPLATE=pages/api-reference.twig')) {
    fwrite(STDERR, 'P113B0A_DISPATCH_TEMPLATE_INVALID=' . $response->body . PHP_EOL);
    exit(1);
}

echo 'P113B0A_MVC_DISPATCH_SMOKE_OK' . PHP_EOL;
