<?php

declare(strict_types=1);

$base = 'http://127.0.0.1/OPUS_REF_BOOK/';
$cases = [
    ['pl', 'paper', 'api-reference'],
    ['uk', 'paper', 'asset-diagnostics'],
    ['it', 'paper', 'symbol-6'],
    ['de', 'ocean', 'legal'],
];

foreach ($cases as [$lang, $theme, $page]) {
    $url = $base . '?lang=' . rawurlencode($lang) . '&theme=' . rawurlencode($theme) . '&page=' . rawurlencode($page);
    $cmd = 'curl.exe --silent --show-error --location --max-time 25 ' . escapeshellarg($url);
    $output = [];
    $exit = 0;
    exec($cmd, $output, $exit);
    $body = implode("\n", $output);

    if ($exit !== 0 || trim($body) === '') {
        fwrite(STDERR, 'P114B3_LIVE_FAIL: curl failed lang=' . $lang . ' exit=' . $exit . PHP_EOL);
        exit(1);
    }

    foreach (['OPUS_REFBOOK_LANG_UNSUPPORTED', '[*', 'H:\\Opus', 'H:/OPUS'] as $bad) {
        if (str_contains($body, $bad)) {
            fwrite(STDERR, 'P114B3_LIVE_FAIL: forbidden marker=' . $bad . ' lang=' . $lang . PHP_EOL);
            exit(1);
        }
    }

    if (in_array($lang, ['uk', 'it', 'pl'], true)) {
        foreach (['Symbolprofil', 'Vertrag', 'Quelle', 'Öffentliche'] as $bad) {
            if (str_contains($body, $bad)) {
                fwrite(STDERR, 'P114B3_LIVE_FAIL: German label leak=' . $lang . ':' . $bad . PHP_EOL);
                exit(1);
            }
        }
    }
}

echo 'P114B3_REFBOOK_I18N_TEMPLATE_PATHS_LIGHT_THEME_LIVE_SMOKE_OK' . PHP_EOL;
