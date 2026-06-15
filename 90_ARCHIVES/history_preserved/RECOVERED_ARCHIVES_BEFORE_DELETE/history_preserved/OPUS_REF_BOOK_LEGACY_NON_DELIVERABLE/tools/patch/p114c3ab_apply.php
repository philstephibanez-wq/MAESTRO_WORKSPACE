<?php
declare(strict_types=1);

$root = realpath(__DIR__ . '/../..');
if ($root === false) {
    fwrite(STDERR, "P114C3AB_APPLY_FAIL: root not found\n");
    exit(1);
}

function fail(string $message): never {
    fwrite(STDERR, "P114C3AB_APPLY_FAIL: " . $message . "\n");
    exit(1);
}

function read_text(string $path): string {
    if (!is_file($path)) {
        fail("missing file " . $path);
    }
    $text = file_get_contents($path);
    if (!is_string($text)) {
        fail("cannot read " . $path);
    }
    return $text;
}

function write_text(string $path, string $text): void {
    $dir = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
        fail("cannot create dir " . $dir);
    }
    if (file_put_contents($path, $text) === false) {
        fail("cannot write " . $path);
    }
}

$contentFile = $root . '/application/reference/Service/ReferenceContentService.php';
$content = read_text($contentFile);

/*
 * 1) Ensure explicit visible fallback helpers exist.
 */
if (strpos($content, 'private function templateUiFallbackLabels(): array') === false) {
    $helper = <<<'PHP'

    /**
     * @return array<string,mixed>
     */
    private function templateUiFallbackLabels(): array
    {
        $paths = [
            'language.current', 'language.fr', 'language.en', 'language.es', 'language.de', 'language.uk', 'language.it', 'language.pl', 'language.cs', 'language.apply',
            'sidebar.api_reference', 'sidebar.guides', 'sidebar.domains', 'sidebar.menu', 'sidebar.search', 'sidebar.assets_docs', 'sidebar.legal', 'sidebar.download_install',
            'home.kicker', 'home.symbols', 'home.domains', 'home.pipeline_title', 'home.guides_title',
            'api.title', 'api.kicker', 'api.intro', 'api.how_to_read', 'api.symbols',
            'domain.kicker', 'domain.symbols', 'domain.with_methods', 'domain.table_symbol', 'domain.table_role', 'domain.table_methods', 'domain.table_source', 'domain.metrics_label', 'domain.public_methods', 'domain.classes', 'domain.interfaces', 'domain.inventory_kicker', 'domain.inventory_title',
            'symbol.fallback_kind', 'symbol.fallback_name', 'symbol.fallback_role', 'symbol.contract_title', 'symbol.no_contract', 'symbol.source_title', 'symbol.source_missing', 'symbol.public_methods_title', 'symbol.no_methods', 'symbol.table_method', 'symbol.table_signature', 'symbol.identity_kicker', 'symbol.identity_title', 'symbol.kind_label', 'symbol.domain_label', 'symbol.namespace_label', 'symbol.namespace_missing', 'symbol.methods_kicker', 'symbol.examples_title', 'symbol.diagrams_title',
            'symbol_extra.responsibility', 'symbol_extra.role', 'symbol_extra.declared_examples_missing', 'symbol_extra.declared_diagrams_missing',
            'legal.kicker', 'legal.title', 'legal.intro', 'legal.copyright_kicker', 'legal.author_title', 'legal.original_author', 'legal.licensing_kicker', 'legal.licensing_title', 'legal.personal_free', 'legal.commercial_required', 'legal.rights_reserved', 'legal.note', 'legal.distribution_kicker', 'legal.distribution_title', 'legal.distribution_body_1', 'legal.distribution_body_2',
            'not_found.kicker', 'not_found.title', 'not_found.message',
            'topbar.subtitle', 'topbar.controls',
            'breadcrumb.label', 'breadcrumb.home',
            'guide.reading_kicker', 'guide.reading_title', 'guide.sections',
            'theme.current', 'theme.night', 'theme.ocean', 'theme.paper', 'theme.short.night', 'theme.short.ocean', 'theme.short.paper',
            'search.kicker', 'search.title', 'search.intro', 'search.form_label', 'search.input_label', 'search.placeholder', 'search.placeholder_long', 'search.submit', 'search.help', 'search.results_kicker', 'search.results_title', 'search.results', 'search.empty_title', 'search.empty_body', 'search.tips_kicker', 'search.tips_title', 'search.type_guide', 'search.type_domain', 'search.type_symbol', 'search.symbols', 'search.methods', 'search.snippet_default',
            'assets.kicker', 'assets.title', 'assets.intro', 'assets.snapshot_state', 'assets.complete', 'assets.incomplete', 'assets.asset_count', 'assets.missing_refs', 'assets.unique_missing', 'assets.example_refs', 'assets.diagram_refs', 'assets.truth_source', 'assets.truth_suffix', 'assets.correction_rule', 'assets.create_examples', 'assets.create_diagrams', 'assets.no_placeholder', 'assets.rerun_smoke', 'assets.inventory_kicker', 'assets.inventory_title', 'assets.none_missing', 'assets.references', 'assets.first_usage', 'assets.useful_endpoints', 'assets.short_warning', 'assets.see_diagnostic', 'assets.type', 'assets.id', 'assets.top_limit',
            'runtime.kicker', 'runtime.title', 'runtime.source', 'runtime.opus_root', 'runtime.read_only', 'runtime.api', 'runtime.yes', 'runtime.no', 'runtime.endpoints_title', 'runtime.method', 'runtime.path', 'runtime.description', 'runtime.asset_warning_title', 'runtime.asset_warning_body',
            'diagram.aria', 'diagram.source', 'diagram.renderer_unavailable',
        ];

        $fallback = [];
        foreach ($paths as $path) {
            $this->setFallbackLabel($fallback, $path, '⚠[' . $path . ']');
        }

        return $fallback;
    }

    /**
     * @param array<string,mixed> $target
     */
    private function setFallbackLabel(array &$target, string $path, string $value): void
    {
        $cursor =& $target;
        foreach (explode('.', $path) as $segment) {
            if (!isset($cursor[$segment]) || !is_array($cursor[$segment])) {
                $cursor[$segment] = [];
            }
            $cursor =& $cursor[$segment];
        }
        $cursor = $value;
    }

PHP;

    $dotDocAnchor = "    /** @param array<string,mixed> \$data */\n    private function dot(array \$data, string \$path): mixed\n";
    if (strpos($content, $dotDocAnchor) !== false) {
        $content = str_replace($dotDocAnchor, $helper . "\n" . $dotDocAnchor, $content);
    } elseif (preg_match('/\n    private function dot\s*\(/', $content) === 1) {
        $content = preg_replace('/\n    private function dot\s*\(/', $helper . "\n    private function dot(", $content, 1) ?? $content;
    } elseif (preg_match('/\n}\s*$/', $content) === 1) {
        $content = preg_replace('/\n}\s*$/', $helper . "\n}\n", $content, 1) ?? $content;
    } else {
        fail('cannot insert fallback helper');
    }
}

/*
 * 2) Compact old fallback strings.
 */
$compact = [
    "'⚠ I18N_MISSING: ' . \$path" => "'⚠[' . \$path . ']'",
    "'⚠ I18N: ' . \$path" => "'⚠[' . \$path . ']'",
    "'⚠ I18N_MISSING: ' . \$key" => "'⚠[' . \$key . ']'",
    "'⚠ I18N: ' . \$key" => "'⚠[' . \$key . ']'",
];
$content = str_replace(array_keys($compact), array_values($compact), $content);
$content = str_replace('⚠ I18N_MISSING: ', '⚠[', $content);
$content = str_replace('⚠ I18N: ', '⚠[', $content);

/*
 * 3) labels() merge order.
 * Public fallback must never override real JSON translations.
 *
 * Correct order:
 *   publicUiLabels() = baseline + visible fallback
 *   $labels = JSON labels
 *   JSON labels win.
 */
$content = preg_replace(
    '~return\s+array_replace_recursive\(\$this->templateUiFallbackLabels\(\),\s*\$labels,\s*\$this->publicUiLabels\(\)\);~',
    'return array_replace_recursive($this->publicUiLabels(), $labels);',
    $content
) ?? $content;

$content = str_replace(
    'return array_replace_recursive($labels, $this->publicUiLabels());',
    'return array_replace_recursive($this->publicUiLabels(), $labels);',
    $content
);

$content = preg_replace(
    '~return\s+array_replace_recursive\(\$this->publicUiLabels\(\),\s*\$labels\);~',
    'return array_replace_recursive($this->publicUiLabels(), $labels);',
    $content,
    1
) ?? $content;

/*
 * 4) publicUiLabels() safe return.
 */
$content = str_replace(
    'return $labels[$this->language] ?? $labels[self::DEFAULT_LANGUAGE];',
    'return array_replace_recursive($this->templateUiFallbackLabels(), $labels[$this->language] ?? $labels[self::DEFAULT_LANGUAGE]);',
    $content
);

/*
 * 5) t() missing key compact marker.
 */
$content = str_replace(
    "return '[*' . \$key . '*]';",
    "return '⚠[' . \$key . ']';",
    $content
);

/*
 * 6) Register Czech full runtime labels if available.
 */
if (strpos($content, "'cs' => ['Jazyk'") !== false && strpos($content, "\$labels['cs'] = \$this->translatedPublicLabels('cs');") === false) {
    $safeReturn = 'return array_replace_recursive($this->templateUiFallbackLabels(), $labels[$this->language] ?? $labels[self::DEFAULT_LANGUAGE]);';
    if (strpos($content, $safeReturn) === false) {
        fail('safe publicUiLabels return anchor not found');
    }
    $content = str_replace(
        $safeReturn,
        "\$labels['cs'] = \$this->translatedPublicLabels('cs');\n\n        " . $safeReturn,
        $content
    );
}

/*
 * 7) If a previous Czech JSON-source guard exists, merge it over the full Czech map.
 */
$content = str_replace(
    '$labels[\'cs\'] = $csLabels;',
    '$labels[\'cs\'] = array_replace_recursive($labels[\'cs\'] ?? $this->translatedPublicLabels(\'cs\'), $csLabels);',
    $content
);

write_text($contentFile, $content);

/*
 * 8) Keep Czech sidebar basics.
 */
$csFile = $root . '/content/refbook/i18n/cs.json';
$cs = json_decode(read_text($csFile), true);
if (!is_array($cs)) {
    fail('cs.json invalid');
}
if (!isset($cs['labels']) || !is_array($cs['labels'])) {
    $cs['labels'] = [];
}
if (!isset($cs['labels']['language']) || !is_array($cs['labels']['language'])) {
    $cs['labels']['language'] = [];
}
if (!isset($cs['labels']['sidebar']) || !is_array($cs['labels']['sidebar'])) {
    $cs['labels']['sidebar'] = [];
}
$cs['labels']['language']['apply'] = 'Použít';
$cs['labels']['sidebar']['assets_docs'] = 'Dokumentační assets';
$cs['labels']['sidebar']['legal'] = 'Právní informace';
$cs['labels']['sidebar']['download_install'] = 'Stáhnout / nainstalovat';
write_text($csFile, json_encode($cs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");

/*
 * 9) CSS/JS visual presentation: red, compact, warning sign only.
 */
$cssFile = $root . '/public/assets/css/refbook-i18n-missing.css';
$css = is_file($cssFile) ? read_text($cssFile) : '';
if ($css === '') {
    $css = <<<'CSS'
.i18n-missing-visible {
  color: #fff !important;
  background: #b91c1c !important;
  border: 1px solid #ef4444 !important;
  border-radius: 999px !important;
  padding: .18rem .55rem !important;
  font-weight: 800 !important;
}
CSS;
}
$css = str_replace(['⛔', 'content: "⚠ ";', 'content:"⚠ ";'], ['', 'content: "";', 'content:"";'], $css);
if (strpos($css, 'P114C3AB') === false) {
    $css .= "\n/* P114C3AB — compact visible I18N fallback: ⚠[key]. */\n";
    $css .= ".i18n-missing-visible::before{content:\"\" !important;}\n";
}
write_text($cssFile, $css);

$jsFile = $root . '/public/assets/js/refbook-i18n-missing.js';
$js = is_file($jsFile) ? read_text($jsFile) : <<<'JS'
(() => {
  "use strict";
  const markers = ["⚠[", "I18N:", "I18N_MISSING"];
  function normalizeMissingText(text) {
    return text
      .replace(/⚠\s*I18N_MISSING:\s*([A-Za-z0-9_.-]+)/g, "⚠[$1]")
      .replace(/⚠\s*I18N:\s*([A-Za-z0-9_.-]+)/g, "⚠[$1]");
  }
  function scan(root) {
    const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);
    const targets = new Set();
    while (walker.nextNode()) {
      const node = walker.currentNode;
      if (!node.nodeValue || !markers.some((marker) => node.nodeValue.indexOf(marker) !== -1)) {
        continue;
      }
      const parent = node.parentElement;
      if (parent) {
        targets.add(parent);
      }
    }
    targets.forEach((element) => {
      element.textContent = normalizeMissingText(element.textContent);
      element.classList.add("i18n-missing-visible");
      element.setAttribute("data-i18n-missing", "true");
      element.setAttribute("title", element.textContent.trim());
    });
  }
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", () => scan(document.body));
  } else {
    scan(document.body);
  }
})();
JS;

$js = preg_replace('/const\s+marker\s*=\s*"I18N_MISSING";/', 'const markers = ["⚠[", "I18N:", "I18N_MISSING"];', $js) ?? $js;
$js = preg_replace('/const\s+markers\s*=\s*\[[^\]]*\];/', 'const markers = ["⚠[", "I18N:", "I18N_MISSING"];', $js) ?? $js;
$js = str_replace('node.nodeValue.indexOf(marker) === -1', '!markers.some((marker) => node.nodeValue.indexOf(marker) !== -1)', $js);
$js = str_replace('⛔', '⚠', $js);

if (strpos($js, 'function normalizeMissingText') === false) {
    $normalizer = <<<'JS'

  function normalizeMissingText(text) {
    return text
      .replace(/⚠\s*I18N_MISSING:\s*([A-Za-z0-9_.-]+)/g, "⚠[$1]")
      .replace(/⚠\s*I18N:\s*([A-Za-z0-9_.-]+)/g, "⚠[$1]");
  }

JS;
    $js = str_replace('  function markElement(element) {', $normalizer . '  function markElement(element) {', $js);
}

if (strpos($js, 'normalizeMissingText(element.textContent)') === false) {
    $js = str_replace(
        'element.classList.add("i18n-missing-visible");',
        'element.textContent = normalizeMissingText(element.textContent);' . "\n    " . 'element.classList.add("i18n-missing-visible");',
        $js
    );
}

if (strpos($js, 'P114C3AB_COMPACT_ALERT') === false) {
    $js = str_replace('"use strict";', "\"use strict\";\n  // P114C3AB_COMPACT_ALERT", $js);
}
write_text($jsFile, $js);

/*
 * 10) Layout cache keys and asset links.
 */
$layoutFile = $root . '/application/reference/templates/layout.twig';
$layout = read_text($layoutFile);

if (strpos($layout, 'refbook-i18n-missing.css') === false) {
    $link = '  <link rel="stylesheet" href="{{ basePath }}/assets/css/refbook-i18n-missing.css?v=P114C3AB">' . "\n";
    if (strpos($layout, '</head>') === false) {
        fail('layout head anchor not found');
    }
    $layout = str_replace('</head>', $link . '</head>', $layout);
}
if (strpos($layout, 'refbook-i18n-missing.js') === false) {
    $script = '  <script src="{{ basePath }}/assets/js/refbook-i18n-missing.js?v=P114C3AB" defer></script>' . "\n";
    if (strpos($layout, '</head>') === false) {
        fail('layout head anchor not found');
    }
    $layout = str_replace('</head>', $script . '</head>', $layout);
}
$layout = preg_replace('~refbook-i18n-missing\.css\?v=[A-Za-z0-9_\-]+~', 'refbook-i18n-missing.css?v=P114C3AB', $layout) ?? $layout;
$layout = preg_replace('~refbook-i18n-missing\.js\?v=[A-Za-z0-9_\-]+~', 'refbook-i18n-missing.js?v=P114C3AB', $layout) ?? $layout;
write_text($layoutFile, $layout);

echo "P114C3AB_APPLY_OK\n";
