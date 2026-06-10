<?php
declare(strict_types=1);

$repositoryPath = 'H:\\ASAP_REF_BOOK\\application\\reference\\Service\\ReferenceRuntimeSnapshotRepository.php';

$source = file_get_contents($repositoryPath);
if (!is_string($source)) {
    fwrite(STDERR, "P114N4_SMOKE_READ_FAILED\n");
    exit(1);
}

$mustHave = [
    '$runtime = $this->normalize($snapshot);',
    '$runtime = $localizedProvider->localizeSnapshot($runtime, $language);',
    'return $runtime;',
];

foreach ($mustHave as $needle) {
    if (!str_contains($source, $needle)) {
        fwrite(STDERR, "P114N4_SMOKE_MISSING=" . $needle . "\n");
        exit(1);
    }
}

$mustNotHave = [
    '$snapshot = $localizedProvider->localizeSnapshot($snapshot, $language);',
];

foreach ($mustNotHave as $needle) {
    if (str_contains($source, $needle)) {
        fwrite(STDERR, "P114N4_SMOKE_FORBIDDEN=" . $needle . "\n");
        exit(1);
    }
}

echo "P114N4_REFBOOK_LOCALIZE_NORMALIZED_RUNTIME_SMOKE_OK\n";
