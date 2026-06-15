<?php
declare(strict_types=1);

/*
 * P115E_VERSION_PANEL_SMOKE
 *
 * Contract:
 *   Verify the version service can build the read model without rendering Twig.
 */

$root = dirname(__DIR__);
require_once $root . DIRECTORY_SEPARATOR . 'bootstrap' . DIRECTORY_SEPARATOR . 'autoload.php';

$service = new OpusRefBook\Reference\Service\ReferenceVersionService($root);
$panel = $service->panel();

$required = ['schema', 'installed', 'shared', 'official'];
foreach ($required as $key) {
    if (!array_key_exists($key, $panel)) {
        fwrite(STDERR, 'Missing key: ' . $key . PHP_EOL);
        exit(1);
    }
}

echo 'P115E_VERSION_PANEL_SMOKE_OK' . PHP_EOL;
echo 'installed=' . ($panel['installed']['package_name'] ?? 'unknown') . PHP_EOL;
echo 'shared=' . ($panel['shared']['package_name'] ?? 'unknown') . PHP_EOL;
echo 'official=' . ($panel['official']['repository'] ?? 'unknown') . PHP_EOL;
