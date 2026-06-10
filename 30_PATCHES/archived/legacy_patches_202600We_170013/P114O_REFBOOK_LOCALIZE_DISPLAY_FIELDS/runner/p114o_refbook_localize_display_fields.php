<?php
declare(strict_types=1);

$servicePath = 'H:\\ASAP_REF_BOOK\\application\\reference\\Service\\ReferenceCatalogService.php';

$source = file_get_contents($servicePath);
if (!is_string($source)) {
    fwrite(STDERR, "P114O_CATALOG_SERVICE_READ_FAILED\n");
    exit(1);
}

if (!str_contains($source, 'use ASAP\\RefBook\\I18n\\RefBookDocumentationI18nCatalog;')) {
    $source = str_replace(
        "namespace ASAPRefBook\\Reference\\Service;\n\n",
        "namespace ASAPRefBook\\Reference\\Service;\n\n"
        . "use ASAP\\RefBook\\I18n\\RefBookDocumentationI18nCatalog;\n"
        . "use ASAP\\RefBook\\I18n\\RefBookDocumentationLocale;\n\n",
        $source
    );
}

if (!str_contains($source, 'private ?RefBookDocumentationI18nCatalog $documentationI18nCatalog = null;')) {
    $source = str_replace(
        "    private readonly ReferenceApiCallService \$apiCallService;\n",
        "    private readonly ReferenceApiCallService \$apiCallService;\n"
        . "    private ?RefBookDocumentationI18nCatalog \$documentationI18nCatalog = null;\n",
        $source
    );
}

$oldCall = "            \$symbol['display_file'] = \$this->portablePath((string) (\$symbol['file'] ?? ''), (string) (\$manifest['runtime']['asap_root'] ?? ''));\n";
$newCall = $oldCall . "            \$symbol = \$this->localizeDisplayDocumentation(\$symbol);\n";

if (!str_contains($source, "\$symbol = \$this->localizeDisplayDocumentation(\$symbol);")) {
    if (!str_contains($source, $oldCall)) {
        fwrite(STDERR, "P114O_SYMBOLS_DISPLAY_FILE_NEEDLE_NOT_FOUND\n");
        exit(1);
    }
    $source = str_replace($oldCall, $newCall, $source);
}

if (!str_contains($source, 'private function localizeDisplayDocumentation(array $symbol): array')) {
    $methodBlock = <<<'PHP'

    /**
     * Localize only human-facing documentation fields shown by RefBook.
     *
     * Technical manifest fields such as schema, producer, source and PHP Reflection
     * are intentionally left untouched.
     *
     * @param array<string,mixed> $symbol
     * @return array<string,mixed>
     */
    private function localizeDisplayDocumentation(array $symbol): array
    {
        $language = $this->content?->language() ?? ReferenceContentService::DEFAULT_LANGUAGE;
        $language = RefBookDocumentationLocale::assertSupported($language);

        if ($language === 'en') {
            return $symbol;
        }

        foreach (['role', 'responsibility'] as $key) {
            if (isset($symbol[$key]) && is_string($symbol[$key]) && trim($symbol[$key]) !== '') {
                $symbol[$key] = $this->translateDocumentationText($symbol[$key], $language, 'symbol.' . $key);
            }
        }

        if (isset($symbol['contract']) && is_array($symbol['contract'])) {
            foreach ($symbol['contract'] as $index => $contract) {
                if (is_string($contract) && trim($contract) !== '') {
                    $symbol['contract'][$index] = $this->translateDocumentationText($contract, $language, 'symbol.contract.' . (string) $index);
                }
            }
        }

        if (isset($symbol['methods']) && is_array($symbol['methods'])) {
            foreach ($symbol['methods'] as $methodIndex => $method) {
                if (!is_array($method)) {
                    continue;
                }

                foreach (['role', 'behavior'] as $key) {
                    if (isset($method[$key]) && is_string($method[$key]) && trim($method[$key]) !== '') {
                        $method[$key] = $this->translateDocumentationText($method[$key], $language, 'symbol.methods.' . (string) $methodIndex . '.' . $key);
                    }
                }

                foreach (['preconditions', 'postconditions', 'side_effects'] as $listKey) {
                    if (!isset($method[$listKey]) || !is_array($method[$listKey])) {
                        continue;
                    }

                    foreach ($method[$listKey] as $itemIndex => $item) {
                        if (is_string($item) && trim($item) !== '') {
                            $method[$listKey][$itemIndex] = $this->translateDocumentationText($item, $language, 'symbol.methods.' . (string) $methodIndex . '.' . $listKey . '.' . (string) $itemIndex);
                        }
                    }
                }

                $symbol['methods'][$methodIndex] = $method;
            }
        }

        return $symbol;
    }

    private function translateDocumentationText(string $source, string $language, string $path): string
    {
        return $this->documentationI18nCatalog()->translateSourceText($source, $language, $path);
    }

    private function documentationI18nCatalog(): RefBookDocumentationI18nCatalog
    {
        if ($this->documentationI18nCatalog === null) {
            $this->documentationI18nCatalog = new RefBookDocumentationI18nCatalog();
        }

        return $this->documentationI18nCatalog;
    }
PHP;

    $needle = "    /**\n     * @return list<array<string,mixed>>\n     */\n    private function listOfArrays(mixed \$value): array\n";
    if (!str_contains($source, $needle)) {
        fwrite(STDERR, "P114O_LIST_OF_ARRAYS_NEEDLE_NOT_FOUND\n");
        exit(1);
    }
    $source = str_replace($needle, $methodBlock . "\n\n" . $needle, $source);
}

$required = [
    'use ASAP\\RefBook\\I18n\\RefBookDocumentationI18nCatalog;',
    'use ASAP\\RefBook\\I18n\\RefBookDocumentationLocale;',
    'private ?RefBookDocumentationI18nCatalog $documentationI18nCatalog = null;',
    '$symbol = $this->localizeDisplayDocumentation($symbol);',
    'private function localizeDisplayDocumentation(array $symbol): array',
    'private function translateDocumentationText(string $source, string $language, string $path): string',
    'private function documentationI18nCatalog(): RefBookDocumentationI18nCatalog',
];

foreach ($required as $needle) {
    if (!str_contains($source, $needle)) {
        fwrite(STDERR, "P114O_REQUIRED_NEEDLE_MISSING=" . $needle . "\n");
        exit(1);
    }
}

if (file_put_contents($servicePath, $source) === false) {
    fwrite(STDERR, "P114O_CATALOG_SERVICE_WRITE_FAILED\n");
    exit(1);
}

echo "P114O_PATCH_SOURCE_UPDATE_OK\n";
