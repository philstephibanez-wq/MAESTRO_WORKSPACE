<?php
declare(strict_types=1);

$refbookRoot = 'H:\\ASAP_REF_BOOK';

$abstractPath = $refbookRoot . '\\application\\reference\\Controller\\AbstractRefBookController.php';
$repositoryPath = $refbookRoot . '\\application\\reference\\Service\\ReferenceRuntimeSnapshotRepository.php';

$abstract = file_get_contents($abstractPath);
if (!is_string($abstract)) {
    fwrite(STDERR, "P114N2_ABSTRACT_READ_FAILED\n");
    exit(1);
}

$repository = file_get_contents($repositoryPath);
if (!is_string($repository)) {
    fwrite(STDERR, "P114N2_REPOSITORY_READ_FAILED\n");
    exit(1);
}

$oldAbstract = 'new ReferenceRuntimeSnapshotRepository(ReferenceAsapRootLocator::fromEnvironment())';
$newAbstract = 'new ReferenceRuntimeSnapshotRepository(ReferenceAsapRootLocator::fromEnvironment(), $this->language())';

if (!str_contains($abstract, $oldAbstract) && !str_contains($abstract, $newAbstract)) {
    fwrite(STDERR, "P114N2_ABSTRACT_RUNTIME_REPOSITORY_CALL_NOT_FOUND\n");
    exit(1);
}

if (str_contains($abstract, $oldAbstract)) {
    $abstract = str_replace($oldAbstract, $newAbstract, $abstract);
}

if (!str_contains($repository, 'use ASAP\\RefBook\\Api\\LocalizedRefBookDocumentationProvider;')) {
    $needle = "use ASAP\\RefBook\\Api\\RefBookRestSnapshotProvider;\n";
    if (!str_contains($repository, $needle)) {
        fwrite(STDERR, "P114N2_REPOSITORY_IMPORT_NEEDLE_NOT_FOUND\n");
        exit(1);
    }
    $repository = str_replace(
        $needle,
        $needle
        . "use ASAP\\RefBook\\Api\\LocalizedRefBookDocumentationProvider;\n"
        . "use ASAP\\RefBook\\I18n\\RefBookDocumentationI18nCatalog;\n"
        . "use ASAP\\RefBook\\I18n\\RefBookDocumentationLocale;\n",
        $repository
    );
}

$oldConstructor = 'public function __construct(private readonly string $asapRoot)';
$newConstructor = 'public function __construct(private readonly string $asapRoot, private readonly ?string $language = null)';

if (!str_contains($repository, $oldConstructor) && !str_contains($repository, $newConstructor)) {
    fwrite(STDERR, "P114N2_REPOSITORY_CONSTRUCTOR_NEEDLE_NOT_FOUND\n");
    exit(1);
}

if (str_contains($repository, $oldConstructor)) {
    $repository = str_replace($oldConstructor, $newConstructor, $repository);
}

$oldSnapshotLine = "        \$snapshot = \$provider->snapshot();\n\n        return \$this->normalize(\$snapshot);\n";
$newSnapshotBlock = <<<'PHP'
        $snapshot = $provider->snapshot();

        if ($this->language !== null) {
            $language = RefBookDocumentationLocale::assertSupported($this->language);
            $localizedProvider = new LocalizedRefBookDocumentationProvider(new RefBookDocumentationI18nCatalog());
            $snapshot = $localizedProvider->localizeSnapshot($snapshot, $language);
        }

        return $this->normalize($snapshot);
PHP;
$newSnapshotBlock .= "\n";

if (!str_contains($repository, $oldSnapshotLine) && !str_contains($repository, 'LocalizedRefBookDocumentationProvider(new RefBookDocumentationI18nCatalog())')) {
    fwrite(STDERR, "P114N2_REPOSITORY_SNAPSHOT_NEEDLE_NOT_FOUND\n");
    exit(1);
}

if (str_contains($repository, $oldSnapshotLine)) {
    $repository = str_replace($oldSnapshotLine, $newSnapshotBlock, $repository);
}

if (file_put_contents($abstractPath, $abstract) === false) {
    fwrite(STDERR, "P114N2_ABSTRACT_WRITE_FAILED\n");
    exit(1);
}

if (file_put_contents($repositoryPath, $repository) === false) {
    fwrite(STDERR, "P114N2_REPOSITORY_WRITE_FAILED\n");
    exit(1);
}

echo "P114N2_PATCH_SOURCE_UPDATE_OK\n";
