<?php
declare(strict_types=1);

$root = dirname(__DIR__, 2);
$file = $root . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'reference' . DIRECTORY_SEPARATOR . 'Service' . DIRECTORY_SEPARATOR . 'ReferenceDiagramModelBuilder.php';

if (!is_file($file)) {
    fwrite(STDERR, "P114A4_STATIC_FAIL: builder missing\n");
    exit(1);
}

$source = (string) file_get_contents($file);
$checks = [
    'begin label present' => str_contains($source, "'Begin'"),
    'end label present' => str_contains($source, "'End'"),
    'french start label removed' => !str_contains($source, "'Début'"),
    'french end label removed' => !str_contains($source, "'Fin'"),
    'terminal endpoint still explicit' => str_contains($source, "__START__") && str_contains($source, "__END__"),
];

foreach ($checks as $label => $ok) {
    if (!$ok) {
        fwrite(STDERR, "P114A4_STATIC_FAIL: {$label}\n");
        exit(1);
    }
}

echo "P114A4_REFBOOK_DIAGRAM_TERMINAL_LABELS_ENGLISH_STATIC_SMOKE_OK\n";
