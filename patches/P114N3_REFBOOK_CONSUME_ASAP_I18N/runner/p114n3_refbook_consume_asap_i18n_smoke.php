<?php
declare(strict_types=1);

$refbookRoot = 'H:\\ASAP_REF_BOOK';

$abstractPath = $refbookRoot . '\\application\\reference\\Controller\\AbstractRefBookController.php';
$repositoryPath = $refbookRoot . '\\application\\reference\\Service\\ReferenceRuntimeSnapshotRepository.php';

$abstract = file_get_contents($abstractPath);
$repository = file_get_contents($repositoryPath);

if (!is_string($abstract) || !is_string($repository)) {
    fwrite(STDERR, "P114N3_SMOKE_READ_FAILED\n");
    exit(1);
}

$needles = [
    [$abstract, 'new ReferenceRuntimeSnapshotRepository(ReferenceAsapRootLocator::fromEnvironment(), $this->language())', 'P114N3_SMOKE_LANGUAGE_INJECTION_MISSING'],
    [$repository, 'use ASAP\\RefBook\\Api\\LocalizedRefBookDocumentationProvider;', 'P114N3_SMOKE_LOCALIZED_PROVIDER_IMPORT_MISSING'],
    [$repository, 'use ASAP\\RefBook\\I18n\\RefBookDocumentationI18nCatalog;', 'P114N3_SMOKE_CATALOG_IMPORT_MISSING'],
    [$repository, 'use ASAP\\RefBook\\I18n\\RefBookDocumentationLocale;', 'P114N3_SMOKE_LOCALE_IMPORT_MISSING'],
    [$repository, 'private readonly ?string $language = null', 'P114N3_SMOKE_LANGUAGE_PROPERTY_MISSING'],
    [$repository, 'LocalizedRefBookDocumentationProvider(new RefBookDocumentationI18nCatalog())', 'P114N3_SMOKE_LOCALIZATION_CALL_MISSING'],
];

foreach ($needles as [$haystack, $needle, $error]) {
    if (!str_contains($haystack, $needle)) {
        fwrite(STDERR, $error . "\n");
        exit(1);
    }
}

echo "P114N3_REFBOOK_CONSUME_ASAP_I18N_SMOKE_OK\n";
