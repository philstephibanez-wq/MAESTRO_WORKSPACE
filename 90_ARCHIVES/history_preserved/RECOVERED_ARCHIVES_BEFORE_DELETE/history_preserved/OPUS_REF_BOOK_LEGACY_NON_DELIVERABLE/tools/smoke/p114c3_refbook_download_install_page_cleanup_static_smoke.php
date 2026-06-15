<?php
declare(strict_types=1);

$root = realpath(__DIR__ . '/../..');
if ($root === false) {
    fwrite(STDERR, "P114C3_SMOKE_FAIL: root not found\n");
    exit(1);
}

$failures = [];

$mustExist = [
    'application/reference/Service/ReferenceOpusReleaseService.php',
    'application/reference/templates/pages/download-install.twig',
    'content/refbook/releases/opus.json',
    'content/refbook/download-install.json',
    'public/assets/css/refbook-install.css',
];

foreach ($mustExist as $relative) {
    if (!is_file($root . '/' . $relative)) {
        $failures[] = 'missing file ' . $relative;
    }
}

$manifestFile = $root . '/content/refbook/releases/opus.json';
$manifest = is_file($manifestFile) ? json_decode((string) file_get_contents($manifestFile), true) : null;
if (!is_array($manifest) || ($manifest['schema'] ?? null) !== 'OPUS_RELEASE_MANIFEST_V1') {
    $failures[] = 'release manifest invalid';
} else {
    if (($manifest['latest_version'] ?? '') === '') {
        $failures[] = 'release latest_version missing';
    }
    foreach (($manifest['channels'] ?? []) as $name => $channel) {
        $url = is_array($channel) ? (string) ($channel['package_url'] ?? '') : '';
        if ($url === '') {
            $failures[] = 'release package url missing channel=' . (string) $name;
        }
        if (stripos($url, 'github.com') !== false || stripos($url, 'raw.githubusercontent.com') !== false) {
            $failures[] = 'github url forbidden channel=' . (string) $name;
        }
    }
}

$i18nFile = $root . '/content/refbook/download-install.json';
$i18n = is_file($i18nFile) ? json_decode((string) file_get_contents($i18nFile), true) : null;
$langs = ['fr','en','es','de','uk','it','pl','cs'];
$requiredKeys = ['nav_label','title','kicker','intro','installed_version','latest_version','status','download_channels','install_options_title','verify_title','diagnostics_title','no_github'];
if (!is_array($i18n) || ($i18n['schema'] ?? null) !== 'OPUS_REFBOOK_DOWNLOAD_INSTALL_I18N_V1') {
    $failures[] = 'download i18n invalid';
} else {
    foreach ($langs as $lang) {
        $texts = $i18n['languages'][$lang] ?? null;
        if (!is_array($texts)) {
            $failures[] = 'download i18n missing lang=' . $lang;
            continue;
        }
        foreach ($requiredKeys as $key) {
            if (!isset($texts[$key]) || !is_string($texts[$key]) || trim($texts[$key]) === '') {
                $failures[] = 'download i18n missing key=' . $lang . '.' . $key;
            }
        }
        foreach (['options','verify_steps','diagnostics'] as $listKey) {
            if (!isset($texts[$listKey]) || !is_array($texts[$listKey]) || count($texts[$listKey]) < 3) {
                $failures[] = 'download i18n list incomplete=' . $lang . '.' . $listKey;
            }
        }
    }
}

$pageController = (string) @file_get_contents($root . '/application/reference/Controller/PageController.php');
if (strpos($pageController, "download-install") === false || strpos($pageController, "ReferenceOpusReleaseService") === false) {
    $failures[] = 'page controller not patched';
}

$layout = (string) @file_get_contents($root . '/application/reference/templates/layout.twig');
if (strpos($layout, 'page=download-install') === false || strpos($layout, 'refbook-install.css') === false) {
    $failures[] = 'layout not patched';
}

foreach ($langs as $lang) {
    $file = $root . '/content/refbook/i18n/' . $lang . '.json';
    $json = is_file($file) ? json_decode((string) file_get_contents($file), true) : null;
    if (!is_array($json)) {
        $failures[] = 'i18n invalid lang=' . $lang;
        continue;
    }
    if (!isset($json['labels']['sidebar']['download_install'])) {
        $failures[] = 'sidebar download_install missing lang=' . $lang;
    }
}

if ($failures !== []) {
    echo "P114C3_REFBOOK_OPUS_DOWNLOAD_INSTALL_PAGE_CLEANUP_FAIL\n";
    foreach ($failures as $idx => $failure) {
        echo str_pad((string) ($idx + 1), 3, '0', STR_PAD_LEFT) . ' ' . $failure . "\n";
    }
    exit(1);
}

echo "P114C3_REFBOOK_OPUS_DOWNLOAD_INSTALL_PAGE_CLEANUP_OK\n";
