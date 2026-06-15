<?php
declare(strict_types=1);

const BASE_URL = 'http://127.0.0.1/OPUS_REF_BOOK';

function fail(string $message): never
{
    fwrite(STDERR, $message . PHP_EOL);
    exit(1);
}

function curl_get(string $url): string
{
    $command = 'curl.exe --noproxy "*" --http1.1 -fsS --connect-timeout 5 --max-time 60 -H "Connection: close" ' . escapeshellarg($url) . ' 2>&1';
    $output = [];
    $exitCode = 0;
    exec($command, $output, $exitCode);

    if ($exitCode !== 0) {
        fail('P114A_LIVE_FAIL: curl probe failed url=' . $url . ' exit=' . (string) $exitCode . ' output=' . implode("\n", $output));
    }

    $body = implode("\n", $output);
    if (trim($body) === '') {
        fail('P114A_LIVE_FAIL: empty response url=' . $url);
    }

    return $body;
}

$home = curl_get(BASE_URL . '/?lang=fr&theme=night');
foreach ([
    '<link rel="canonical" href="https://opus.logandplay.org/"',
    '<meta property="og:title"',
    '<script type="application/ld+json">',
    'Powered by Opus Framework',
    'Opus Framework · source-available · dual licensed',
] as $needle) {
    if (!str_contains($home, $needle)) {
        fail('P114A_LIVE_FAIL: home marker missing=' . $needle);
    }
}

$legal = curl_get(BASE_URL . '/?lang=fr&theme=night&page=legal');
foreach ([
    'Opus Framework',
    'source-available',
    'dual licensed',
    'Professional, commercial, SaaS',
    'Original author:',
] as $needle) {
    if (!str_contains($legal, $needle)) {
        fail('P114A_LIVE_FAIL: legal marker missing=' . $needle);
    }
}

$robots = curl_get(BASE_URL . '/robots.txt');
foreach ([
    'User-agent: *',
    'Disallow: /api/refbook/',
    'Sitemap: https://opus.logandplay.org/sitemap.xml',
] as $needle) {
    if (!str_contains($robots, $needle)) {
        fail('P114A_LIVE_FAIL: robots marker missing=' . $needle);
    }
}

$sitemap = curl_get(BASE_URL . '/sitemap.xml');
foreach ([
    '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
    '<loc>https://opus.logandplay.org/</loc>',
    '<loc>https://opus.logandplay.org/legal</loc>',
    'https://opus.logandplay.org/symbol-',
] as $needle) {
    if (!str_contains($sitemap, $needle)) {
        fail('P114A_LIVE_FAIL: sitemap marker missing=' . $needle);
    }
}

echo 'P114A_REFBOOK_PUBLIC_VISIBILITY_SEO_BRANDING_LIVE_SMOKE_OK' . PHP_EOL;
