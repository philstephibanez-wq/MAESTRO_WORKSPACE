<?php

declare(strict_types=1);

/**
 * P112Q2G recipe.
 */

$opusRoot = 'H:\\Opus';
$frameworkRoot = $opusRoot . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'Opus';

if (!is_dir($frameworkRoot)) {
    throw new RuntimeException('OPUS_FRAMEWORK_ROOT_MISSING');
}

function assertNoRootPhpFiles(string $frameworkRoot): void
{
    $entries = scandir($frameworkRoot);

    if ($entries === false) {
        throw new RuntimeException('FRAMEWORK_ROOT_SCAN_FAILED');
    }

    $rootPhp = [];

    foreach ($entries as $entry) {
        $path = $frameworkRoot . DIRECTORY_SEPARATOR . $entry;

        if (is_file($path) && strtolower(pathinfo($entry, PATHINFO_EXTENSION)) === 'php') {
            $rootPhp[] = $entry;
        }
    }

    if ($rootPhp !== []) {
        throw new RuntimeException('ROOT_PHP_FILES_STILL_PRESENT: ' . implode(', ', $rootPhp));
    }

    echo 'PASS NO_ROOT_PHP_FILES' . PHP_EOL;
}

function assertDirectoryAbsent(string $frameworkRoot, string $directory): void
{
    if (is_dir($frameworkRoot . DIRECTORY_SEPARATOR . $directory)) {
        throw new RuntimeException('FORBIDDEN_DIRECTORY_STILL_PRESENT: ' . $directory);
    }

    echo 'PASS DIRECTORY_ABSENT ' . $directory . PHP_EOL;
}

function assertFileExists(string $frameworkRoot, string $relative): void
{
    $path = $frameworkRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);

    if (!is_file($path)) {
        throw new RuntimeException('TARGET_FILE_MISSING: ' . $relative);
    }

    echo 'PASS FILE ' . $relative . PHP_EOL;
}

function requireFramework(string $frameworkRoot, string $relative): void
{
    require_once $frameworkRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
}

function assertClassExistsRecipe(string $class): void
{
    if (!class_exists($class, false) && !interface_exists($class, false) && !trait_exists($class, false)) {
        throw new RuntimeException('CLASS_NOT_LOADED: ' . $class);
    }

    echo 'PASS CLASS ' . $class . PHP_EOL;
}

function lintPhpFile(string $php, string $path): void
{
    $cmd = '"' . $php . '" -l ' . escapeshellarg($path) . ' 2>&1';
    $output = [];
    exec($cmd, $output, $code);

    if ($code !== 0) {
        throw new RuntimeException('PHP_LINT_FAILED: ' . $path . ' :: ' . implode(' ', $output));
    }
}

function assertPhpFilesLintInRoot(string $root): void
{
    $php = 'H:\\UwAmp\\bin\\php\\php-8.5.6\\php.exe';

    if (!is_file($php)) {
        throw new RuntimeException('UWAMP_PHP_MISSING');
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $item) {
        if (!$item->isFile() || strtolower($item->getExtension()) !== 'php') {
            continue;
        }

        $normalized = str_replace('\\', '/', $item->getPathname());

        if (str_contains($normalized, '/vendor/') || str_contains($normalized, '/var/cache/') || str_contains($normalized, '/var/reports/')) {
            continue;
        }

        lintPhpFile($php, $item->getPathname());
    }

    echo 'PASS PHP_LINT ' . $root . PHP_EOL;
}

assertNoRootPhpFiles($frameworkRoot);
assertDirectoryAbsent($frameworkRoot, 'Render');

$targets = [
    'Acl/Acl.php',
    'Core/Bootstrap.php',
    'Core/Kernel.php',
    'Config/ConfigLoader.php',
    'Config/Configuration.php',
    'Debug/Debug.php',
    'Exception/Exception.php',
    'Fsm/Fsm.php',
    'Package/Package.php',
    'Package/PackageRepository.php',
    'Response/ResponseFacade.php',
    'Compatibility/SimpleXMLElementExtended.php',
    'Compatibility/LegacySimpleXMLElementExtended.php',
    'Compatibility/Singleton.php',
    'Compatibility/LegacySingleton.php',
    'Support/Support.php',
    'Validation/Validator.php',
    'View/View.php',
];

foreach ($targets as $target) {
    assertFileExists($frameworkRoot, $target);
}

requireFramework($frameworkRoot, 'Exception/Exception.php');
requireFramework($frameworkRoot, 'Package/Package.php');
requireFramework($frameworkRoot, 'Package/PackageRepository.php');
requireFramework($frameworkRoot, 'Core/Kernel.php');
requireFramework($frameworkRoot, 'Core/Bootstrap.php');
requireFramework($frameworkRoot, 'Config/Configuration.php');
requireFramework($frameworkRoot, 'Config/ConfigLoader.php');
requireFramework($frameworkRoot, 'Debug/Debug.php');
requireFramework($frameworkRoot, 'Acl/Acl.php');
requireFramework($frameworkRoot, 'Fsm/Fsm.php');
requireFramework($frameworkRoot, 'Http/Response.php');
requireFramework($frameworkRoot, 'Response/ResponseFacade.php');
requireFramework($frameworkRoot, 'Template/TemplateRendererInterface.php');
requireFramework($frameworkRoot, 'View/View.php');
requireFramework($frameworkRoot, 'Support/Support.php');
requireFramework($frameworkRoot, 'Validation/Validator.php');
requireFramework($frameworkRoot, 'Compatibility/SimpleXMLElementExtended.php');
requireFramework($frameworkRoot, 'Compatibility/Singleton.php');
requireFramework($frameworkRoot, 'Compatibility/LegacySimpleXMLElementExtended.php');
requireFramework($frameworkRoot, 'Compatibility/LegacySingleton.php');

$classes = [
    \Opus\Exception\Exception::class,
    \Opus\Package\Package::class,
    \Opus\Package\PackageRepository::class,
    \Opus\Core\Kernel::class,
    \Opus\Core\Bootstrap::class,
    \Opus\Config\Configuration::class,
    \Opus\Config\ConfigLoader::class,
    \Opus\Debug\Debug::class,
    \Opus\Acl\Acl::class,
    \Opus\Fsm\Fsm::class,
    \Opus\Response\ResponseFacade::class,
    \Opus\View\View::class,
    \Opus\Support\Support::class,
    \Opus\Validation\Validator::class,
    \Opus\Compatibility\SimpleXMLElementExtended::class,
    \Opus\Compatibility\Singleton::class,
    'OPUS_SimpleXMLElementExtended',
    'OPUS_Singleton',
];

foreach ($classes as $class) {
    assertClassExistsRecipe($class);
}

$package = new \Opus\Package\Package('demo', 'H:/demo');
$repository = new \Opus\Package\PackageRepository([$package]);
$kernel = new \Opus\Core\Kernel('H:/root', $repository);

if ($kernel->getPackage('demo')->id() !== 'demo') {
    throw new RuntimeException('KERNEL_PACKAGE_LOOKUP_FAILED');
}

if ((new \Opus\Acl\Acl())->canView(true) !== true) {
    throw new RuntimeException('ACL_FACADE_FAILED');
}

if (\Opus\Fsm\Fsm::demoFlow()['initial'] !== 'START') {
    throw new RuntimeException('FSM_FACADE_FAILED');
}

if (!\Opus\Validation\Validator::isEmail('demo@example.com')) {
    throw new RuntimeException('VALIDATOR_FAILED');
}

$response = \Opus\Response\ResponseFacade::html('ok', 201);

if (!$response instanceof \Opus\Http\Response || $response->status !== 201) {
    throw new RuntimeException('RESPONSE_FACADE_FAILED');
}

echo 'PASS RUNTIME_COMPAT_CLASSES' . PHP_EOL;

assertPhpFilesLintInRoot($frameworkRoot);
assertPhpFilesLintInRoot($opusRoot . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'recipe');
assertPhpFilesLintInRoot($opusRoot . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'fixtures');

echo 'P112Q2G_ROOT_NAMESPACE_AND_RENDER_CLEANUP_RECIPE_OK' . PHP_EOL;
