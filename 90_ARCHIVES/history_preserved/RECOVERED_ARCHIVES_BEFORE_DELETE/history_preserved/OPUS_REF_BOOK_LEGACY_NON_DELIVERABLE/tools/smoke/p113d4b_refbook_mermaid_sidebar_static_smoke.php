<?php
declare(strict_types=1);

$root = dirname(__DIR__, 2);
$required = [
    $root . '/application/reference/Service/ReferenceDiagramModelBuilder.php',
    $root . '/application/reference/Service/ReferenceCatalogService.php',
    $root . '/application/reference/templates/pages/symbol.twig',
    $root . '/application/reference/templates/layout.twig',
    $root . '/public/assets/css/refbook-runtime.css',
    $root . '/public/assets/js/refbook-sidebar-state.js',
];

foreach ($required as $file) {
    if (!is_file($file)) {
        fwrite(STDERR, 'P113D4B_STATIC_FAIL: missing file ' . $file . PHP_EOL);
        exit(1);
    }
}

$builder = file_get_contents($root . '/application/reference/Service/ReferenceDiagramModelBuilder.php') ?: '';
$symbol = file_get_contents($root . '/application/reference/templates/pages/symbol.twig') ?: '';
$layout = file_get_contents($root . '/application/reference/templates/layout.twig') ?: '';
$css = file_get_contents($root . '/public/assets/css/refbook-runtime.css') ?: '';
$js = file_get_contents($root . '/public/assets/js/refbook-sidebar-state.js') ?: '';

$checks = [
    'flowchart parser LR/TD' => str_contains($builder, "preg_match('/^flowchart"),
    'svg view model' => str_contains($builder, "'svg' => ["),
    'state diagram still supported' => str_contains($builder, "stateDiagram-v2"),
    'twig svg renderer' => str_contains($symbol, '<svg class="diagram-svg"'),
    'twig flow/state data format' => str_contains($symbol, 'data-diagram-format'),
    'old row renderer removed' => !str_contains($symbol, 'state-transition-row'),
    'sidebar persistence hook' => str_contains($layout, 'data-refbook-sidebar-state'),
    'symbol page opens domains' => str_contains($layout, 'isSymbolPage'),
    'sidebar js script' => str_contains($layout, 'refbook-sidebar-state.js'),
    'sidebar localStorage' => str_contains($js, 'localStorage'),
    'svg css' => str_contains($css, '.refbook-mermaid-diagram') && str_contains($css, '.diagram-svg'),
];

foreach ($checks as $label => $ok) {
    if (!$ok) {
        fwrite(STDERR, 'P113D4B_STATIC_FAIL: ' . $label . PHP_EOL);
        exit(1);
    }
}

$cmd = PHP_BINARY . ' -l ' . escapeshellarg($root . '/application/reference/Service/ReferenceDiagramModelBuilder.php');
exec($cmd, $output, $code);
if ($code !== 0) {
    fwrite(STDERR, 'P113D4B_STATIC_FAIL: PHP lint ReferenceDiagramModelBuilder' . PHP_EOL . implode(PHP_EOL, $output) . PHP_EOL);
    exit(1);
}

$cmd = PHP_BINARY . ' -l ' . escapeshellarg($root . '/application/reference/Service/ReferenceCatalogService.php');
exec($cmd, $output, $code);
if ($code !== 0) {
    fwrite(STDERR, 'P113D4B_STATIC_FAIL: PHP lint ReferenceCatalogService' . PHP_EOL . implode(PHP_EOL, $output) . PHP_EOL);
    exit(1);
}

echo 'P113D4B_REFBOOK_MERMAID_SIDEBAR_STATIC_SMOKE_OK' . PHP_EOL;
