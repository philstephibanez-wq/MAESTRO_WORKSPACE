<?php
declare(strict_types=1);

$root = realpath(__DIR__ . '/../..');
if ($root === false) {
    fwrite(STDERR, "P114C3U_SMOKE_FAIL: root not found\n");
    exit(1);
}

$failures = [];

$contentService = $root . '/application/reference/Service/ReferenceContentService.php';
$text = is_file($contentService) ? (string) file_get_contents($contentService) : '';
if (strpos($text, 'P114C3U_CZECH_JSON_LABELS_SOURCE') === false) {
    $failures[] = 'Czech JSON runtime-label source marker missing';
}

$cs = is_file($root . '/content/refbook/i18n/cs.json')
    ? json_decode((string) file_get_contents($root . '/content/refbook/i18n/cs.json'), true)
    : null;
if (!is_array($cs)) {
    $failures[] = 'cs.json invalid';
} else {
    $expected = [
        'labels.language.apply' => 'Použít',
        'labels.sidebar.legal' => 'Právní informace',
        'labels.sidebar.download_install' => 'Stáhnout / nainstalovat',
    ];
    foreach ($expected as $path => $expectedValue) {
        $cursor = $cs;
        foreach (explode('.', $path) as $segment) {
            if (!is_array($cursor) || !array_key_exists($segment, $cursor)) {
                $failures[] = 'missing ' . $path;
                continue 2;
            }
            $cursor = $cursor[$segment];
        }
        if ($cursor !== $expectedValue) {
            $failures[] = 'wrong ' . $path;
        }
    }
}

$css = is_file($root . '/public/assets/css/refbook-install.css')
    ? (string) file_get_contents($root . '/public/assets/css/refbook-install.css')
    : '';
if (strpos($css, 'P114C3U') === false || strpos($css, 'margin-left: clamp(3rem, 7vw, 10rem);') === false) {
    $failures[] = 'P114C3U header position CSS missing';
}

$layout = is_file($root . '/application/reference/templates/layout.twig')
    ? (string) file_get_contents($root . '/application/reference/templates/layout.twig')
    : '';
if (strpos($layout, 'refbook-install.css?v=P114C3U') === false) {
    $failures[] = 'layout install CSS cache key not P114C3U';
}

if ($failures !== []) {
    echo "P114C3U_REFBOOK_CZECH_RUNTIME_AND_HEADER_FORCE_FAIL\n";
    foreach ($failures as $i => $failure) {
        echo str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT) . ' ' . $failure . "\n";
    }
    exit(1);
}

echo "P114C3U_REFBOOK_CZECH_RUNTIME_AND_HEADER_FORCE_OK\n";
