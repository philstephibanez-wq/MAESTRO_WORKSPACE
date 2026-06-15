<?php
declare(strict_types=1);

$base = rtrim((string) (getenv('OPUS_REFBOOK_APP_BASE_URL') ?: 'http://127.0.0.1/OPUS_REF_BOOK'), '/');

/**
 * @return array<string,mixed>
 */
function p113d2r_get_json(string $url): array
{
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
        throw new RuntimeException('HTTP_GET_FAILED=' . $url);
    }

    $status = '';
    if (isset($http_response_header[0]) && is_string($http_response_header[0])) {
        $status = $http_response_header[0];
    }

    if (!str_contains($status, ' 200 ') && !str_contains($status, ' 400 ') && !str_contains($status, ' 404 ')) {
        throw new RuntimeException('HTTP_STATUS_UNEXPECTED=' . $status . ' url=' . $url);
    }

    try {
        $json = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    } catch (Throwable $exception) {
        throw new RuntimeException('JSON_INVALID=' . $url . ' detail=' . $exception->getMessage());
    }

    if (!is_array($json)) {
        throw new RuntimeException('JSON_ROOT_INVALID=' . $url);
    }

    return $json;
}

try {
    $health = p113d2r_get_json($base . '/api/refbook/health');
    if (($health['ok'] ?? null) !== true || ($health['api_version'] ?? null) !== 'opus-refbook-internal/v1') {
        throw new RuntimeException('HEALTH_CONTRACT_INVALID');
    }

    $snapshot = p113d2r_get_json($base . '/api/refbook/snapshot');
    if (($snapshot['schema'] ?? null) !== 'OPUS_REFBOOK_RUNTIME_MANIFEST_V1') {
        throw new RuntimeException('SNAPSHOT_SCHEMA_INVALID=' . (string) ($snapshot['schema'] ?? 'missing'));
    }

    if (!isset($snapshot['symbols']) || !is_array($snapshot['symbols']) || count($snapshot['symbols']) < 1) {
        throw new RuntimeException('SNAPSHOT_SYMBOLS_EMPTY');
    }

    $domains = p113d2r_get_json($base . '/api/refbook/domains');
    if (($domains['ok'] ?? null) !== true || !isset($domains['domains']) || !is_array($domains['domains'])) {
        throw new RuntimeException('DOMAINS_CONTRACT_INVALID');
    }

    $classes = p113d2r_get_json($base . '/api/refbook/classes');
    if (($classes['ok'] ?? null) !== true || !isset($classes['classes']) || !is_array($classes['classes'])) {
        throw new RuntimeException('CLASSES_CONTRACT_INVALID');
    }

    $class = p113d2r_get_json($base . '/api/refbook/class?fqcn=' . rawurlencode('Opus\\Http\\Request'));
    if (($class['ok'] ?? null) !== true || (($class['class']['symbol'] ?? null) !== 'Opus\\Http\\Request')) {
        throw new RuntimeException('CLASS_CONTRACT_INVALID');
    }

    echo 'P113D2R_REFBOOK_FSM_INTERNAL_API_LIVE_SMOKE_OK' . PHP_EOL;
} catch (Throwable $exception) {
    fwrite(STDERR, 'P113D2R_LIVE_SMOKE_FAIL: ' . $exception->getMessage() . PHP_EOL);
    exit(1);
}
