<?php
declare(strict_types=1);

function fail(string $message): never
{
    fwrite(STDERR, $message . PHP_EOL);
    exit(1);
}

$root = dirname(__DIR__, 2);
$requiredFiles = [
    'application/reference/Service/ReferencePublicSiteService.php',
    'application/reference/Controller/ReferenceDiscoveryController.php',
    'application/reference/templates/pages/legal.twig',
    'application/reference/templates/layout.twig',
    'sites/opus-reference/routes.xml',
    'public/assets/css/refbook-runtime.css',
];

foreach ($requiredFiles as $relative) {
    $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    if (!is_file($path)) {
        fail('P114A_STATIC_FAIL: missing file=' . $relative);
    }
}

$layout = (string) file_get_contents($root . '/application/reference/templates/layout.twig');
$routes = (string) file_get_contents($root . '/sites/opus-reference/routes.xml');
$legal = (string) file_get_contents($root . '/application/reference/templates/pages/legal.twig');
$css = (string) file_get_contents($root . '/public/assets/css/refbook-runtime.css');

$layoutMarkers = [
    '<link rel="canonical"',
    '<meta property="og:title"',
    '<script type="application/ld+json">',
    'Powered by Opus Framework',
    'Opus Framework · source-available · dual licensed',
    'page=legal',
    'site-footer',
];
foreach ($layoutMarkers as $marker) {
    if (!str_contains($layout, $marker)) {
        fail('P114A_STATIC_FAIL: layout marker missing=' . $marker);
    }
}

$routeMarkers = [
    'path="/robots.txt"',
    'path="/sitemap.xml"',
    'ReferenceDiscoveryController',
];
foreach ($routeMarkers as $marker) {
    if (!str_contains($routes, $marker)) {
        fail('P114A_STATIC_FAIL: route marker missing=' . $marker);
    }
}

$legalMarkers = [
    'Opus Framework · source-available & dual licensed',
    'Opus dual license',
    'Professional, commercial, SaaS',
    'site.copyright',
];
foreach ($legalMarkers as $marker) {
    if (!str_contains($legal, $marker)) {
        fail('P114A_STATIC_FAIL: legal marker missing=' . $marker);
    }
}

foreach (['.site-footer', '.legal-panel', '.site-legal-badge'] as $marker) {
    if (!str_contains($css, $marker)) {
        fail('P114A_STATIC_FAIL: css marker missing=' . $marker);
    }
}

require_once $root . '/application/reference/Service/ReferenceContentService.php';
require_once $root . '/application/reference/Service/ReferencePublicSiteService.php';

$service = new OpusRefBook\Reference\Service\ReferencePublicSiteService();
if ($service->publicBaseUrl() !== 'https://opus.logandplay.org') {
    fail('P114A_STATIC_FAIL: public base url invalid');
}

if (!str_contains($service->robotsTxt(), 'Sitemap: https://opus.logandplay.org/sitemap.xml')) {
    fail('P114A_STATIC_FAIL: robots sitemap missing');
}

$sitemap = $service->sitemapXml(
    [['index' => 12]],
    [['slug' => 'guide-runtime', 'title' => 'Runtime']],
    [['slug' => 'fsm', 'name' => 'FSM']]
);
foreach (['<urlset', 'https://opus.logandplay.org/symbol-12', 'https://opus.logandplay.org/domain-fsm', 'https://opus.logandplay.org/legal'] as $marker) {
    if (!str_contains($sitemap, $marker)) {
        fail('P114A_STATIC_FAIL: sitemap marker missing=' . $marker);
    }
}

echo 'P114A_REFBOOK_PUBLIC_VISIBILITY_SEO_BRANDING_STATIC_SMOKE_OK' . PHP_EOL;
