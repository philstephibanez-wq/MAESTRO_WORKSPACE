<?php
declare(strict_types=1);

$root = dirname(__DIR__, 2);
$file = $root . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . '.htaccess';

if (!is_file($file)) {
    fwrite(STDERR, 'P113D2R1_STATIC_FAIL: HTACCESS_MISSING=' . $file . PHP_EOL);
    exit(1);
}

$content = file_get_contents($file);
if (!is_string($content)) {
    fwrite(STDERR, 'P113D2R1_STATIC_FAIL: HTACCESS_READ_FAILED=' . $file . PHP_EOL);
    exit(1);
}

$required = [
    'RewriteEngine On',
    'RewriteBase /OPUS_REF_BOOK/',
    'RewriteRule ^ index.php [QSA,L]',
];

foreach ($required as $needle) {
    if (!str_contains($content, $needle)) {
        fwrite(STDERR, 'P113D2R1_STATIC_FAIL: HTACCESS_RULE_MISSING=' . $needle . PHP_EOL);
        exit(1);
    }
}

$forbidden = [
    'framework/Opus',
    'api_reference.generated.json',
];

foreach ($forbidden as $needle) {
    if (str_contains($content, $needle)) {
        fwrite(STDERR, 'P113D2R1_STATIC_FAIL: FORBIDDEN_FALLBACK_REFERENCE=' . $needle . PHP_EOL);
        exit(1);
    }
}

echo 'P113D2R1_REFBOOK_WEB_REWRITE_STATIC_SMOKE_OK' . PHP_EOL;
