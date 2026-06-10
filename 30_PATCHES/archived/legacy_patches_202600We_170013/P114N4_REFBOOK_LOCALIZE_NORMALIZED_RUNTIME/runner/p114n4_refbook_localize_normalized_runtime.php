<?php
declare(strict_types=1);

$refbookRoot = 'H:\\ASAP_REF_BOOK';
$repositoryPath = $refbookRoot . '\\application\\reference\\Service\\ReferenceRuntimeSnapshotRepository.php';

$source = file_get_contents($repositoryPath);
if (!is_string($source)) {
    fwrite(STDERR, "P114N4_REPOSITORY_READ_FAILED\n");
    exit(1);
}

$badBlockPattern = '~        \$snapshot\s*=\s*\$provider->snapshot\(\);\R\R        if \(\$this->language !== null\) \{\R            \$language\s*=\s*RefBookDocumentationLocale::assertSupported\(\$this->language\);\R            \$localizedProvider\s*=\s*new LocalizedRefBookDocumentationProvider\(new RefBookDocumentationI18nCatalog\(\)\);\R            \$snapshot\s*=\s*\$localizedProvider->localizeSnapshot\(\$snapshot,\s*\$language\);\R        \}\R\R        return \$this->normalize\(\$snapshot\);\R~';

$goodBlock = <<<'PHP'
        $snapshot = $provider->snapshot();
        $runtime = $this->normalize($snapshot);

        if ($this->language !== null) {
            $language = RefBookDocumentationLocale::assertSupported($this->language);
            $localizedProvider = new LocalizedRefBookDocumentationProvider(new RefBookDocumentationI18nCatalog());
            $runtime = $localizedProvider->localizeSnapshot($runtime, $language);
        }

        return $runtime;
PHP;
$goodBlock .= PHP_EOL;

if (!str_contains($source, '$runtime = $this->normalize($snapshot);')) {
    $updated = preg_replace($badBlockPattern, $goodBlock, $source, 1, $count);
    if (!is_string($updated)) {
        fwrite(STDERR, "P114N4_REPOSITORY_REGEX_FAILED\n");
        exit(1);
    }
    if ($count !== 1) {
        fwrite(STDERR, "P114N4_RAW_LOCALIZATION_BLOCK_NOT_FOUND\n");
        exit(1);
    }
    $source = $updated;
}

$required = [
    'use ASAP\\RefBook\\Api\\LocalizedRefBookDocumentationProvider;',
    'use ASAP\\RefBook\\I18n\\RefBookDocumentationI18nCatalog;',
    'use ASAP\\RefBook\\I18n\\RefBookDocumentationLocale;',
    'private readonly ?string $language = null',
    '$runtime = $this->normalize($snapshot);',
    '$runtime = $localizedProvider->localizeSnapshot($runtime, $language);',
    'return $runtime;',
];

foreach ($required as $needle) {
    if (!str_contains($source, $needle)) {
        fwrite(STDERR, "P114N4_REQUIRED_NEEDLE_MISSING=" . $needle . "\n");
        exit(1);
    }
}

if (str_contains($source, '$snapshot = $localizedProvider->localizeSnapshot($snapshot, $language);')) {
    fwrite(STDERR, "P114N4_RAW_SNAPSHOT_LOCALIZATION_STILL_PRESENT\n");
    exit(1);
}

if (file_put_contents($repositoryPath, $source) === false) {
    fwrite(STDERR, "P114N4_REPOSITORY_WRITE_FAILED\n");
    exit(1);
}

echo "P114N4_PATCH_SOURCE_UPDATE_OK\n";
