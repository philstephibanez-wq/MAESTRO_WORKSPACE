<?php
declare(strict_types=1);

$root = realpath(__DIR__ . '/../..');
if ($root === false) {
    fwrite(STDERR, "P114C3R_APPLY_FAIL: root not found\n");
    exit(1);
}

function fail(string $message): never {
    fwrite(STDERR, "P114C3R_APPLY_FAIL: " . $message . "\n");
    exit(1);
}

function file_text(string $path): string {
    if (!is_file($path)) {
        fail("missing file " . $path);
    }
    $text = file_get_contents($path);
    if (!is_string($text)) {
        fail("cannot read " . $path);
    }
    return $text;
}

function put_text(string $path, string $text): void {
    $dir = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
        fail("cannot create dir " . $dir);
    }
    if (file_put_contents($path, $text) === false) {
        fail("cannot write " . $path);
    }
}

function replace_once_or_keep(string $text, string $needle, string $replacement): string {
    if (strpos($text, $replacement) !== false) {
        return $text;
    }
    if (strpos($text, $needle) === false) {
        return $text;
    }
    return str_replace($needle, $replacement, $text);
}

$pageController = $root . '/application/reference/Controller/PageController.php';
$page = file_text($pageController);
if (strpos($page, "ReferenceOpusReleaseService") === false) {
    $anchor = "        \$guide = \$this->content()->guideBySlug(\$slug);\n";
    if (strpos($page, $anchor) === false) {
        fail("PageController anchor not found");
    }
    $insert = <<<'PHP'

        if ($slug === 'download-install') {
            $releaseService = new \OpusRefBook\Reference\Service\ReferenceOpusReleaseService(
                $this->paths->appRoot . '/content/refbook/releases',
                \OpusRefBook\Reference\Service\ReferenceOpusRootLocator::fromEnvironment(),
                $this->content()->language()
            );

            return $this->view('pages/download-install.twig', [
                'title' => $releaseService->pageTitle(),
                'downloadInstall' => $releaseService->viewModel(),
                'pageSlug' => 'download-install',
            ]);
        }

PHP;
    $page = str_replace($anchor, $insert . $anchor, $page);
    put_text($pageController, $page);
}

$layoutFile = $root . '/application/reference/templates/layout.twig';
$layout = file_text($layoutFile);

if (strpos($layout, 'refbook-install.css') === false) {
    $runtimePattern = '/^(\s*<link\s+rel="stylesheet"\s+href="\{\{\s*basePath\s*\}\}\/assets\/css\/refbook-runtime\.css\?v=[^"]+">\s*)$/m';
    if (preg_match($runtimePattern, $layout, $matches) === 1) {
        $layout = preg_replace(
            $runtimePattern,
            '$1' . "\n" . '  <link rel="stylesheet" href="{{ basePath }}/assets/css/refbook-install.css?v=P114C3R">',
            $layout,
            1
        );
    } else {
        $refbookPattern = '/^(\s*<link\s+rel="stylesheet"\s+href="\{\{\s*basePath\s*\}\}\/assets\/css\/refbook\.css\?v=[^"]+">\s*)$/m';
        if (preg_match($refbookPattern, $layout) !== 1) {
            fail("layout css anchor not found");
        }
        $layout = preg_replace(
            $refbookPattern,
            '$1' . "\n" . '  <link rel="stylesheet" href="{{ basePath }}/assets/css/refbook-install.css?v=P114C3R">',
            $layout,
            1
        );
    }
}

if (strpos($layout, 'page=download-install') === false) {
    $downloadLine = '          <a href="{{ basePath }}/?lang={{ lang }}&theme={{ theme }}&page=download-install"{% if pageSlug == \'download-install\' %} class="active"{% endif %}>{{ ui.sidebar.download_install }}</a>' . "\n";
    $legalPattern = '/^(\s*<a\s+href="\{\{\s*basePath\s*\}\}\/\?lang=\{\{\s*lang\s*\}\}&theme=\{\{\s*theme\s*\}\}&page=legal".*ui\.sidebar\.legal.*<\/a>\s*)$/m';
    if (preg_match($legalPattern, $layout) === 1) {
        $layout = preg_replace($legalPattern, '$1' . "\n" . rtrim($downloadLine), $layout, 1);
    } else {
        $navPattern = '/(<div class="nav-direct">\s*)/m';
        if (preg_match($navPattern, $layout) !== 1) {
            fail("layout nav-direct anchor not found");
        }
        $layout = preg_replace($navPattern, '$1' . "\n" . $downloadLine, $layout, 1);
    }
}

put_text($layoutFile, $layout);

$labels = [
    'fr' => 'Télécharger / installer',
    'en' => 'Download / install',
    'es' => 'Descargar / instalar',
    'de' => 'Herunterladen / installieren',
    'uk' => 'Завантажити / встановити',
    'it' => 'Scaricare / installare',
    'pl' => 'Pobierz / zainstaluj',
    'cs' => 'Stáhnout / nainstalovat',
];

foreach ($labels as $lang => $label) {
    $file = $root . '/content/refbook/i18n/' . $lang . '.json';
    if (!is_file($file)) {
        fail("i18n file missing " . $file);
    }
    $json = json_decode((string) file_get_contents($file), true);
    if (!is_array($json)) {
        fail("i18n json invalid " . $file);
    }
    if (!isset($json['labels']) || !is_array($json['labels'])) {
        $json['labels'] = [];
    }
    if (!isset($json['labels']['sidebar']) || !is_array($json['labels']['sidebar'])) {
        $json['labels']['sidebar'] = [];
    }
    $json['labels']['sidebar']['download_install'] = $label;

    if ($lang === 'cs') {
        if (!isset($json['labels']['language']) || !is_array($json['labels']['language'])) {
            $json['labels']['language'] = [];
        }
        $json['labels']['language']['apply'] = $json['labels']['language']['apply'] ?? 'Použít';
        $json['labels']['sidebar']['assets_docs'] = $json['labels']['sidebar']['assets_docs'] ?? 'Dokumentační assets';
        $json['labels']['sidebar']['legal'] = $json['labels']['sidebar']['legal'] ?? 'Právní informace';
    }

    file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
}

echo "P114C3R_APPLY_OK\n";
