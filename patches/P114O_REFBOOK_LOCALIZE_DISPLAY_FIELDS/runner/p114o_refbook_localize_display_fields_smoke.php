<?php
declare(strict_types=1);

$servicePath = 'H:\\ASAP_REF_BOOK\\application\\reference\\Service\\ReferenceCatalogService.php';

$source = file_get_contents($servicePath);
if (!is_string($source)) {
    fwrite(STDERR, "P114O_SMOKE_READ_FAILED\n");
    exit(1);
}

$mustHave = [
    'use ASAP\\RefBook\\I18n\\RefBookDocumentationI18nCatalog;',
    'use ASAP\\RefBook\\I18n\\RefBookDocumentationLocale;',
    'private ?RefBookDocumentationI18nCatalog $documentationI18nCatalog = null;',
    '$symbol = $this->localizeDisplayDocumentation($symbol);',
    'foreach ([\'role\', \'responsibility\'] as $key)',
    'foreach ([\'role\', \'behavior\'] as $key)',
    'foreach ([\'preconditions\', \'postconditions\', \'side_effects\'] as $listKey)',
    'translateSourceText($source, $language, $path)',
];

foreach ($mustHave as $needle) {
    if (!str_contains($source, $needle)) {
        fwrite(STDERR, "P114O_SMOKE_MISSING=" . $needle . "\n");
        exit(1);
    }
}

echo "P114O_REFBOOK_LOCALIZE_DISPLAY_FIELDS_SMOKE_OK\n";
