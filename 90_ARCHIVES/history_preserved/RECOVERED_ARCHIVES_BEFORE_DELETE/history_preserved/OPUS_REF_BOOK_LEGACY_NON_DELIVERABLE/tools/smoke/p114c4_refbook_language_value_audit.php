<?php
declare(strict_types=1);

/**
 * P114C4 — RefBook language value audit
 *
 * Goal:
 *   Detect translations that are present but visibly in the wrong language.
 *
 * Contract:
 *   - Missing key markers are reported.
 *   - Wrong-language values are reported.
 *   - Technical tokens are tolerated only when they are expected identifiers.
 *   - This audit is allowed to fail while translation work is incomplete.
 */

$root = realpath(__DIR__ . '/../..');
if ($root === false) {
    fwrite(STDERR, "P114C4_LANGUAGE_VALUE_AUDIT_FAIL: root not found\n");
    exit(1);
}

$langs = ['fr', 'en', 'es', 'de', 'uk', 'it', 'pl', 'cs'];
$themes = ['night', 'paper'];
$pages = [
    'home',
    'api-reference',
    'asset-diagnostics',
    'legal',
    'search',
    'domain-fsm',
    'symbol-6',
    'download-install',
    'guide-architecture',
    'guide-routing',
];

$baseUrl = getenv('OPUS_REFBOOK_BASE_URL') ?: 'http://127.0.0.1/OPUS_REF_BOOK/';
$maxFailures = (int) (getenv('P114C4_MAX_FAILURES') ?: '250');

$failures = [];

function add_failure(array &$failures, string $message, int $maxFailures): void
{
    if (count($failures) < $maxFailures) {
        $failures[] = $message;
    }
}

function flatten_strings(mixed $value, string $path = ''): array
{
    $out = [];

    if (is_string($value)) {
        $out[$path === '' ? '<root>' : $path] = $value;
        return $out;
    }

    if (is_array($value)) {
        foreach ($value as $key => $child) {
            $childPath = $path === '' ? (string) $key : $path . '.' . (string) $key;
            $out += flatten_strings($child, $childPath);
        }
    }

    return $out;
}

function normalized_text(string $value): string
{
    $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $value = preg_replace('~<script\b[^>]*>.*?</script>~is', ' ', $value) ?? $value;
    $value = preg_replace('~<style\b[^>]*>.*?</style>~is', ' ', $value) ?? $value;
    $value = strip_tags($value);
    $value = preg_replace('~\s+~u', ' ', $value) ?? $value;
    return trim($value);
}

function is_technical_tolerated(string $value): bool
{
    $trimmed = trim($value);

    if ($trimmed === '') {
        return true;
    }

    if (preg_match('~^(Opus|RefBook|Twig|ViewModel|Router|ACL|FSM|HTTP|REST|JSON|HTML|CSS|PHP|MVC|LSTSA|Namespace|Mermaid|GET|POST|PUT|DELETE|PATCH|HEAD|OPTIONS|SaaS)$~u', $trimmed) === 1) {
        return true;
    }

    if (preg_match('~^[A-Z][A-Za-z0-9_\\\\]+(::[A-Za-z0-9_]+)?$~u', $trimmed) === 1) {
        return true;
    }

    if (preg_match('~^[A-Za-z0-9_./\\\\:-]+\.php$~u', $trimmed) === 1) {
        return true;
    }

    if (preg_match('~^<OPUS_ROOT>~u', $trimmed) === 1) {
        return true;
    }

    return false;
}

function marker_sets(): array
{
    return [
        'en' => [
            'Read documentation assets',
            'without path traversal',
            'placeholder fallback',
            'No public method detected',
            'Source role to enrich',
            'Source contract to enrich',
            'References declared',
            'Dedicated renderer unavailable',
            'Download and install',
            'This page explains',
            'Verify the installation',
            'Diagnostics if installation fails',
            'Free for personal',
            'Professional, commercial',
            'All rights reserved',
            'Source identity',
            'Symbol profile',
            'Related examples',
            'Related diagrams',
            'Public methods',
            'Public API',
            'Path',
            'Method',
        ],
        'fr' => [
            'Télécharger',
            'installer',
            'Recherche',
            'Page introuvable',
            'Usage personnel',
            'Droits réservés',
            'Attribution',
            'Aucune fonction',
            'Fonctions publiques',
            'Source à résoudre',
            'Rôle source',
            'Contrat source',
            'Exemples liés',
            'Diagrammes liés',
            'Identité source',
            'Fiche du symbole',
        ],
        'es' => [
            'Descargar',
            'instalar',
            'Búsqueda',
            'Página no encontrada',
            'Uso personal',
            'Todos los derechos',
            'Métodos públicos',
            'Fuente por resolver',
            'Ejemplos relacionados',
            'Diagramas relacionados',
        ],
        'de' => [
            'Herunterladen',
            'installieren',
            'Suche',
            'Seite nicht gefunden',
            'Kostenlose persönliche',
            'Alle Rechte',
            'Öffentliche Methoden',
            'Quelle zu klären',
            'Verknüpfte Beispiele',
            'Verknüpfte Diagramme',
            'Quellidentität',
            'Symbolprofil',
        ],
        'uk' => [
            'Завантажити',
            'встановити',
            'Пошук',
            'Сторінку не знайдено',
            'Безкоштовне',
            'Усі права',
            'Публічні методи',
            'Джерело для уточнення',
            'Пов’язані приклади',
            'Пов’язані діаграми',
        ],
        'it' => [
            'Scaricare',
            'installare',
            'Ricerca',
            'Pagina non trovata',
            'Uso personale',
            'Tutti i diritti',
            'Metodi pubblici',
            'Sorgente da risolvere',
            'Esempi collegati',
            'Diagrammi collegati',
            'Identità sorgente',
        ],
        'pl' => [
            'Pobierz',
            'zainstaluj',
            'Szukaj',
            'Nie znaleziono strony',
            'Bezpłatne użycie',
            'Wszelkie prawa',
            'Metody publiczne',
            'Źródło do rozwiązania',
            'Powiązane przykłady',
            'Powiązane diagramy',
        ],
        'cs' => [
            'Stáhnout',
            'nainstalovat',
            'Hledat',
            'Stránka nenalezena',
            'Bezplatné osobní',
            'Všechna práva',
            'Veřejné metody',
            'Zdroj k upřesnění',
            'Související příklady',
            'Související diagramy',
            'Identita zdroje',
            'Profil symbolu',
            'Odpovědnost',
        ],
    ];
}

/**
 * @return list<array{family:string, marker:string}>
 */
function forbidden_markers_for(string $lang): array
{
    $sets = marker_sets();
    $forbidden = [];

    foreach ($sets as $family => $markers) {
        if ($family === $lang) {
            continue;
        }

        foreach ($markers as $marker) {
            $forbidden[] = ['family' => $family, 'marker' => $marker];
        }
    }

    return $forbidden;
}

function contains_marker(string $value, string $marker): bool
{
    if ($marker === '') {
        return false;
    }

    if (function_exists('mb_strtolower')) {
        return mb_strpos(mb_strtolower($value, 'UTF-8'), mb_strtolower($marker, 'UTF-8'), 0, 'UTF-8') !== false;
    }

    return stripos($value, $marker) !== false;
}

function audit_text_value(string $lang, string $scope, string $path, string $value, array &$failures, int $maxFailures): void
{
    $normalized = normalized_text($value);

    if ($normalized === '' || is_technical_tolerated($normalized)) {
        return;
    }

    if (contains_marker($normalized, 'I18N_MISSING') || contains_marker($normalized, '⚠[')) {
        add_failure($failures, "I18N_KEY_MISSING lang={$lang} scope={$scope} path={$path} value=" . mb_substr($normalized, 0, 140), $maxFailures);
        return;
    }

    if (contains_marker($normalized, 'H:\\') || contains_marker($normalized, 'C:\\Users') || contains_marker($normalized, 'H:/OPUS')) {
        add_failure($failures, "LOCAL_PATH_LEAK lang={$lang} scope={$scope} path={$path} value=" . mb_substr($normalized, 0, 140), $maxFailures);
        return;
    }

    foreach (forbidden_markers_for($lang) as $forbidden) {
        if (contains_marker($normalized, $forbidden['marker'])) {
            add_failure(
                $failures,
                "VALUE_LANGUAGE_LEAK lang={$lang} source_lang={$forbidden['family']} scope={$scope} path={$path} marker={$forbidden['marker']} value=" . mb_substr($normalized, 0, 180),
                $maxFailures
            );
            return;
        }
    }
}

function curl_url(string $url): array
{
    $command = 'curl --silent --show-error --location --max-time 12 ' . escapeshellarg($url);
    exec($command, $output, $exitCode);
    return [$exitCode, implode("\n", $output)];
}

echo "P114C4_LANGUAGE_VALUE_AUDIT_START\n";

/*
 * Static i18n catalog audit.
 */
foreach ($langs as $lang) {
    $file = $root . '/content/refbook/i18n/' . $lang . '.json';
    if (!is_file($file)) {
        add_failure($failures, "I18N_FILE_MISSING lang={$lang} file={$file}", $maxFailures);
        continue;
    }

    $data = json_decode((string) file_get_contents($file), true);
    if (!is_array($data)) {
        add_failure($failures, "I18N_JSON_INVALID lang={$lang} file={$file}", $maxFailures);
        continue;
    }

    foreach (flatten_strings($data) as $path => $value) {
        audit_text_value($lang, 'i18n_json', $path, $value, $failures, $maxFailures);
    }
}

/*
 * Download/install editorial catalog audit.
 */
$downloadFile = $root . '/content/refbook/download-install.json';
if (is_file($downloadFile)) {
    $download = json_decode((string) file_get_contents($downloadFile), true);
    if (is_array($download)) {
        foreach ($langs as $lang) {
            $branch = $download['languages'][$lang] ?? null;
            if (!is_array($branch)) {
                add_failure($failures, "DOWNLOAD_I18N_LANG_MISSING lang={$lang}", $maxFailures);
                continue;
            }

            foreach (flatten_strings($branch) as $path => $value) {
                audit_text_value($lang, 'download_install_json', $path, $value, $failures, $maxFailures);
            }
        }
    }
}

/*
 * Live rendered pages audit.
 */
$counter = 0;
$total = count($langs) * count($themes) * count($pages);

foreach ($langs as $lang) {
    foreach ($themes as $theme) {
        foreach ($pages as $page) {
            $counter++;
            echo "LIVE {$counter}/{$total} lang={$lang} theme={$theme} page={$page}\n";

            $url = rtrim($baseUrl, '/') . '/?lang=' . rawurlencode($lang) . '&theme=' . rawurlencode($theme) . '&page=' . rawurlencode($page);
            [$exitCode, $body] = curl_url($url);

            if ($exitCode !== 0) {
                add_failure($failures, "LIVE_CURL_FAIL lang={$lang} theme={$theme} page={$page} exit={$exitCode}", $maxFailures);
                continue;
            }

            $text = normalized_text($body);

            if ($text === '') {
                add_failure($failures, "LIVE_EMPTY_RESPONSE lang={$lang} theme={$theme} page={$page}", $maxFailures);
                continue;
            }

            audit_text_value($lang, 'live_page', "{$theme}/{$page}", $text, $failures, $maxFailures);

            /*
             * Known Opus source-description English leaks. These are not RefBook UI keys;
             * they must ultimately move into Opus DocumentationProvider(lang).
             */
            if ($lang !== 'en') {
                foreach ([
                    'Read documentation assets',
                    'without path traversal',
                    'placeholder fallback',
                    'Condition failures must be explicit',
                    'Conditions receive only',
                    'RefBook API health and version',
                    'Read documentation',
                ] as $sourceMarker) {
                    if (contains_marker($text, $sourceMarker)) {
                        add_failure(
                            $failures,
                            "OPUS_SOURCE_TEXT_UNLOCALIZED lang={$lang} theme={$theme} page={$page} marker={$sourceMarker} action=move_to_OPUS_DocumentationProvider",
                            $maxFailures
                        );
                        break;
                    }
                }
            }
        }
    }
}

if ($failures !== []) {
    echo "P114C4_LANGUAGE_VALUE_AUDIT_FAIL\n";
    foreach ($failures as $index => $failure) {
        echo str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT) . ' ' . $failure . "\n";
    }

    if (count($failures) >= $maxFailures) {
        echo "P114C4_LANGUAGE_VALUE_AUDIT_TRUNCATED max={$maxFailures}\n";
    }

    exit(1);
}

echo "P114C4_LANGUAGE_VALUE_AUDIT_OK\n";
