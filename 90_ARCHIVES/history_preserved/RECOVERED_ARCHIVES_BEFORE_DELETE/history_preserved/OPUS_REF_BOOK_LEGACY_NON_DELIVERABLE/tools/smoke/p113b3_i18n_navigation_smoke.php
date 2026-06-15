<?php
declare(strict_types=1);

/*
 * P113B3 smoke.
 *
 * Runs each language/page check in a separate PHP process.
 */

$root = dirname(__DIR__, 2);
$php = PHP_BINARY;

$checks = [
    ['fr', '', 'Canal documentaire'],
    ['en', '', 'Documentation pipeline'],
    ['es', '', 'Canal documental'],
    ['fr', 'api-reference', 'Comment lire cette page'],
    ['en', 'api-reference', 'How to read this page'],
    ['es', 'api-reference', 'Cómo leer esta página'],
    ['fr', 'symbol-0', 'Méthodes publiques'],
    ['en', 'symbol-0', 'Public methods'],
    ['es', 'symbol-0', 'Métodos públicos'],
];

foreach ($checks as [$lang, $page, $expected]) {
    $tmp = tempnam(sys_get_temp_dir(), 'p113b3_');
    if ($tmp === false) {
        fwrite(STDERR, 'P113B3_TMP_CREATE_FAILED' . PHP_EOL);
        exit(1);
    }

    $tmpPhp = $tmp . '.php';
    @unlink($tmp);

    $query = 'lang=' . rawurlencode($lang) . ($page !== '' ? '&page=' . rawurlencode($page) : '');

    $script = "<?php\n"
        . "declare(strict_types=1);\n"
        . 'chdir(' . var_export($root, true) . ");\n"
        . '$_GET = ["lang" => ' . var_export($lang, true) . ', "page" => ' . var_export($page, true) . "];\n"
        . 'if ($_GET["page"] === "") { unset($_GET["page"]); }' . "\n"
        . '$_SERVER["REQUEST_URI"] = "/OPUS_REF_BOOK/?' . $query . "\";\n"
        . '$_SERVER["REQUEST_METHOD"] = "GET";' . "\n"
        . 'require ' . var_export($root . '/public/index.php', true) . ";\n";

    if (file_put_contents($tmpPhp, $script) === false) {
        fwrite(STDERR, 'P113B3_TMP_WRITE_FAILED=' . $tmpPhp . PHP_EOL);
        exit(1);
    }

    $cmd = '"' . $php . '" "' . $tmpPhp . '"';
    $output = [];
    $exitCode = 0;
    exec($cmd, $output, $exitCode);
    @unlink($tmpPhp);

    $body = implode(PHP_EOL, $output);

    if ($exitCode !== 0) {
        fwrite(STDERR, 'P113B3_CHILD_EXIT_' . $lang . '_' . ($page !== '' ? $page : 'home') . '=' . $exitCode . PHP_EOL . $body . PHP_EOL);
        exit(1);
    }

    if (!str_contains($body, $expected)) {
        fwrite(STDERR, 'P113B3_CONTENT_MISSING=' . $lang . ':' . ($page !== '' ? $page : 'home') . PHP_EOL . $body . PHP_EOL);
        exit(1);
    }

    echo 'P113B3_I18N_OK=' . $lang . ':' . ($page !== '' ? $page : 'home') . PHP_EOL;
}

echo 'P113B3_I18N_NAVIGATION_SMOKE_OK' . PHP_EOL;