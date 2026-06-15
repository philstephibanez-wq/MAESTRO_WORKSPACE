<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);

$files = [
    'service' => $root . '/application/reference/Service/ReferenceContentService.php',
    'layout' => $root . '/application/reference/templates/layout.twig',
    'asset' => $root . '/application/reference/templates/pages/asset-diagnostics.twig',
    'symbol' => $root . '/application/reference/templates/pages/symbol.twig',
    'css' => $root . '/public/assets/css/refbook-runtime.css',
];

foreach ($files as $label => $file) {
    if (!is_file($file)) {
        fwrite(STDERR, 'P114B3_STATIC_FAIL: missing file=' . $label . PHP_EOL);
        exit(1);
    }
}

$service = file_get_contents($files['service']);
$layout = file_get_contents($files['layout']);
$asset = file_get_contents($files['asset']);
$symbol = file_get_contents($files['symbol']);
$css = file_get_contents($files['css']);

$checks = [
    'supported languages include pl' => str_contains($service, "['fr', 'en', 'es', 'de', 'uk', 'it', 'pl']"),
    'public labels override loaded partial labels' => str_contains($service, 'array_replace_recursive($labels, $this->publicUiLabels())'),
    'public path sanitizer present' => str_contains($service, 'sanitizePublicText'),
    'layout cache bumped' => str_contains($layout, 'refbook-runtime.css?v=P114B3'),
    'language selectbox present' => str_contains($layout, '<select id="refbook-language"'),
    'language submit is I18N' => str_contains($layout, "{{ ui.language.apply|default('OK') }}"),
    'asset table type is I18N' => str_contains($asset, '{{ ui.assets.type }}'),
    'asset table id is I18N' => str_contains($asset, '{{ ui.assets.id }}'),
    'asset top limit is I18N' => str_contains($asset, '{{ ui.assets.top_limit }}'),
    'symbol portable display file used' => str_contains($symbol, 'symbol.display_file'),
    'paper diagram readability override present' => str_contains($css, 'P114B3: enforce paper/light Mermaid readability'),
    'paper node text explicit dark fill' => str_contains($css, 'body.theme-paper .diagram-node text'),
];

foreach ($checks as $label => $ok) {
    if (!$ok) {
        fwrite(STDERR, 'P114B3_STATIC_FAIL: ' . $label . PHP_EOL);
        exit(1);
    }
}

foreach (['de', 'uk', 'it', 'pl'] as $lang) {
    $file = $root . '/content/refbook/i18n/' . $lang . '.json';
    if (!is_file($file)) {
        fwrite(STDERR, 'P114B3_STATIC_FAIL: missing i18n=' . $lang . PHP_EOL);
        exit(1);
    }

    $json = json_decode((string) file_get_contents($file), true);
    if (!is_array($json) || ($json['schema'] ?? null) !== 'OPUS_REFBOOK_I18N_V1' || ($json['language'] ?? null) !== $lang) {
        fwrite(STDERR, 'P114B3_STATIC_FAIL: invalid i18n=' . $lang . PHP_EOL);
        exit(1);
    }

    $text = (string) file_get_contents($file);
    if (str_contains($text, 'H:\\Opus') || str_contains($text, 'H:/OPUS')) {
        fwrite(STDERR, 'P114B3_STATIC_FAIL: local path leaked in i18n=' . $lang . PHP_EOL);
        exit(1);
    }

    if (in_array($lang, ['uk', 'it', 'pl'], true)) {
        foreach (['Symbolprofil', 'Vertrag', 'Quelle', 'Öffentliche'] as $bad) {
            if (str_contains($text, $bad)) {
                fwrite(STDERR, 'P114B3_STATIC_FAIL: German label leak=' . $lang . ':' . $bad . PHP_EOL);
                exit(1);
            }
        }
    }
}

echo 'P114B3_REFBOOK_I18N_TEMPLATE_PATHS_LIGHT_THEME_STATIC_SMOKE_OK' . PHP_EOL;
