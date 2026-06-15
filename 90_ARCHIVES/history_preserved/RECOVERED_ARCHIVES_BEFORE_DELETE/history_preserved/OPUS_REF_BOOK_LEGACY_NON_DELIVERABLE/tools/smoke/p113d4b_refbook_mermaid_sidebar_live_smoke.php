<?php
declare(strict_types=1);

const SNAPSHOT_URL = 'http://127.0.0.1/OPUS_REF_BOOK/api/refbook/snapshot';
const HOME_URL = 'http://127.0.0.1/OPUS_REF_BOOK/';

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
        fail('P113D4B_LIVE_FAIL: curl probe failed url=' . $url . ' exit=' . (string) $exitCode . ' output=' . implode("\n", $output));
    }

    $body = implode("\n", $output);
    if (trim($body) === '') {
        fail('P113D4B_LIVE_FAIL: empty response url=' . $url);
    }

    return $body;
}

$snapshotBody = curl_get(SNAPSHOT_URL);
$snapshot = json_decode($snapshotBody, true);
if (!is_array($snapshot)) {
    fail('P113D4B_LIVE_FAIL: snapshot JSON invalid');
}

if (($snapshot['schema'] ?? null) !== 'OPUS_REFBOOK_RUNTIME_MANIFEST_V1') {
    fail('P113D4B_LIVE_FAIL: snapshot schema invalid');
}

$diagrams = $snapshot['documentation_assets']['diagrams'] ?? null;
if (!is_array($diagrams)) {
    fail('P113D4B_LIVE_FAIL: snapshot diagrams missing');
}

$diagramIds = [];
foreach ($diagrams as $diagram) {
    if (is_array($diagram) && isset($diagram['id'])) {
        $diagramIds[(string) $diagram['id']] = true;
    }
}

foreach (['fsm-runtime', 'acl-runtime', 'http-runtime', 'routing-runtime', 'secure-dispatch-runtime'] as $requiredDiagram) {
    if (!isset($diagramIds[$requiredDiagram])) {
        fail('P113D4B_LIVE_FAIL: required diagram missing=' . $requiredDiagram);
    }
}

$home = curl_get(HOME_URL);
foreach ([
    'refbook-runtime.css?v=P113D4B',
    'refbook-sidebar-state.js?v=P113D4B',
    'data-refbook-sidebar-state',
] as $needle) {
    if (!str_contains($home, $needle)) {
        fail('P113D4B_LIVE_FAIL: home marker missing=' . $needle);
    }
}

echo 'P113D4B_REFBOOK_MERMAID_SIDEBAR_LIVE_SMOKE_OK' . PHP_EOL;
