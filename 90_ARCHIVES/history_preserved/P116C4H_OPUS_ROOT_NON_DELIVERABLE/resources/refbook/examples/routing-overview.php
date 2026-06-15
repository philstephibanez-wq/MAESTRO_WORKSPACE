<?php

declare(strict_types=1);

use Opus\Http\Request;
use Opus\Routing\Router;
use Opus\Site\SiteDefinition;

$site = new SiteDefinition('demo', '', __DIR__ . '/routes.xml', __DIR__ . '/security.xml');
$router = Router::fromXml($site->routesFile);
$match = $router->match(new Request('/demo', 'GET'), $site);

echo $match->name . PHP_EOL;
