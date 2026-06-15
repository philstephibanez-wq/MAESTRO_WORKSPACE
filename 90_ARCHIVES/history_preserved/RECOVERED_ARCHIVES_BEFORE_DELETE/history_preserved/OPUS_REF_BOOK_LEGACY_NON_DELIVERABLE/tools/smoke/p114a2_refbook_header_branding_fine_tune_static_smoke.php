<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$css = $root . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'refbook-runtime.css';
$layout = $root . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'reference' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'layout.twig';

foreach ([$css, $layout] as $file) {
    if (!is_file($file)) {
        fwrite(STDERR, 'P114A2_STATIC_FAIL: missing file ' . $file . PHP_EOL);
        exit(1);
    }
}

$cssContent = (string) file_get_contents($css);
$layoutContent = (string) file_get_contents($layout);

$checks = [
    'runtime css cache key bumped to final P114A6 lineage' => str_contains($layoutContent, 'refbook-runtime.css?v=P114A6'),
    'badge names Opus explicitly' => str_contains($layoutContent, 'Opus Framework · source-available · dual licensed'),
    'badge shifted right' => str_contains($cssContent, 'margin-left: 1.25rem;'),
    'pro readability marker present' => str_contains($cssContent, 'P114A3: professional readable header branding card'),
    'theme-aware final marker present' => str_contains($cssContent, 'P114A6: theme-aware professional branding card and language selectbox'),
    'badge uses structured grid' => str_contains($cssContent, 'grid-template-columns: max-content minmax(0, 1fr)'),
    'badge strong reduced weight' => str_contains($cssContent, 'font-weight: 680;'),
];

foreach ($checks as $label => $ok) {
    if (!$ok) {
        fwrite(STDERR, 'P114A2_STATIC_FAIL: ' . $label . PHP_EOL);
        exit(1);
    }
}

fwrite(STDOUT, 'P114A2_REFBOOK_HEADER_BRANDING_FINE_TUNE_STATIC_SMOKE_OK' . PHP_EOL);
