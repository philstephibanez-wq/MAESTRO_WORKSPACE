<?php
declare(strict_types=1);

const SNAPSHOT_URL = 'http://127.0.0.1/OPUS_REF_BOOK/api/refbook/snapshot';
const FSM_DOMAIN_URL = 'http://127.0.0.1/OPUS_REF_BOOK/?lang=fr&theme=night&page=domain-fsm';

function fail(string $message): never
{
    fwrite(STDERR, $message . PHP_EOL);
    exit(1);
}

function curl_get(string $url): string
{
    $command = 'curl.exe -fsS --max-time 20 ' . escapeshellarg($url) . ' 2>&1';
    $output = [];
    $exitCode = 0;
    exec($command, $output, $exitCode);

    if ($exitCode !== 0) {
        fail('P113D4C_LIVE_FAIL: curl probe failed url=' . $url . ' exit=' . (string) $exitCode . ' output=' . implode("\n", $output));
    }

    $body = implode("\n", $output);
    if (trim($body) === '') {
        fail('P113D4C_LIVE_FAIL: empty response url=' . $url);
    }

    return $body;
}

$snapshotBody = curl_get(SNAPSHOT_URL);
$snapshot = json_decode($snapshotBody, true);
if (!is_array($snapshot)) {
    fail('P113D4C_LIVE_FAIL: snapshot JSON invalid');
}

if (($snapshot['schema'] ?? null) !== 'OPUS_REFBOOK_RUNTIME_MANIFEST_V1') {
    fail('P113D4C_LIVE_FAIL: snapshot schema invalid');
}

$symbols = $snapshot['symbols'] ?? null;
if (!is_array($symbols)) {
    fail('P113D4C_LIVE_FAIL: snapshot symbols missing');
}

$hasFsmSymbol = false;
foreach ($symbols as $symbol) {
    if (is_array($symbol) && (($symbol['domain'] ?? null) === 'FSM')) {
        $hasFsmSymbol = true;
        break;
    }
}
if (!$hasFsmSymbol) {
    fail('P113D4C_LIVE_FAIL: no FSM symbol in snapshot');
}

$fsmPage = curl_get(FSM_DOMAIN_URL);
foreach ([
    'data-refbook-nav-group="domains"',
    'page=domain-fsm',
    'FSM',
] as $needle) {
    if (!str_contains($fsmPage, $needle)) {
        fail('P113D4C_LIVE_FAIL: FSM domain page marker missing=' . $needle);
    }
}

echo 'P113D4C_REFBOOK_SIDEBAR_ACTIVE_CONTEXT_LIVE_SMOKE_OK' . PHP_EOL;
