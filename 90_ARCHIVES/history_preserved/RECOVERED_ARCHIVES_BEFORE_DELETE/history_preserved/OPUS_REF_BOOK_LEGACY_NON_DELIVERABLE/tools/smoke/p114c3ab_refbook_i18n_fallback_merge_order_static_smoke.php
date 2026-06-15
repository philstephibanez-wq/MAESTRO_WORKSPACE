<?php
declare(strict_types=1);

$root = realpath(__DIR__ . '/../..');
if ($root === false) {
    fwrite(STDERR, "P114C3AB_SMOKE_FAIL: root not found\n");
    exit(1);
}

$failures = [];

$content = is_file($root . '/application/reference/Service/ReferenceContentService.php')
    ? (string) file_get_contents($root . '/application/reference/Service/ReferenceContentService.php')
    : '';

foreach ([
    'templateUiFallbackLabels',
    '⚠[',
    'return array_replace_recursive($this->publicUiLabels(), $labels);',
    'return array_replace_recursive($this->templateUiFallbackLabels(), $labels[$this->language] ?? $labels[self::DEFAULT_LANGUAGE]);',
] as $needle) {
    if (strpos($content, $needle) === false) {
        $failures[] = 'ReferenceContentService missing ' . $needle;
    }
}

foreach (['⚠ I18N_MISSING:', '⚠ I18N:'] as $legacy) {
    if (strpos($content, $legacy) !== false) {
        $failures[] = 'legacy marker still present in ReferenceContentService: ' . $legacy;
    }
}

$layout = is_file($root . '/application/reference/templates/layout.twig')
    ? (string) file_get_contents($root . '/application/reference/templates/layout.twig')
    : '';
foreach ([
    'refbook-i18n-missing.css?v=P114C3AB',
    'refbook-i18n-missing.js?v=P114C3AB',
] as $needle) {
    if (strpos($layout, $needle) === false) {
        $failures[] = 'layout missing ' . $needle;
    }
}

$js = is_file($root . '/public/assets/js/refbook-i18n-missing.js')
    ? (string) file_get_contents($root . '/public/assets/js/refbook-i18n-missing.js')
    : '';
if (strpos($js, 'P114C3AB_COMPACT_ALERT') === false || strpos($js, '"⚠["') === false) {
    $failures[] = 'JS compact alert support missing';
}
if (strpos($js, '⛔') !== false) {
    $failures[] = 'no-entry icon still present in JS';
}

$css = is_file($root . '/public/assets/css/refbook-i18n-missing.css')
    ? (string) file_get_contents($root . '/public/assets/css/refbook-i18n-missing.css')
    : '';
if (strpos($css, 'P114C3AB') === false) {
    $failures[] = 'CSS compact alert marker missing';
}
if (strpos($css, '⛔') !== false) {
    $failures[] = 'no-entry icon still present in CSS';
}

if ($failures !== []) {
    echo "P114C3AB_REFBOOK_I18N_FALLBACK_MERGE_ORDER_FAIL\n";
    foreach ($failures as $i => $failure) {
        echo str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT) . ' ' . $failure . "\n";
    }
    exit(1);
}

echo "P114C3AB_REFBOOK_I18N_FALLBACK_MERGE_ORDER_OK\n";
