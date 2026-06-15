<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$layout = $root . DIRECTORY_SEPARATOR . 'application/reference/templates/layout.twig';
$css = $root . DIRECTORY_SEPARATOR . 'public/assets/css/refbook-runtime.css';
$siteService = $root . DIRECTORY_SEPARATOR . 'application/reference/Service/ReferencePublicSiteService.php';
$legal = $root . DIRECTORY_SEPARATOR . 'application/reference/templates/pages/legal.twig';

$layoutText = is_file($layout) ? (string) file_get_contents($layout) : '';
$cssText = is_file($css) ? (string) file_get_contents($css) : '';
$siteText = is_file($siteService) ? (string) file_get_contents($siteService) : '';
$legalText = is_file($legal) ? (string) file_get_contents($legal) : '';

$checks = [
    'layout bumps css cache to P114A6' => str_contains($layoutText, 'refbook-runtime.css?v=P114A6'),
    'layout names Opus in legal badge default' => str_contains($layoutText, 'Opus Framework · source-available · dual licensed'),
    'public site model names Opus in legal short label' => str_contains($siteText, "'legal_short' => 'Opus Framework · source-available · dual licensed'"),
    'legal page title names Opus' => str_contains($legalText, 'Opus Framework · source-available & dual licensed'),
    'css contains P114A3 marker' => str_contains($cssText, 'P114A3: professional readable header branding card'),
    'css contains P114A6 theme marker' => str_contains($cssText, 'P114A6: theme-aware professional branding card and language selectbox'),
    'css uses structured grid card' => str_contains($cssText, 'grid-template-columns: max-content minmax(0, 1fr)'),
    'css uses strong left border' => str_contains($cssText, 'border-left: 4px solid'),
    'css uses readable link hover' => str_contains($cssText, '.site-legal-badge a:hover'),
    'css defines responsive card' => str_contains($cssText, '@media (max-width: 940px)'),
];

$failed = array_keys(array_filter($checks, static fn(bool $ok): bool => !$ok));
if ($failed !== []) {
    fwrite(STDERR, 'P114A3_STATIC_FAIL: ' . implode(', ', $failed) . PHP_EOL);
    exit(1);
}

echo 'P114A3_REFBOOK_HEADER_BRANDING_PRO_READABILITY_STATIC_SMOKE_OK' . PHP_EOL;
