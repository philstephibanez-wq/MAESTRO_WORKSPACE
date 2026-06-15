<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$smokes = [
    'tools/smoke/p114a_refbook_public_visibility_seo_branding_static_smoke.php',
    'tools/smoke/p114a2_refbook_header_branding_fine_tune_static_smoke.php',
    'tools/smoke/p114a3_refbook_header_branding_pro_readability_static_smoke.php',
    'tools/smoke/p114a4_refbook_diagram_terminal_labels_english_static_smoke.php',
];

foreach ($smokes as $relative) {
    $command = 'php ' . escapeshellarg($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative));
    passthru($command, $exitCode);
    if ($exitCode !== 0) {
        fwrite(STDERR, 'P114A5_STATIC_FAIL: child smoke failed=' . $relative . PHP_EOL);
        exit(1);
    }
}

echo 'P114A5_REFBOOK_PUBLIC_SEO_BRANDING_FINAL_STATIC_SMOKE_OK' . PHP_EOL;
