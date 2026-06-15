<?php
declare(strict_types=1);

$base = rtrim((string) (getenv('OPUS_REFBOOK_APP_BASE_URL') ?: 'http://127.0.0.1/OPUS_REF_BOOK'), '/');
$url = $base . '/api/refbook/health';

$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'timeout' => 20,
        'ignore_errors' => true,
        'header' => "Accept: application/json\r\n",
    ],
]);

$body = @file_get_contents($url, false, $context);
if (!is_string($body)) {
    fwrite(STDERR, 'P113D2R1_LIVE_FAIL: HTTP_GET_FAILED=' . $url . PHP_EOL);
    exit(1);
}

$status = isset($http_response_header[0]) && is_string($http_response_header[0]) ? $http_response_header[0] : '';
if (!str_contains($status, ' 200 ')) {
    fwrite(STDERR, 'P113D2R1_LIVE_FAIL: HTTP_STATUS_UNEXPECTED=' . $status . ' url=' . $url . PHP_EOL);
    fwrite(STDERR, $body . PHP_EOL);
    exit(1);
}

try {
    $json = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
} catch (Throwable $exception) {
    fwrite(STDERR, 'P113D2R1_LIVE_FAIL: JSON_INVALID=' . $exception->getMessage() . PHP_EOL);
    exit(1);
}

if (!is_array($json) || ($json['ok'] ?? null) !== true || ($json['api_version'] ?? null) !== 'opus-refbook-internal/v1') {
    fwrite(STDERR, 'P113D2R1_LIVE_FAIL: HEALTH_CONTRACT_INVALID' . PHP_EOL);
    exit(1);
}

echo 'P113D2R1_REFBOOK_WEB_REWRITE_LIVE_SMOKE_OK' . PHP_EOL;
