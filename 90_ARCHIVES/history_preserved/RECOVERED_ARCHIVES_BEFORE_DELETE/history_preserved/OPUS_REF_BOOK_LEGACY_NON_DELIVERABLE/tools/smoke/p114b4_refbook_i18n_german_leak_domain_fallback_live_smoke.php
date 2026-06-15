<?php

declare(strict_types=1);

$base = 'http://127.0.0.1/OPUS_REF_BOOK/';
$cases = [
    ['pl', 'paper', 'api-reference'],
    ['uk', 'paper', 'asset-diagnostics'],
    ['it', 'paper', 'symbol-6'],
    ['de', 'ocean', 'legal'],
];
$badMarkers = ['OPUS_REFBOOK_LANG_UNSUPPORTED', '[*', 'H:\OPUS', 'H:/OPUS'];
$badNonGerman = ['Blaue Nacht', 'Helles Papier', 'Dokumentationspipeline', 'erkannte Domänen', 'Domänenindikatoren', 'Symbolprofil', 'Vertrag'];

foreach ($cases as [$lang, $theme, $page]) {
    $url = $base . '?lang=' . rawurlencode($lang) . '&theme=' . rawurlencode($theme) . '&page=' . rawurlencode($page);
    $cmd = 'curl.exe --silent --show-error --location --max-time 25 ' . escapeshellarg($url);
    $out = [];
    $exit = 0;
    exec($cmd, $out, $exit);
    $body = implode("\n", $out);
    if ($exit !== 0 || trim($body) === '') {
        fwrite(STDERR, 'P114B4_LIVE_FAIL: curl failed lang=' . $lang . ' exit=' . $exit . PHP_EOL);
        exit(1);
    }
    foreach ($badMarkers as $bad) {
        if (str_contains($body, $bad)) {
            fwrite(STDERR, 'P114B4_LIVE_FAIL: forbidden marker=' . $bad . ' lang=' . $lang . PHP_EOL);
            exit(1);
        }
    }
    if (in_array($lang, ['uk', 'it', 'pl'], true)) {
        foreach ($badNonGerman as $bad) {
            if (str_contains($body, $bad)) {
                fwrite(STDERR, 'P114B4_LIVE_FAIL: german label leak=' . $lang . ':' . $bad . PHP_EOL);
                exit(1);
            }
        }
    }
}

echo 'P114B4_REFBOOK_I18N_GERMAN_LEAK_DOMAIN_FALLBACK_LIVE_SMOKE_OK' . PHP_EOL;
