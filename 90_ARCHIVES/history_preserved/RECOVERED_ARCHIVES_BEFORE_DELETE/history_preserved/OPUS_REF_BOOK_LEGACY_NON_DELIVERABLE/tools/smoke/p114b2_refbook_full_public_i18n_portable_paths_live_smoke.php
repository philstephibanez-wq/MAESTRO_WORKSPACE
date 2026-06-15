<?php
declare(strict_types=1);
$root = dirname(__DIR__, 2);
function fail(string $message): never { fwrite(STDERR, $message . PHP_EOL); exit(1); }
$base = 'http://127.0.0.1/OPUS_REF_BOOK/';
foreach (['de','uk','it','pl'] as $lang) {
    $url = $base . '?lang=' . rawurlencode($lang) . '&theme=paper&page=api-reference';
    $command = 'curl.exe -L --max-time 25 --silent --show-error ' . escapeshellarg($url);
    $output = [];
    $exitCode = 0;
    exec($command, $output, $exitCode);
    $body = implode("\n", $output);
    if ($exitCode !== 0 || trim($body) === '') fail('P114B2_LIVE_FAIL: curl probe failed lang=' . $lang . ' exit=' . $exitCode . ' output=' . $body);
    if (str_contains($body, 'OPUS_REFBOOK_LANG_UNSUPPORTED=' . $lang)) fail('P114B2_LIVE_FAIL: unsupported language=' . $lang);
    if (!str_contains($body, '<OPUS_ROOT>') && str_contains($body, 'H:\\')) fail('P114B2_LIVE_FAIL: local path leaked lang=' . $lang);
}
echo "P114B2_REFBOOK_FULL_PUBLIC_I18N_PORTABLE_PATHS_LIVE_SMOKE_OK\n";
