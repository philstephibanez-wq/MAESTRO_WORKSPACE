<?php
declare(strict_types=1);

$root = dirname(__DIR__, 2);
$serviceFile = $root . '/application/reference/Service/ReferenceCatalogService.php';
$layoutFile = $root . '/application/reference/templates/layout.twig';

foreach ([$serviceFile, $layoutFile] as $file) {
    if (!is_file($file)) {
        fwrite(STDERR, 'P113D4C_STATIC_FAIL: missing file ' . $file . PHP_EOL);
        exit(1);
    }
}

$service = file_get_contents($serviceFile) ?: '';
$layout = file_get_contents($layoutFile) ?: '';

$checks = [
    'service exposes domain_slug' => str_contains($service, "'domain_slug'"),
    'service normalizes empty domain' => str_contains($service, 'if ($domain === \'\')'),
    'layout computes activeDomainSlug' => str_contains($layout, 'activeDomainSlug'),
    'layout reads symbol domain_slug' => str_contains($layout, 'symbol.domain_slug'),
    'domain link active from context' => str_contains($layout, 'activeDomainSlug == domain.slug'),
    'domain active aria current location' => str_contains($layout, 'aria-current="{% if pageSlug =='),
];

foreach ($checks as $label => $ok) {
    if (!$ok) {
        fwrite(STDERR, 'P113D4C_STATIC_FAIL: ' . $label . PHP_EOL);
        exit(1);
    }
}

$cmd = PHP_BINARY . ' -l ' . escapeshellarg($serviceFile);
exec($cmd, $output, $code);
if ($code !== 0) {
    fwrite(STDERR, 'P113D4C_STATIC_FAIL: PHP lint ReferenceCatalogService' . PHP_EOL . implode(PHP_EOL, $output) . PHP_EOL);
    exit(1);
}

echo 'P113D4C_REFBOOK_SIDEBAR_ACTIVE_CONTEXT_STATIC_SMOKE_OK' . PHP_EOL;
