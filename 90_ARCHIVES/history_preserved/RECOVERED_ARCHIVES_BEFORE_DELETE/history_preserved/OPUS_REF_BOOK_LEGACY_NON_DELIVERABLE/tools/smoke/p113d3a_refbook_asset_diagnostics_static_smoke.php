<?php
declare(strict_types=1);

$root = dirname(__DIR__, 2);
$required = [
    'application/reference/Service/ReferenceCatalogService.php',
    'application/reference/Controller/HomeController.php',
    'application/reference/Controller/PageController.php',
    'application/reference/Controller/ReferenceApiController.php',
    'application/reference/templates/layout.twig',
    'application/reference/templates/pages/asset-diagnostics.twig',
    'sites/opus-reference/routes.xml',
    'public/assets/css/refbook-runtime.css',
];

try {
    foreach ($required as $file) {
        $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
        if (!is_file($path)) {
            throw new RuntimeException('FILE_MISSING=' . $file);
        }
    }

    $forbidden = [$root . '/framework', $root . '/Opus'];
    foreach ($forbidden as $path) {
        if (file_exists($path)) {
            throw new RuntimeException('OPUS_FRAMEWORK_EMBEDDED_FORBIDDEN=' . $path);
        }
    }

    $phpFiles = [
        'application/reference/Service/ReferenceCatalogService.php',
        'application/reference/Controller/HomeController.php',
        'application/reference/Controller/PageController.php',
        'application/reference/Controller/ReferenceApiController.php',
    ];

    foreach ($phpFiles as $file) {
        $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
        $cmd = 'php -l ' . escapeshellarg($path);
        exec($cmd, $output, $exitCode);
        if ($exitCode !== 0) {
            throw new RuntimeException('PHP_LINT_FAILED=' . $file . ' ' . implode(' ', $output));
        }
    }

    $routes = (string) file_get_contents($root . '/sites/opus-reference/routes.xml');
    if (!str_contains($routes, '/api/refbook/asset-integrity')) {
        throw new RuntimeException('ASSET_INTEGRITY_ROUTE_MISSING');
    }

    $layout = (string) file_get_contents($root . '/application/reference/templates/layout.twig');
    if (!str_contains($layout, 'page=asset-diagnostics')) {
        throw new RuntimeException('ASSET_DIAGNOSTICS_NAV_MISSING');
    }

    $template = (string) file_get_contents($root . '/application/reference/templates/pages/asset-diagnostics.twig');
    foreach (['Diagnostics assets documentaires', 'unique_missing', 'api/refbook/asset-integrity'] as $needle) {
        if (!str_contains($template, $needle)) {
            throw new RuntimeException('ASSET_DIAGNOSTICS_TEMPLATE_CONTRACT_MISSING=' . $needle);
        }
    }

    echo 'P113D3A_REFBOOK_ASSET_DIAGNOSTICS_STATIC_SMOKE_OK' . PHP_EOL;
} catch (Throwable $exception) {
    fwrite(STDERR, 'P113D3A_STATIC_SMOKE_FAIL: ' . $exception->getMessage() . PHP_EOL);
    exit(1);
}
