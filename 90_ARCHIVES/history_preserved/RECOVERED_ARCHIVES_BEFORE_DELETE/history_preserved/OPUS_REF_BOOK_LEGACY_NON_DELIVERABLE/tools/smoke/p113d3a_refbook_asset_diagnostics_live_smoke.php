<?php
declare(strict_types=1);

$base = rtrim((string) (getenv('OPUS_REFBOOK_APP_BASE_URL') ?: 'http://127.0.0.1/OPUS_REF_BOOK'), '/');

function p113d3a_http_get(string $url, string $accept): array
{
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 20,
            'ignore_errors' => true,
            'header' => 'Accept: ' . $accept . "\r\n",
        ],
    ]);

    $body = @file_get_contents($url, false, $context);
    if (!is_string($body)) {
        throw new RuntimeException('HTTP_GET_FAILED=' . $url);
    }

    $status = isset($http_response_header[0]) && is_string($http_response_header[0]) ? $http_response_header[0] : '';
    if (!str_contains($status, ' 200 ')) {
        throw new RuntimeException('HTTP_STATUS_UNEXPECTED=' . $status . ' url=' . $url . ' body=' . substr($body, 0, 300));
    }

    return [$status, $body];
}

try {
    [, $jsonBody] = p113d3a_http_get($base . '/api/refbook/asset-integrity', 'application/json');
    $json = json_decode($jsonBody, true, 512, JSON_THROW_ON_ERROR);
    if (!is_array($json) || ($json['ok'] ?? null) !== true || ($json['api_version'] ?? null) !== 'opus-refbook-internal/v1') {
        throw new RuntimeException('ASSET_INTEGRITY_API_CONTRACT_INVALID');
    }

    $integrity = $json['asset_integrity'] ?? null;
    if (!is_array($integrity) || !array_key_exists('unique_missing_count', $integrity)) {
        throw new RuntimeException('ASSET_INTEGRITY_PAYLOAD_INVALID');
    }

    [, $html] = p113d3a_http_get($base . '/?page=asset-diagnostics', 'text/html');
    foreach (['Diagnostics assets documentaires', 'Assets uniques manquants', 'api/refbook/asset-integrity'] as $needle) {
        if (!str_contains($html, $needle)) {
            throw new RuntimeException('ASSET_DIAGNOSTICS_PAGE_MISSING=' . $needle);
        }
    }

    echo 'P113D3A_REFBOOK_ASSET_DIAGNOSTICS_LIVE_SMOKE_OK' . PHP_EOL;
} catch (Throwable $exception) {
    fwrite(STDERR, 'P113D3A_LIVE_SMOKE_FAIL: ' . $exception->getMessage() . PHP_EOL);
    exit(1);
}
