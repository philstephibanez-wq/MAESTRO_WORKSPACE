<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$service = (string) file_get_contents($root . '/application/reference/Service/ReferenceContentService.php');
$css = (string) file_get_contents($root . '/public/assets/css/refbook-runtime.css');

$checks = [
    'domainDescription fallback no marker' => !str_contains($service, "return '[*domain."),
    'localized fallback helper present' => str_contains($service, 'undocumentedDomainDescription'),
    'P114B4 css marker present' => str_contains($css, 'P114B4: final light-theme diagram readability guard'),
    'paper tspan text guarded' => str_contains($css, 'body.theme-paper .diagram-node tspan'),
];

foreach ($checks as $label => $ok) {
    if (!$ok) {
        fwrite(STDERR, 'P114B4_STATIC_FAIL: ' . $label . PHP_EOL);
        exit(1);
    }
}

$badByLanguage = [
    'uk' => ['Blaue Nacht', 'Helles Papier', 'Nacht', 'Hell', 'Dokumentationspipeline', 'erkannte Domänen', 'Domänenindikatoren', 'Symbolprofil', 'Vertrag', 'Quelle'],
    'it' => ['Blaue Nacht', 'Helles Papier', 'Nacht', 'Hell', 'Dokumentationspipeline', 'erkannte Domänen', 'Domänenindikatoren', 'Symbolprofil', 'Vertrag', 'Quelle'],
    'pl' => ['Blaue Nacht', 'Helles Papier', 'Nacht', 'Hell', 'Dokumentationspipeline', 'erkannte Domänen', 'Domänenindikatoren', 'Symbolprofil', 'Vertrag', 'Quelle'],
];

foreach (['de', 'uk', 'it', 'pl'] as $lang) {
    $file = $root . '/content/refbook/i18n/' . $lang . '.json';
    if (!is_file($file)) {
        fwrite(STDERR, 'P114B4_STATIC_FAIL: missing i18n=' . $lang . PHP_EOL);
        exit(1);
    }
    $text = (string) file_get_contents($file);
    $json = json_decode($text, true);
    if (!is_array($json) || ($json['language'] ?? null) !== $lang) {
        fwrite(STDERR, 'P114B4_STATIC_FAIL: invalid i18n=' . $lang . PHP_EOL);
        exit(1);
    }
    foreach (['RefBook', 'UNCLASSIFIED'] as $domain) {
        if (!isset($json['domain_descriptions'][$domain]) || !is_string($json['domain_descriptions'][$domain])) {
            fwrite(STDERR, 'P114B4_STATIC_FAIL: missing domain description=' . $lang . ':' . $domain . PHP_EOL);
            exit(1);
        }
    }
    foreach ($badByLanguage[$lang] ?? [] as $bad) {
        if (str_contains($text, $bad)) {
            fwrite(STDERR, 'P114B4_STATIC_FAIL: german leak=' . $lang . ':' . $bad . PHP_EOL);
            exit(1);
        }
    }
}

echo 'P114B4_REFBOOK_I18N_GERMAN_LEAK_DOMAIN_FALLBACK_STATIC_SMOKE_OK' . PHP_EOL;
