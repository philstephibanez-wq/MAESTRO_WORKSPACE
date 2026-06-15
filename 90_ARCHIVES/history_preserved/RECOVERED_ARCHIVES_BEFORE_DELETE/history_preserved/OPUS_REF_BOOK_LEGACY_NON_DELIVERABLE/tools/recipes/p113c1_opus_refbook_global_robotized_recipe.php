<?php

declare(strict_types=1);

/**
 * P113C1 OPUS_REF_BOOK global robotized recipe.
 *
 * Scope:
 *   OPUS_REF_BOOK application only.
 *
 * Contract:
 *   - validates the public bootstrap boundary;
 *   - validates the site route/security configuration is present;
 *   - validates the RefBook header/search/theme/language UI contract markers;
 *   - validates the local Chrome extension as Manifest V3 and local-only;
 *   - writes JSON/MD/HTML reports under var/reports;
 *   - fails explicitly, never silently skips required checks.
 */
$root = dirname(__DIR__, 2);
$palier = 'P113C1_OPUS_REFBOOK_GLOBAL_ROBOTIZED_RECIPE';
$reportRoot = $root . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . 'p113c1_opus_refbook_global_robotized_recipe';
ensureDirectory($reportRoot, $palier);

$checks = [];

requireFile($root, 'public/index.php', $checks);
requireFile($root, 'bootstrap/autoload.php', $checks);
requireFile($root, 'sites/opus-reference/site.xml', $checks);
requireFile($root, 'sites/opus-reference/routes.xml', $checks);
requireFile($root, 'sites/opus-reference/security.xml', $checks);
requireFile($root, 'application/reference/templates/layout.twig', $checks);
requireFile($root, 'public/assets/css/refbook.css', $checks);

requireFile($root, 'tools/chrome_extension/opus_refbook_robot/manifest.json', $checks);
requireFile($root, 'tools/chrome_extension/opus_refbook_robot/content.js', $checks);
requireFile($root, 'tools/chrome_extension/opus_refbook_robot/popup.html', $checks);
requireFile($root, 'tools/chrome_extension/opus_refbook_robot/popup.css', $checks);
requireFile($root, 'tools/chrome_extension/opus_refbook_robot/popup.js', $checks);
requireFile($root, 'tools/chrome_extension/opus_refbook_robot/README.md', $checks);

$index = readText($root, 'public/index.php');
assertContains($index, "'bootstrap'", 'P113C1_INDEX_BOOTSTRAP_DIR_MARKER_MISSING', $checks);
assertContains($index, "'autoload.php'", 'P113C1_INDEX_AUTOLOAD_MARKER_MISSING', $checks);
assertContains($index, 'Opus\Application\Application', 'P113C1_INDEX_APPLICATION_RUNTIME_MISSING', $checks);
assertNotContains($index, 'new Opus\Routing\Router', 'P113C1_INDEX_ROUTING_DECISION_FORBIDDEN', $checks);
assertNotContains($index, 'TwigTemplateRenderer', 'P113C1_INDEX_RENDERING_DECISION_FORBIDDEN', $checks);

$siteXml = readText($root, 'sites/opus-reference/site.xml');
assertContains($siteXml, '<basePath>/OPUS_REF_BOOK</basePath>', 'P113C1_SITE_BASEPATH_MISSING', $checks);
assertContains($siteXml, '<routes file="routes.xml"', 'P113C1_SITE_ROUTES_DECLARATION_MISSING', $checks);
assertContains($siteXml, '<security file="security.xml"', 'P113C1_SITE_SECURITY_DECLARATION_MISSING', $checks);

$routesXml = readText($root, 'sites/opus-reference/routes.xml');
assertContains($routesXml, 'refbook_home', 'P113C1_ROUTES_HOME_MISSING', $checks);
assertContains($routesXml, 'refbook_api_reference', 'P113C1_ROUTES_API_REFERENCE_MISSING', $checks);
assertContains($routesXml, 'refbook_page', 'P113C1_ROUTES_PAGE_MISSING', $checks);
assertValidXml($root, 'sites/opus-reference/site.xml', $checks);
assertValidXml($root, 'sites/opus-reference/routes.xml', $checks);
assertValidXml($root, 'sites/opus-reference/security.xml', $checks);

$layout = readText($root, 'application/reference/templates/layout.twig');
assertContains($layout, 'class="site-header"', 'P113C1_LAYOUT_HEADER_MISSING', $checks);
assertContains($layout, 'class="top-search"', 'P113C1_LAYOUT_SEARCH_MISSING', $checks);
assertContains($layout, 'class="theme-switcher segmented-switcher"', 'P113C1_LAYOUT_THEME_SWITCHER_MISSING', $checks);
assertContains($layout, 'class="language-switcher segmented-switcher"', 'P113C1_LAYOUT_LANGUAGE_SWITCHER_MISSING', $checks);
assertContains($layout, 'aria-label="{{ ui.language.current }}"', 'P113C1_LAYOUT_LANGUAGE_ARIA_MISSING', $checks);

$css = readText($root, 'public/assets/css/refbook.css');
assertContains($css, '.site-header', 'P113C1_CSS_HEADER_MISSING', $checks);
assertContains($css, '.top-search', 'P113C1_CSS_SEARCH_MISSING', $checks);
assertContains($css, '.language-switcher', 'P113C1_CSS_LANGUAGE_SWITCHER_MISSING', $checks);
assertContains($css, '.theme-switcher', 'P113C1_CSS_THEME_SWITCHER_MISSING', $checks);

$manifest = readJson($root, 'tools/chrome_extension/opus_refbook_robot/manifest.json');
assertSameValue($manifest['manifest_version'] ?? null, 3, 'P113C1_EXTENSION_MANIFEST_V3_REQUIRED', $checks);
assertSameValue($manifest['name'] ?? null, 'Opus RefBook Robot', 'P113C1_EXTENSION_NAME_INVALID', $checks);
assertContains((string)($manifest['action']['default_popup'] ?? ''), 'popup.html', 'P113C1_EXTENSION_POPUP_MISSING', $checks);

$contentScripts = $manifest['content_scripts'] ?? null;
if (!is_array($contentScripts) || !isset($contentScripts[0]) || !is_array($contentScripts[0])) {
    fail('P113C1_EXTENSION_CONTENT_SCRIPTS_MISSING', $checks);
}
$matches = $contentScripts[0]['matches'] ?? [];
if (!is_array($matches)) {
    fail('P113C1_EXTENSION_MATCHES_INVALID', $checks);
}
assertArrayContains($matches, 'http://127.0.0.1/OPUS_REF_BOOK/*', 'P113C1_EXTENSION_127_MATCH_MISSING', $checks);
assertArrayContains($matches, 'http://localhost/OPUS_REF_BOOK/*', 'P113C1_EXTENSION_LOCALHOST_MATCH_MISSING', $checks);
foreach ($matches as $match) {
    if (!is_string($match) || !str_starts_with($match, 'http://127.0.0.1/OPUS_REF_BOOK/') && !str_starts_with($match, 'http://localhost/OPUS_REF_BOOK/')) {
        fail('P113C1_EXTENSION_NON_LOCAL_MATCH_FORBIDDEN: ' . (string)$match, $checks);
    }
}

$permissions = $manifest['permissions'] ?? [];
if (!is_array($permissions)) {
    fail('P113C1_EXTENSION_PERMISSIONS_INVALID', $checks);
}
if (count($permissions) !== 0) {
    fail('P113C1_EXTENSION_PERMISSIONS_MUST_STAY_EMPTY', $checks);
}
if (isset($manifest['host_permissions'])) {
    fail('P113C1_EXTENSION_HOST_PERMISSIONS_FORBIDDEN', $checks);
}

$contentJs = readText($root, 'tools/chrome_extension/opus_refbook_robot/content.js');
assertContains($contentJs, 'OPUS_REFBOOK_ROBOT', 'P113C1_EXTENSION_CONTENT_MARKER_MISSING', $checks);
assertContains($contentJs, '.site-header', 'P113C1_EXTENSION_HEADER_CHECK_MISSING', $checks);
assertContains($contentJs, '.language-switcher', 'P113C1_EXTENSION_LANGUAGE_CHECK_MISSING', $checks);
assertContains($contentJs, '.theme-switcher', 'P113C1_EXTENSION_THEME_CHECK_MISSING', $checks);
assertContains($contentJs, '.top-search', 'P113C1_EXTENSION_SEARCH_CHECK_MISSING', $checks);

$popupHtml = readText($root, 'tools/chrome_extension/opus_refbook_robot/popup.html');
assertContains($popupHtml, 'Opus RefBook Robot', 'P113C1_EXTENSION_POPUP_TITLE_MISSING', $checks);
assertContains($popupHtml, 'http://127.0.0.1/OPUS_REF_BOOK/', 'P113C1_EXTENSION_POPUP_127_LINK_MISSING', $checks);
assertContains($popupHtml, 'popup.css', 'P113C1_EXTENSION_POPUP_CSS_MISSING', $checks);
assertContains($popupHtml, 'popup.js', 'P113C1_EXTENSION_POPUP_JS_MISSING', $checks);

$failed = array_values(array_filter($checks, static fn (array $check): bool => $check['status'] !== 'OK'));
$report = [
    'summary' => [
        'palier' => $palier,
        'status' => count($failed) === 0 ? 'OK' : 'FAILED',
        'total_checks' => count($checks),
        'failed_checks' => count($failed),
        'generated_at' => date('c'),
    ],
    'checks' => $checks,
];

$timestamp = date('Ymd_His');
$base = $reportRoot . DIRECTORY_SEPARATOR . $palier . '_' . $timestamp;
writeJson($base . '.json', $report, $palier);
writeText($base . '.md', buildMarkdown($report), $palier);
writeText($base . '.html', buildHtml($report), $palier);
writeJson($reportRoot . DIRECTORY_SEPARATOR . 'latest.json', $report, $palier);
writeText($reportRoot . DIRECTORY_SEPARATOR . 'latest.md', buildMarkdown($report), $palier);
writeText($reportRoot . DIRECTORY_SEPARATOR . 'latest.html', buildHtml($report), $palier);

if (count($failed) > 0) {
    fwrite(STDERR, 'P113C1_OPUS_REFBOOK_GLOBAL_ROBOTIZED_RECIPE_FAILED' . PHP_EOL);
    foreach ($failed as $check) {
        fwrite(STDERR, '- ' . $check['id'] . PHP_EOL);
    }
    exit(1);
}

echo 'P113C1_OPUS_REFBOOK_GLOBAL_ROBOTIZED_RECIPE_OK' . PHP_EOL;
exit(0);

/** @param array<int,array<string,string>> $checks */
function addCheck(array &$checks, string $id, string $status, string $detail = ''): void
{
    $checks[] = ['id' => $id, 'status' => $status, 'detail' => $detail];
}

/** @param array<int,array<string,string>> $checks */
function requireFile(string $root, string $relative, array &$checks): void
{
    $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    if (!is_file($path)) {
        fail('FILE_MISSING: ' . $relative, $checks);
    }
    addCheck($checks, 'FILE_PRESENT: ' . $relative, 'OK');
}

function readText(string $root, string $relative): string
{
    $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    $content = file_get_contents($path);
    if (!is_string($content)) {
        throw new RuntimeException('FILE_READ_FAILED: ' . $relative);
    }
    return $content;
}

/** @return array<string,mixed> */
function readJson(string $root, string $relative): array
{
    $content = readText($root, $relative);
    $json = json_decode($content, true);
    if (!is_array($json)) {
        throw new RuntimeException('JSON_READ_FAILED: ' . $relative);
    }
    return $json;
}

/** @param array<int,array<string,string>> $checks */
function assertContains(string $content, string $needle, string $id, array &$checks): void
{
    if (!str_contains($content, $needle)) {
        fail($id, $checks);
    }
    addCheck($checks, $id, 'OK');
}

/** @param array<int,array<string,string>> $checks */
function assertNotContains(string $content, string $needle, string $id, array &$checks): void
{
    if (str_contains($content, $needle)) {
        fail($id, $checks);
    }
    addCheck($checks, $id, 'OK');
}

/** @param array<int,mixed> $values @param array<int,array<string,string>> $checks */
function assertArrayContains(array $values, string $needle, string $id, array &$checks): void
{
    if (!in_array($needle, $values, true)) {
        fail($id, $checks);
    }
    addCheck($checks, $id, 'OK');
}

/** @param array<int,array<string,string>> $checks */
function assertSameValue(mixed $actual, mixed $expected, string $id, array &$checks): void
{
    if ($actual !== $expected) {
        fail($id . ': expected=' . var_export($expected, true) . ' actual=' . var_export($actual, true), $checks);
    }
    addCheck($checks, $id, 'OK');
}

/** @param array<int,array<string,string>> $checks */
function assertValidXml(string $root, string $relative, array &$checks): void
{
    $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    $previous = libxml_use_internal_errors(true);
    $xml = simplexml_load_file($path);
    $errors = libxml_get_errors();
    libxml_clear_errors();
    libxml_use_internal_errors($previous);
    if (!$xml instanceof SimpleXMLElement) {
        $messages = [];
        foreach ($errors as $error) {
            $messages[] = trim($error->message);
        }
        fail('XML_INVALID: ' . $relative . ' ' . implode(' | ', $messages), $checks);
    }
    addCheck($checks, 'XML_VALID: ' . $relative, 'OK');
}

/** @param array<int,array<string,string>> $checks */
function fail(string $id, array &$checks): never
{
    addCheck($checks, $id, 'FAILED');
    throw new RuntimeException($id);
}

function ensureDirectory(string $path, string $palier): void
{
    if (is_dir($path)) {
        return;
    }
    if (!mkdir($path, 0775, true) && !is_dir($path)) {
        fwrite(STDERR, $palier . '_DIRECTORY_FAILED: ' . $path . PHP_EOL);
        exit(1);
    }
}

/** @param array<string,mixed> $data */
function writeJson(string $path, array $data, string $palier): void
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    if (!is_string($json)) {
        fwrite(STDERR, $palier . '_JSON_FAILED: ' . $path . PHP_EOL);
        exit(1);
    }
    writeText($path, $json . PHP_EOL, $palier);
}

function writeText(string $path, string $content, string $palier): void
{
    if (file_put_contents($path, $content) === false) {
        fwrite(STDERR, $palier . '_WRITE_FAILED: ' . $path . PHP_EOL);
        exit(1);
    }
}

/** @param array<string,mixed> $report */
function buildMarkdown(array $report): string
{
    $lines = [
        '# P113C1 OPUS_REF_BOOK Global Robotized Recipe',
        '',
        'Status: **' . $report['summary']['status'] . '**',
        '',
        'Total checks: ' . (string)$report['summary']['total_checks'],
        'Failed checks: ' . (string)$report['summary']['failed_checks'],
        '',
        '## Checks',
        '',
    ];
    foreach ($report['checks'] as $check) {
        $lines[] = '- ' . $check['status'] . ' — ' . $check['id'];
    }
    return implode(PHP_EOL, $lines) . PHP_EOL;
}

/** @param array<string,mixed> $report */
function buildHtml(array $report): string
{
    return '<!doctype html><html lang="fr"><head><meta charset="utf-8"><title>P113C1 OPUS_REF_BOOK Global Robotized Recipe</title></head><body><pre>'
        . htmlspecialchars(buildMarkdown($report), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . '</pre></body></html>' . PHP_EOL;
}
