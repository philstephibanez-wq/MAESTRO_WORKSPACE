<?php

declare(strict_types=1);

$root = dirname(__DIR__, 2);
$layout = $root . DIRECTORY_SEPARATOR . 'application/reference/templates/layout.twig';
$css = $root . DIRECTORY_SEPARATOR . 'public/assets/css/refbook-runtime.css';

$layoutText = is_file($layout) ? (string) file_get_contents($layout) : '';
$cssText = is_file($css) ? (string) file_get_contents($css) : '';

$checks = [
    'layout uses P114A6 css cache key' => str_contains($layoutText, 'refbook-runtime.css?v=P114A6'),
    'language switcher is now a form selectbox' => str_contains($layoutText, 'language-select-form') && str_contains($layoutText, '<select id="refbook-language"'),
    'language select preserves theme' => str_contains($layoutText, '<input type="hidden" name="theme" value="{{ theme }}">'),
    'language select preserves page' => str_contains($layoutText, 'name="page" value="{{ pageSlug }}"'),
    'old language segmented nav removed' => !str_contains($layoutText, '<nav class="language-switcher segmented-switcher"'),
    'branding names Opus explicitly' => str_contains($layoutText, 'Opus Framework · source-available · dual licensed'),
    'css has P114A6 marker' => str_contains($cssText, 'P114A6: theme-aware professional branding card and language selectbox'),
    'branding card uses theme surface token' => str_contains($cssText, 'var(--surface)') && str_contains($cssText, 'var(--accent)'),
    'branding card no longer uses fixed cyan-only left border in final override' => str_contains($cssText, 'border-left-color: var(--accent);'),
    'language select css exists' => str_contains($cssText, '.language-select') && str_contains($cssText, 'appearance: none;'),
    'paper theme select override exists' => str_contains($cssText, 'body.theme-paper .language-select'),
];

$failed = array_keys(array_filter($checks, static fn(bool $ok): bool => !$ok));
if ($failed !== []) {
    fwrite(STDERR, 'P114A6_STATIC_FAIL: ' . implode(', ', $failed) . PHP_EOL);
    exit(1);
}

echo 'P114A6_REFBOOK_THEME_AWARE_HEADER_AND_LANGUAGE_SELECT_STATIC_SMOKE_OK' . PHP_EOL;
