<?php
declare(strict_types=1);

$root = dirname(__DIR__, 2);

$requiredFiles = [
    'sites/opus-reference/routes.xml',
    'application/reference/Controller/AbstractRefBookController.php',
    'application/reference/Controller/ReferenceApiController.php',
    'application/reference/Service/ReferenceSnapshotRepositoryInterface.php',
    'application/reference/Service/ReferenceOpusRootLocator.php',
    'application/reference/Service/ReferenceRuntimeSnapshotRepository.php',
    'application/reference/Service/ReferenceFsmRunner.php',
    'application/reference/Service/ReferenceCatalogService.php',
    'public/assets/css/refbook-runtime.css',
];

foreach ($requiredFiles as $file) {
    $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
    if (!is_file($path)) {
        fwrite(STDERR, 'P113D2R_STATIC_SMOKE_FAIL: FILE_MISSING=' . $file . PHP_EOL);
        exit(1);
    }
}

foreach (['framework', 'Opus'] as $forbiddenDirectory) {
    if (is_dir($root . DIRECTORY_SEPARATOR . $forbiddenDirectory)) {
        fwrite(STDERR, 'P113D2R_STATIC_SMOKE_FAIL: EMBEDDED_OPUS_FORBIDDEN=' . $forbiddenDirectory . PHP_EOL);
        exit(1);
    }
}

$routes = (string) file_get_contents($root . '/sites/opus-reference/routes.xml');
foreach (['/api/refbook/health', '/api/refbook/snapshot', '/api/refbook/domains', '/api/refbook/classes', '/api/refbook/class'] as $route) {
    if (!str_contains($routes, 'path="' . $route . '"')) {
        fwrite(STDERR, 'P113D2R_STATIC_SMOKE_FAIL: ROUTE_MISSING=' . $route . PHP_EOL);
        exit(1);
    }
}

$abstractController = (string) file_get_contents($root . '/application/reference/Controller/AbstractRefBookController.php');
if (str_contains($abstractController, 'var/data/api_reference.generated.json')) {
    fwrite(STDERR, 'P113D2R_STATIC_SMOKE_FAIL: LEGACY_JSON_RUNTIME_REFERENCE_PRESENT' . PHP_EOL);
    exit(1);
}

if (!str_contains($abstractController, 'ReferenceFsmRunner')) {
    fwrite(STDERR, 'P113D2R_STATIC_SMOKE_FAIL: FSM_RUNNER_NOT_WIRED' . PHP_EOL);
    exit(1);
}

$phpFiles = [
    'application/reference/Controller/ReferenceApiController.php',
    'application/reference/Service/ReferenceSnapshotRepositoryInterface.php',
    'application/reference/Service/ReferenceOpusRootLocator.php',
    'application/reference/Service/ReferenceRuntimeSnapshotRepository.php',
    'application/reference/Service/ReferenceFsmRunner.php',
    'application/reference/Service/ReferenceCatalogService.php',
    'application/reference/Controller/AbstractRefBookController.php',
];

foreach ($phpFiles as $file) {
    $command = 'php -l ' . escapeshellarg($root . '/' . $file);
    exec($command, $output, $code);
    if ($code !== 0) {
        fwrite(STDERR, 'P113D2R_STATIC_SMOKE_FAIL: PHP_LINT_FAILED=' . $file . PHP_EOL . implode(PHP_EOL, $output) . PHP_EOL);
        exit(1);
    }
}

echo 'P113D2R_REFBOOK_FSM_INTERNAL_API_STATIC_SMOKE_OK' . PHP_EOL;
