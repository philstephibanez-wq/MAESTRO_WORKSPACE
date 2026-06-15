<?php
declare(strict_types=1);
$root = dirname(__DIR__, 2);
function fail(string $message): never { fwrite(STDERR, $message . PHP_EOL); exit(1); }
$service = (string) file_get_contents($root . '/application/reference/Service/ReferenceContentService.php');
foreach (["'fr', 'en', 'es', 'de', 'uk', 'it', 'pl'", "['code' => 'pl', 'label' => 'Polski']", 'publicUiLabels', 'translatedPublicLabels'] as $needle) {
    if (!str_contains($service, $needle)) fail('P114B2_STATIC_FAIL: service marker missing=' . $needle);
}
$controller = (string) file_get_contents($root . '/application/reference/Controller/AbstractRefBookController.php');
if (!str_contains($controller, "['languageOptions'] = $" . "content->languageOptions();")) fail('P114B2_STATIC_FAIL: languageOptions not exposed');
$catalog = (string) file_get_contents($root . '/application/reference/Service/ReferenceCatalogService.php');
foreach (['display_file', 'portablePath', '<OPUS_ROOT>/'] as $needle) {
    if (!str_contains($catalog, $needle)) fail('P114B2_STATIC_FAIL: catalog portable path marker missing=' . $needle);
}
$layout = (string) file_get_contents($root . '/application/reference/templates/layout.twig');
foreach (['refbook-runtime.css?v=P114B2', 'ui.sidebar.assets_docs', 'ui.sidebar.legal', 'languageOptions'] as $needle) {
    if (!str_contains($layout, $needle)) fail('P114B2_STATIC_FAIL: layout marker missing=' . $needle);
}
foreach (['api-reference.twig','asset-diagnostics.twig','legal.twig','symbol.twig'] as $template) {
    $content = (string) file_get_contents($root . '/application/reference/templates/pages/' . $template);
    if (str_contains($content, 'H:\\') || str_contains($content, 'H:\OPUS')) fail('P114B2_STATIC_FAIL: local absolute path remains in ' . $template);
}
$api = (string) file_get_contents($root . '/application/reference/templates/pages/api-reference.twig');
foreach (['ui.runtime.title','ui.runtime.endpoints_title','ui.runtime.method','ui.runtime.path'] as $needle) {
    if (!str_contains($api, $needle)) fail('P114B2_STATIC_FAIL: api template missing i18n marker=' . $needle);
}
$assets = (string) file_get_contents($root . '/application/reference/templates/pages/asset-diagnostics.twig');
foreach (['&lt;OPUS_ROOT&gt;/DOC/refbook/examples', '&lt;OPUS_ROOT&gt;/DOC/refbook/diagrams', 'ui.assets.correction_rule'] as $needle) {
    if (!str_contains($assets, $needle)) fail('P114B2_STATIC_FAIL: asset template marker missing=' . $needle);
}
$css = (string) file_get_contents($root . '/public/assets/css/refbook-runtime.css');
foreach (['P114B2: final paper diagram override', 'body.theme-paper .diagram-node text', '!important'] as $needle) {
    if (!str_contains($css, $needle)) fail('P114B2_STATIC_FAIL: css marker missing=' . $needle);
}
foreach (['de','uk','it','pl'] as $lang) {
    $file = $root . '/content/refbook/i18n/' . $lang . '.json';
    if (!is_file($file)) fail('P114B2_STATIC_FAIL: i18n file missing=' . $lang);
    $json = json_decode((string) file_get_contents($file), true);
    if (!is_array($json)) fail('P114B2_STATIC_FAIL: i18n json invalid=' . $lang);
    if (($json['schema'] ?? '') !== 'OPUS_REFBOOK_I18N_V1') fail('P114B2_STATIC_FAIL: i18n schema invalid=' . $lang);
    if (($json['language'] ?? '') !== $lang) fail('P114B2_STATIC_FAIL: i18n language mismatch=' . $lang);
    if (str_contains((string) file_get_contents($file), 'H:\\') || str_contains((string) file_get_contents($file), 'H:\OPUS')) fail('P114B2_STATIC_FAIL: local absolute path remains in i18n=' . $lang);
}
echo "P114B2_REFBOOK_FULL_PUBLIC_I18N_PORTABLE_PATHS_STATIC_SMOKE_OK\n";
