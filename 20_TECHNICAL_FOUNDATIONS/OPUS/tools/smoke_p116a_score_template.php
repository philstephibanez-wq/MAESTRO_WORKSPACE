<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Opus\Template\ScoreTemplateRenderer;

$root = sys_get_temp_dir() . '/opus_score_template_smoke_' . bin2hex(random_bytes(4));
if (!mkdir($root, 0775, true) && !is_dir($root)) {
    fwrite(STDERR, 'P116A_SCORE_TEMPLATE_SMOKE_TMP_CREATE_FAILED' . PHP_EOL);
    exit(1);
}

file_put_contents($root . '/body.score', '<strong>{{ title }}</strong> — {{{ raw.html }}}');
file_put_contents($root . '/page.score', 'Hello {{ user.name }} :: [[ include:body.score ]]');

$renderer = new ScoreTemplateRenderer($root);
$html = $renderer->render('page.score', [
    'user' => ['name' => 'Steve & Maestro'],
    'title' => 'ScoreTemplate <P116A>',
    'raw' => ['html' => '<em>OK</em>'],
]);

$expected = 'Hello Steve &amp; Maestro :: <strong>ScoreTemplate &lt;P116A&gt;</strong> — <em>OK</em>';

array_map('unlink', glob($root . '/*.score') ?: []);
rmdir($root);

if ($html !== $expected) {
    fwrite(STDERR, 'P116A_SCORE_TEMPLATE_SMOKE_FAILED' . PHP_EOL);
    fwrite(STDERR, 'EXPECTED=' . $expected . PHP_EOL);
    fwrite(STDERR, 'ACTUAL=' . $html . PHP_EOL);
    exit(1);
}

echo 'P116A_SCORE_TEMPLATE_SMOKE_OK' . PHP_EOL;
