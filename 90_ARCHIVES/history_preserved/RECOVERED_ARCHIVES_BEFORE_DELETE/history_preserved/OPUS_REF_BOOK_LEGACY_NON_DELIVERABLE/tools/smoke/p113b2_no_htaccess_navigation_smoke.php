<?php
declare(strict_types=1);

/*
 * P113B2 smoke.
 *
 * Windows-safe: each check writes a temporary PHP child script and runs it.
 * This avoids fragile `php -r` quoting on cmd.exe.
 */

$root = dirname(__DIR__, 2);
$php = PHP_BINARY;

$checks = [
    'api-reference' => 'Comment lire cette page',
    'guide-architecture' => 'Architecture',
    'domain-fsm' => 'Domaine',
    'symbol-0' => 'Méthodes publiques',
];

foreach ($checks as $page => $expected) {
    $tmp = tempnam(sys_get_temp_dir(), 'p113b2_');
    if ($tmp === false) {
        fwrite(STDERR, 'P113B2_TMP_CREATE_FAILED' . PHP_EOL);
        exit(1);
    }

    $tmpPhp = $tmp . '.php';
    @unlink($tmp);

    $script = "<?php\n"
        . "declare(strict_types=1);\n"
        . '$_GET = ["page" => ' . var_export($page, true) . "];\n"
        . '$_SERVER["REQUEST_URI"] = "/OPUS_REF_BOOK/?page=' . rawurlencode($page) . "\";\n"
        . '$_SERVER["REQUEST_METHOD"] = "GET";' . "\n"
        . 'require ' . var_export($root . '/public/index.php', true) . ";\n";

    if (file_put_contents($tmpPhp, $script) === false) {
        fwrite(STDERR, 'P113B2_TMP_WRITE_FAILED=' . $tmpPhp . PHP_EOL);
        exit(1);
    }

    $cmd = '"' . $php . '" "' . $tmpPhp . '"';
    $output = [];
    $exitCode = 0;
    exec($cmd, $output, $exitCode);
    @unlink($tmpPhp);

    $body = implode(PHP_EOL, $output);

    if ($exitCode !== 0) {
        fwrite(STDERR, 'P113B2_CHILD_EXIT_' . $page . '=' . $exitCode . PHP_EOL . $body . PHP_EOL);
        exit(1);
    }

    if (!str_contains($body, $expected)) {
        fwrite(STDERR, 'P113B2_CONTENT_MISSING=' . $page . PHP_EOL . $body . PHP_EOL);
        exit(1);
    }

    echo 'P113B2_NAV_OK=' . $page . PHP_EOL;
}

echo 'P113B2_NO_HTACCESS_NAVIGATION_SMOKE_OK' . PHP_EOL;