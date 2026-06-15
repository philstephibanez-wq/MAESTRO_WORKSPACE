<?php

declare(strict_types=1);

/*
 * P114B5_REFBOOK_LANGUAGE_RECIPE_CHECK
 *
 * Role:
 *   Run a strict public language recipe against OPUS_REF_BOOK.
 *
 * Contract:
 *   - The script observes the RefBook repository and HTTP output only.
 *   - It does not modify files, does not normalize translations, and does not mask failures.
 *   - It reports every detected problem with a precise marker.
 */

$root = realpath(__DIR__ . '/../..');
if ($root === false) {
    fwrite(STDERR, "P114B5_FAIL: repository root not found\n");
    exit(1);
}

$expectedLanguages = ['fr', 'en', 'es', 'de', 'uk', 'it', 'pl', 'cs'];
$criticalPages = [
    'home' => '',
    'api-reference' => 'api-reference',
    'asset-diagnostics' => 'asset-diagnostics',
    'legal' => 'legal',
    'search' => 'search',
    'domain-fsm' => 'domain-fsm',
    'symbol-6' => 'symbol-6',
];
$themes = ['night', 'paper'];
$liveCurlMaxTimeSeconds = 30;
$liveCurlConnectTimeoutSeconds = 8;
$liveCurlRetries = 2;
$liveCheckIndex = 0;
$liveCheckTotal = count($expectedLanguages) * count($themes) * count($criticalPages);

$failures = [];

function p114b5_fail(array &$failures, string $message): void
{
    $failures[] = $message;
}

function p114b5_read_file(string $file, array &$failures): string
{
    if (!is_file($file)) {
        p114b5_fail($failures, 'file missing=' . $file);
        return '';
    }

    $content = file_get_contents($file);
    if (!is_string($content)) {
        p114b5_fail($failures, 'file unreadable=' . $file);
        return '';
    }

    return $content;
}

/** @return array<string,mixed> */
function p114b5_read_json(string $file, array &$failures): array
{
    $content = p114b5_read_file($file, $failures);
    if ($content === '') {
        return [];
    }

    try {
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    } catch (Throwable $exception) {
        p114b5_fail($failures, 'json invalid=' . $file . ' error=' . $exception->getMessage());
        return [];
    }

    if (!is_array($data)) {
        p114b5_fail($failures, 'json root not object=' . $file);
        return [];
    }

    return $data;
}

/**
 * @param mixed $value
 * @return array<string,string>
 */
function p114b5_flatten_strings(mixed $value, string $prefix = ''): array
{
    $out = [];

    if (is_string($value)) {
        $out[$prefix] = $value;
        return $out;
    }

    if (is_array($value)) {
        foreach ($value as $key => $child) {
            $path = $prefix === '' ? (string) $key : $prefix . '.' . (string) $key;
            foreach (p114b5_flatten_strings($child, $path) as $childPath => $childValue) {
                $out[$childPath] = $childValue;
            }
        }
    }

    return $out;
}

/**
 * @param mixed $value
 * @return list<string>
 */
function p114b5_flatten_shape(mixed $value, string $prefix = ''): array
{
    $out = [];

    if (is_array($value)) {
        $out[] = $prefix . '=array(' . count($value) . ')';
        foreach ($value as $key => $child) {
            $path = $prefix === '' ? (string) $key : $prefix . '.' . (string) $key;
            foreach (p114b5_flatten_shape($child, $path) as $childPath) {
                $out[] = $childPath;
            }
        }
        return $out;
    }

    $out[] = $prefix . '=' . gettype($value);
    return $out;
}

function p114b5_contains_any(string $haystack, array $needles): ?string
{
    foreach ($needles as $needle) {
        if ($needle !== '' && str_contains($haystack, $needle)) {
            return $needle;
        }
    }

    return null;
}

function p114b5_run_curl(string $url, array &$failures, int $maxTimeSeconds, int $connectTimeoutSeconds, int $retries = 0): string
{
    $binary = 'curl.exe';
    $lastBody = '';
    $lastExitCode = 0;

    for ($attempt = 0; $attempt <= $retries; $attempt++) {
        if ($attempt > 0) {
            usleep(750000);
        }

        $command = $binary . ' -sS -L --connect-timeout ' . (int) $connectTimeoutSeconds . ' --max-time ' . (int) $maxTimeSeconds . ' ' . escapeshellarg($url) . ' 2>&1';
        $output = [];
        $exitCode = 0;
        exec($command, $output, $exitCode);
        $body = implode("\n", $output);

        $lastBody = $body;
        $lastExitCode = $exitCode;

        if ($exitCode === 0 && trim($body) !== '') {
            return $body;
        }
    }

    if ($lastExitCode !== 0) {
        p114b5_fail($failures, 'curl failed exit=' . $lastExitCode . ' url=' . $url . ' output=' . substr($lastBody, 0, 240));
        return '';
    }

    p114b5_fail($failures, 'curl empty body url=' . $url);
    return '';
}

function p114b5_scan_local_paths(string $label, string $text, array &$failures): void
{
    if (preg_match('/\b[A-Z]:\\\\/i', $text) === 1 || preg_match('/\b[A-Z]:\//i', $text) === 1) {
        p114b5_fail($failures, 'local absolute path leaked in ' . $label);
    }
}

$i18nRoot = $root . '/content/refbook/i18n';
$loaded = [];

foreach ($expectedLanguages as $language) {
    $file = $i18nRoot . '/' . $language . '.json';
    $data = p114b5_read_json($file, $failures);
    if ($data === []) {
        continue;
    }

    if (($data['schema'] ?? null) !== 'OPUS_REFBOOK_I18N_V1') {
        p114b5_fail($failures, 'i18n schema invalid lang=' . $language);
    }

    if (($data['language'] ?? null) !== $language) {
        p114b5_fail($failures, 'i18n language mismatch file=' . $language . '.json value=' . (string) ($data['language'] ?? 'missing'));
    }

    $loaded[$language] = $data;
    p114b5_scan_local_paths('i18n/' . $language . '.json', json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $failures);
}

foreach (array_diff($expectedLanguages, array_keys($loaded)) as $missingLanguage) {
    p114b5_fail($failures, 'i18n missing language file=' . $missingLanguage);
}

if (isset($loaded['fr'])) {
    $referenceShape = p114b5_flatten_shape($loaded['fr']);
    sort($referenceShape);

    foreach ($loaded as $language => $data) {
        $shape = p114b5_flatten_shape($data);
        sort($shape);

        $missing = array_values(array_diff($referenceShape, $shape));
        $extra = array_values(array_diff($shape, $referenceShape));

        if ($missing !== []) {
            p114b5_fail($failures, 'i18n shape missing lang=' . $language . ' first=' . implode(', ', array_slice($missing, 0, 8)));
        }

        if ($extra !== []) {
            p114b5_fail($failures, 'i18n shape extra lang=' . $language . ' first=' . implode(', ', array_slice($extra, 0, 8)));
        }
    }
}

$frenchLeakMarkers = [
    'API interne pilotée',
    'Endpoints exposés',
    'Méthode',
    'Chemin',
    'Description',
    'Diagnostics assets',
    'Le snapshot',
    'Contrôles du site',
    'Thème visuel',
    'Page introuvable',
    'Recherche RefBook',
    'Résultats',
    'Aucun résultat',
    'Lire vite',
    'Vérifier',
    'Développer',
    'Domaine',
    'Domaines',
    'Guides de départ',
];

$englishUiLeakMarkers = [
    'How to read this page',
    'Exposed RefBook endpoints',
    'Method',
    'Path',
    'No result found',
    'Search term',
    'Site controls',
    'Page not found',
    'Related diagrams',
    'Public methods',
    'Source inventory',
    'Read-only',
];

$germanLeakMarkers = [
    'Interne API',
    'Methode',
    'Pfad',
    'Beschreibung',
    'Suche',
    'Ergebnisse',
    'Startseite',
    'Leitfäden',
    'Domänen',
    'Rechtliches',
    'Öffentliche',
    'Diagramme',
    'Quellinventar',
];

foreach ($loaded as $language => $data) {
    $strings = p114b5_flatten_strings($data);

    foreach ($strings as $path => $value) {
        if (str_starts_with($path, 'labels.language.')) {
            continue;
        }

        if ($language !== 'fr') {
            $marker = p114b5_contains_any($value, $frenchLeakMarkers);
            if ($marker !== null) {
                p114b5_fail($failures, 'french marker leaked lang=' . $language . ' path=' . $path . ' marker=' . $marker);
            }
        }

        if ($language !== 'en') {
            $marker = p114b5_contains_any($value, $englishUiLeakMarkers);
            if ($marker !== null) {
                p114b5_fail($failures, 'english UI marker leaked lang=' . $language . ' path=' . $path . ' marker=' . $marker);
            }
        }

        if (in_array($language, ['uk', 'it', 'pl', 'cs'], true)) {
            $marker = p114b5_contains_any($value, $germanLeakMarkers);
            if ($marker !== null) {
                p114b5_fail($failures, 'german marker leaked lang=' . $language . ' path=' . $path . ' marker=' . $marker);
            }
        }
    }
}

$serviceFile = $root . '/application/reference/Service/ReferenceContentService.php';
$service = p114b5_read_file($serviceFile, $failures);
foreach ($expectedLanguages as $language) {
    if (!str_contains($service, "'" . $language . "'") && !str_contains($service, '"' . $language . '"')) {
        p114b5_fail($failures, 'ReferenceContentService missing supported language=' . $language);
    }
}

$templateRoot = $root . '/application/reference/templates';
$templateIterator = is_dir($templateRoot)
    ? new RecursiveIteratorIterator(new RecursiveDirectoryIterator($templateRoot))
    : new ArrayIterator([]);

$forbiddenTemplateTexts = [
    'API interne pilotée par FSM',
    'Endpoints exposés par RefBook',
    'Méthode',
    'Chemin',
    'Description',
    'Diagnostics assets documentaires',
    'Le snapshot Opus référence',
    'Aucun résultat trouvé',
    'Search the RefBook',
    'Search term',
    'No result found',
    'How to read this page',
    'Related diagrams',
    'Public methods',
    'Read-only',
];

foreach ($templateIterator as $fileInfo) {
    if (!$fileInfo instanceof SplFileInfo || !$fileInfo->isFile() || $fileInfo->getExtension() !== 'twig') {
        continue;
    }

    $content = p114b5_read_file($fileInfo->getPathname(), $failures);
    p114b5_scan_local_paths('template ' . $fileInfo->getFilename(), $content, $failures);

    foreach ($forbiddenTemplateTexts as $marker) {
        if (str_contains($content, $marker)) {
            p114b5_fail($failures, 'hardcoded template marker file=' . $fileInfo->getPathname() . ' marker=' . $marker);
        }
    }
}

$baseUrl = getenv('OPUS_REFBOOK_BASE_URL');
if (!is_string($baseUrl) || trim($baseUrl) === '') {
    $baseUrl = 'http://127.0.0.1/OPUS_REF_BOOK';
}
$baseUrl = rtrim($baseUrl, '/');

$liveForbiddenAll = ['[*', 'OPUS_REFBOOK_LANG_UNSUPPORTED', 'H:\\', 'H:/', 'C:\\Users', 'C:/Users'];
$liveFrenchForbidden = [
    'API interne pilotée',
    'Endpoints exposés',
    'Méthode',
    'Chemin',
    'Diagnostics assets',
    'Le snapshot Opus',
    'Contrôles du site',
    'Thème visuel',
    'Aucun résultat trouvé',
    'Lire vite',
    'Vérifier',
    'Développer',
];
$liveGermanForbiddenForNonGerman = ['Interne API', 'Methode', 'Pfad', 'Beschreibung', 'Suche', 'Ergebnisse', 'Leitfäden', 'Domänen', 'Rechtliches'];

foreach ($expectedLanguages as $language) {
    foreach ($themes as $theme) {
        foreach ($criticalPages as $pageLabel => $page) {
            $query = '?lang=' . rawurlencode($language) . '&theme=' . rawurlencode($theme);
            if ($page !== '') {
                $query .= '&page=' . rawurlencode($page);
            }

            $url = $baseUrl . '/' . $query;
            $liveCheckIndex++;
            echo 'LIVE ' . $liveCheckIndex . '/' . $liveCheckTotal . ' lang=' . $language . ' theme=' . $theme . ' page=' . $pageLabel . "\n";
            $body = p114b5_run_curl($url, $failures, $liveCurlMaxTimeSeconds, $liveCurlConnectTimeoutSeconds, $liveCurlRetries);
            if ($body === '') {
                continue;
            }

            foreach ($liveForbiddenAll as $marker) {
                if (str_contains($body, $marker)) {
                    p114b5_fail($failures, 'live forbidden marker lang=' . $language . ' theme=' . $theme . ' page=' . $pageLabel . ' marker=' . $marker);
                }
            }

            foreach ($expectedLanguages as $optionLanguage) {
                if (!preg_match('/<option[^>]+value="' . preg_quote($optionLanguage, '/') . '"/i', $body)) {
                    p114b5_fail($failures, 'live language option missing page=' . $pageLabel . ' lang=' . $language . ' option=' . $optionLanguage);
                }
            }

            if (!preg_match('/<option[^>]+value="' . preg_quote($language, '/') . '"[^>]*selected/i', $body)) {
                p114b5_fail($failures, 'live active language not selected page=' . $pageLabel . ' lang=' . $language . ' theme=' . $theme);
            }

            if ($language !== 'fr') {
                $marker = p114b5_contains_any($body, $liveFrenchForbidden);
                if ($marker !== null) {
                    p114b5_fail($failures, 'live french marker leaked lang=' . $language . ' theme=' . $theme . ' page=' . $pageLabel . ' marker=' . $marker);
                }
            }

            if (in_array($language, ['uk', 'it', 'pl', 'cs'], true)) {
                $marker = p114b5_contains_any($body, $liveGermanForbiddenForNonGerman);
                if ($marker !== null) {
                    p114b5_fail($failures, 'live german marker leaked lang=' . $language . ' theme=' . $theme . ' page=' . $pageLabel . ' marker=' . $marker);
                }
            }
        }
    }
}

if ($failures !== []) {
    echo "P114B5_REFBOOK_LANGUAGE_RECIPE_CHECK_FAIL\n";
    foreach ($failures as $index => $failure) {
        echo sprintf('%03d %s', $index + 1, $failure) . "\n";
    }
    exit(1);
}

echo "P114B5_REFBOOK_LANGUAGE_RECIPE_CHECK_OK\n";
