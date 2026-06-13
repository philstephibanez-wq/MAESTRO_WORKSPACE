<?php

declare(strict_types=1);

use ASAP\Http\Request;
use ASAP\Routing\Router;
use ASAP\Site\SiteDefinition;

$site = new SiteDefinition('demo', '', __DIR__ . '/routes.xml', __DIR__ . '/security.xml');
$router = Router::fromXml($site->routesFile);
$match = $router->match(new Request('/demo', 'GET'), $site);

echo $match->name . PHP_EOL;
