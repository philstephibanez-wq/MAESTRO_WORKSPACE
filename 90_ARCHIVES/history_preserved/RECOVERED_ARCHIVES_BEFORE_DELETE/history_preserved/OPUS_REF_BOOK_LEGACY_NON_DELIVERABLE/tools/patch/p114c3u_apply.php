<?php
declare(strict_types=1);

$root = realpath(__DIR__ . '/../..');
if ($root === false) {
    fwrite(STDERR, "P114C3U_APPLY_FAIL: root not found\n");
    exit(1);
}

function fail(string $message): never {
    fwrite(STDERR, "P114C3U_APPLY_FAIL: " . $message . "\n");
    exit(1);
}

function read_text(string $path): string {
    if (!is_file($path)) {
        fail("missing file " . $path);
    }
    $text = file_get_contents($path);
    if (!is_string($text)) {
        fail("cannot read " . $path);
    }
    return $text;
}

function write_text(string $path, string $text): void {
    $dir = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
        fail("cannot create dir " . $dir);
    }
    if (file_put_contents($path, $text) === false) {
        fail("cannot write " . $path);
    }
}

/*
 * Robust fix:
 * Do not depend on the old "$labels['pl']" anchor.
 * For Czech, use cs.json labels as the source of truth so runtime labels cannot fall back to French.
 */
$contentService = $root . '/application/reference/Service/ReferenceContentService.php';
$text = read_text($contentService);

$marker = 'P114C3U_CZECH_JSON_LABELS_SOURCE';
if (strpos($text, $marker) === false) {
    $returnLine = '        return $labels[$this->language] ?? $labels[self::DEFAULT_LANGUAGE];';
    if (strpos($text, $returnLine) === false) {
        fail("ReferenceContentService return anchor not found");
    }

    $insert = <<<'PHP'
        // P114C3U_CZECH_JSON_LABELS_SOURCE
        // Czech runtime labels are owned by cs.json until Opus exposes its own documentation I18N provider.
        if ($this->language === 'cs') {
            $csLabels = $this->load()['labels'] ?? [];
            if (is_array($csLabels)) {
                $labels['cs'] = $csLabels;
            }
        }

PHP;

    $text = str_replace($returnLine, $insert . $returnLine, $text);
    write_text($contentService, $text);
}

/*
 * Guarantee cs.json has the user-visible labels needed by the sidebar and language form.
 */
$csFile = $root . '/content/refbook/i18n/cs.json';
$cs = json_decode(read_text($csFile), true);
if (!is_array($cs)) {
    fail("cs.json invalid");
}
if (!isset($cs['labels']) || !is_array($cs['labels'])) {
    $cs['labels'] = [];
}
if (!isset($cs['labels']['language']) || !is_array($cs['labels']['language'])) {
    $cs['labels']['language'] = [];
}
if (!isset($cs['labels']['sidebar']) || !is_array($cs['labels']['sidebar'])) {
    $cs['labels']['sidebar'] = [];
}

$cs['labels']['language']['apply'] = 'Použít';
$cs['labels']['sidebar']['assets_docs'] = 'Dokumentační assets';
$cs['labels']['sidebar']['legal'] = 'Právní informace';
$cs['labels']['sidebar']['download_install'] = 'Stáhnout / nainstalovat';

write_text($csFile, json_encode($cs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");

/*
 * Header badge position.
 */
$cssFile = $root . '/public/assets/css/refbook-install.css';
$css = is_file($cssFile) ? read_text($cssFile) : '';

$cssBlock = <<<'CSS'

/* P114C3U — move powered-by badge right and keep it responsive. */
.site-header .site-legal-badge {
  margin-left: clamp(3rem, 7vw, 10rem);
}

@media (max-width: 1280px) {
  .site-header .site-legal-badge {
    margin-left: clamp(1.5rem, 3vw, 3rem);
  }
}

@media (max-width: 980px) {
  .site-header .site-legal-badge {
    margin-left: 0;
  }
}

CSS;

if (strpos($css, 'P114C3U — move powered-by badge') === false) {
    $css .= $cssBlock;
    write_text($cssFile, $css);
}

/*
 * Bump cache key if the install CSS is already linked. If not, add it after refbook-runtime.css or refbook.css.
 */
$layoutFile = $root . '/application/reference/templates/layout.twig';
$layout = read_text($layoutFile);

if (strpos($layout, 'refbook-install.css') !== false) {
    $layout = preg_replace(
        '~refbook-install\.css\?v=[A-Za-z0-9_\-]+~',
        'refbook-install.css?v=P114C3U',
        $layout
    ) ?? $layout;
} else {
    $installLink = '  <link rel="stylesheet" href="{{ basePath }}/assets/css/refbook-install.css?v=P114C3U">' . "\n";

    if (preg_match('/^(\s*<link\s+rel="stylesheet"\s+href="\{\{\s*basePath\s*\}\}\/assets\/css\/refbook-runtime\.css\?v=[^"]+">\s*)$/m', $layout, $m) === 1) {
        $layout = preg_replace(
            '/^(\s*<link\s+rel="stylesheet"\s+href="\{\{\s*basePath\s*\}\}\/assets\/css\/refbook-runtime\.css\?v=[^"]+">\s*)$/m',
            '$1' . "\n" . rtrim($installLink),
            $layout,
            1
        ) ?? $layout;
    } elseif (preg_match('/^(\s*<link\s+rel="stylesheet"\s+href="\{\{\s*basePath\s*\}\}\/assets\/css\/refbook\.css\?v=[^"]+">\s*)$/m', $layout) === 1) {
        $layout = preg_replace(
            '/^(\s*<link\s+rel="stylesheet"\s+href="\{\{\s*basePath\s*\}\}\/assets\/css\/refbook\.css\?v=[^"]+">\s*)$/m',
            '$1' . "\n" . rtrim($installLink),
            $layout,
            1
        ) ?? $layout;
    } else {
        fail("layout css link anchor not found");
    }
}

write_text($layoutFile, $layout);

echo "P114C3U_APPLY_OK\n";
