<?php
declare(strict_types=1);

$refbookRoot = 'H:\\ASAP_REF_BOOK';

$abstractPath = $refbookRoot . '\\application\\reference\\Controller\\AbstractRefBookController.php';
$repositoryPath = $refbookRoot . '\\application\\reference\\Service\\ReferenceRuntimeSnapshotRepository.php';

$abstract = file_get_contents($abstractPath);
$repository = file_get_contents($repositoryPath);

if (!is_string($abstract)) {
    fwrite(STDERR, "P114N3_ABSTRACT_READ_FAILED\n");
    exit(1);
}
if (!is_string($repository)) {
    fwrite(STDERR, "P114N3_REPOSITORY_READ_FAILED\n");
    exit(1);
}

$abstractPattern = '~new\s+ReferenceRuntimeSnapshotRepository\s*\(\s*ReferenceAsapRootLocator::fromEnvironment\(\)\s*\)~';
$abstractReplacement = 'new ReferenceRuntimeSnapshotRepository(ReferenceAsapRootLocator::fromEnvironment(), $this->language())';

$count = 0;
$abstractUpdated = preg_replace($abstractPattern, $abstractReplacement, $abstract, 1, $count);
if (!is_string($abstractUpdated)) {
    fwrite(STDERR, "P114N3_ABSTRACT_REGEX_FAILED\n");
    exit(1);
}
if ($count === 0 && !str_contains($abstract, $abstractReplacement)) {
    fwrite(STDERR, "P114N3_ABSTRACT_RUNTIME_REPOSITORY_CALL_NOT_FOUND\n");
    exit(1);
}
$abstract = $abstractUpdated;

$imports = [
    'use ASAP\\RefBook\\Api\\LocalizedRefBookDocumentationProvider;',
    'use ASAP\\RefBook\\I18n\\RefBookDocumentationI18nCatalog;',
    'use ASAP\\RefBook\\I18n\\RefBookDocumentationLocale;',
];

foreach ($imports as $import) {
    if (!str_contains($repository, $import)) {
        $repository = preg_replace(
            '~(use\s+ASAP\\\\RefBook\\\\Api\\\\RefBookRestSnapshotProvider;\R)~',
            '$1' . $import . PHP_EOL,
            $repository,
            1,
            $importCount
        );
        if (!is_string($repository)) {
            fwrite(STDERR, "P114N3_REPOSITORY_IMPORT_REGEX_FAILED\n");
            exit(1);
        }
        if ($importCount === 0) {
            fwrite(STDERR, "P114N3_REPOSITORY_IMPORT_NEEDLE_NOT_FOUND=" . $import . "\n");
            exit(1);
        }
    }
}

$constructorPattern = '~public\s+function\s+__construct\s*\(\s*private\s+readonly\s+string\s+\$asapRoot\s*\)~';
$constructorReplacement = 'public function __construct(private readonly string $asapRoot, private readonly ?string $language = null)';

$repositoryUpdated = preg_replace($constructorPattern, $constructorReplacement, $repository, 1, $constructorCount);
if (!is_string($repositoryUpdated)) {
    fwrite(STDERR, "P114N3_REPOSITORY_CONSTRUCTOR_REGEX_FAILED\n");
    exit(1);
}
if ($constructorCount === 0 && !str_contains($repository, 'private readonly ?string $language = null')) {
    fwrite(STDERR, "P114N3_REPOSITORY_CONSTRUCTOR_NEEDLE_NOT_FOUND\n");
    exit(1);
}
$repository = $repositoryUpdated;

if (!str_contains($repository, 'LocalizedRefBookDocumentationProvider(new RefBookDocumentationI18nCatalog())')) {
    $snapshotPattern = '~(\$snapshot\s*=\s*\$provider->snapshot\(\);\R)(\s*return\s+\$this->normalize\(\$snapshot\);\R)~';
    $snapshotReplacement = <<<'PHP'
$1
        if ($this->language !== null) {
            $language = RefBookDocumentationLocale::assertSupported($this->language);
            $localizedProvider = new LocalizedRefBookDocumentationProvider(new RefBookDocumentationI18nCatalog());
            $snapshot = $localizedProvider->localizeSnapshot($snapshot, $language);
        }

$2
PHP;

    $repositoryUpdated = preg_replace($snapshotPattern, $snapshotReplacement, $repository, 1, $snapshotCount);
    if (!is_string($repositoryUpdated)) {
        fwrite(STDERR, "P114N3_REPOSITORY_SNAPSHOT_REGEX_FAILED\n");
        exit(1);
    }
    if ($snapshotCount === 0) {
        fwrite(STDERR, "P114N3_REPOSITORY_SNAPSHOT_NEEDLE_NOT_FOUND\n");
        exit(1);
    }
    $repository = $repositoryUpdated;
}

if (file_put_contents($abstractPath, $abstract) === false) {
    fwrite(STDERR, "P114N3_ABSTRACT_WRITE_FAILED\n");
    exit(1);
}

if (file_put_contents($repositoryPath, $repository) === false) {
    fwrite(STDERR, "P114N3_REPOSITORY_WRITE_FAILED\n");
    exit(1);
}

echo "P114N3_PATCH_SOURCE_UPDATE_OK\n";
