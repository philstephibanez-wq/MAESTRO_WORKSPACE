<?php
declare(strict_types=1);

/*
 * P115E_OFFICIAL_VERSION_CACHE_SYNC
 *
 * Usage:
 *   php tools/sync_official_versions.php
 *
 * Contract:
 *   - maintenance script only
 *   - writes var/version/official_versions.json
 *   - RefBook rendering never calls GitHub/network directly
 */

$root = dirname(__DIR__);
$target = $root . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'version' . DIRECTORY_SEPARATOR . 'official_versions.json';
$repository = 'philstephibanez-wq/OPUS_REF_BOOK';

$remoteHead = run('git ls-remote origin HEAD');
$defaultCommit = '';
if ($remoteHead !== '') {
    $parts = preg_split('/\s+/', trim($remoteHead));
    $defaultCommit = (string) ($parts[0] ?? '');
}

$tagsOutput = run('git ls-remote --tags --refs origin');
$latestTag = null;
foreach (preg_split('/\R/', $tagsOutput) ?: [] as $line) {
    $line = trim($line);
    if ($line === '') {
        continue;
    }

    $parts = preg_split('/\s+/', $line);
    $ref = (string) ($parts[1] ?? '');
    if (str_starts_with($ref, 'refs/tags/')) {
        $latestTag = substr($ref, 10);
    }
}

$payload = [
    'schema' => 'OPUS_REFBOOK_OFFICIAL_VERSIONS_V1',
    'repository' => $repository,
    'repository_url' => 'https://github.com/' . $repository,
    'default_branch' => 'main',
    'default_branch_commit' => $defaultCommit,
    'latest_tag' => $latestTag,
    'latest_release' => $latestTag,
    'fetched_at' => date(DATE_ATOM),
    'source' => 'git-ls-remote',
];

if (!is_dir(dirname($target)) && !mkdir(dirname($target), 0775, true) && !is_dir(dirname($target))) {
    fwrite(STDERR, 'Cannot create version directory: ' . dirname($target) . PHP_EOL);
    exit(1);
}

file_put_contents($target, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL);
echo 'official_versions.json updated: ' . $target . PHP_EOL;

function run(string $command): string
{
    $output = [];
    $code = 0;
    exec($command . ' 2>&1', $output, $code);
    if ($code !== 0) {
        return '';
    }

    return implode(PHP_EOL, $output);
}
