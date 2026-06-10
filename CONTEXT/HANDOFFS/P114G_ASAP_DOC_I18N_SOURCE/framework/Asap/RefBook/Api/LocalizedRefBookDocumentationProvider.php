<?php

declare(strict_types=1);

namespace ASAP\RefBook\Api;

use ASAP\RefBook\I18n\RefBookDocumentationI18nCatalog;
use ASAP\RefBook\I18n\RefBookDocumentationLocale;

/**
 * PUBLIC localized RefBook documentation provider.
 *
 * Role:
 *   Localize reflection documentation snapshots before they are exposed through
 *   REST or consumed by ASAP_REF_BOOK.
 *
 * Contract:
 *   - language is explicit;
 *   - technical reflection data is preserved;
 *   - source documentation values are translated by ASAP, not by RefBook;
 *   - missing translations fail explicitly.
 */
final class LocalizedRefBookDocumentationProvider
{
    private const TRANSLATABLE_KEYS = [
        'role' => true,
        'responsibility' => true,
        'contract' => true,
        'contracts' => true,
        'behavior' => true,
        'preconditions' => true,
        'postconditions' => true,
        'side_effects' => true,
    ];

    public function __construct(private readonly RefBookDocumentationI18nCatalog $catalog)
    {
    }

    /**
     * @param array<string,mixed> $snapshot
     * @return array<string,mixed>
     */
    public function localizeSnapshot(array $snapshot, string $language): array
    {
        $language = RefBookDocumentationLocale::assertSupported($language);
        $localized = $this->localizeValue($snapshot, $language, 'snapshot', false);

        if (!is_array($localized)) {
            throw new \RuntimeException('ASAP_REFBOOK_DOC_LOCALIZED_SNAPSHOT_INVALID');
        }

        $localized['language'] = $language;
        $localized['supported_languages'] = RefBookDocumentationLocale::supported();

        return $localized;
    }

    /**
     * @param array<string,mixed> $symbol
     * @return array<string,mixed>
     */
    public function localizeSymbol(array $symbol, string $language): array
    {
        $language = RefBookDocumentationLocale::assertSupported($language);
        $localized = $this->localizeValue($symbol, $language, 'symbol', false);

        if (!is_array($localized)) {
            throw new \RuntimeException('ASAP_REFBOOK_DOC_LOCALIZED_SYMBOL_INVALID');
        }

        return $localized;
    }

    private function localizeValue(mixed $value, string $language, string $path, bool $translatable): mixed
    {
        if (is_string($value)) {
            if (!$translatable || $this->isTechnicalLiteral($value)) {
                return $value;
            }

            return $this->catalog->translateSourceText($value, $language, $path);
        }

        if (!is_array($value)) {
            return $value;
        }

        $out = [];
        foreach ($value as $key => $child) {
            $keyString = (string) $key;
            $childTranslatable = $translatable || isset(self::TRANSLATABLE_KEYS[$keyString]);
            $out[$key] = $this->localizeValue($child, $language, $path . '.' . $keyString, $childTranslatable);
        }

        return $out;
    }

    private function isTechnicalLiteral(string $value): bool
    {
        $trimmed = trim($value);

        if ($trimmed === '' || $trimmed === 'public-api' || $trimmed === 'internal' || $trimmed === 'private') {
            return true;
        }

        if (preg_match('/^[A-Z0-9_]+$/', $trimmed) === 1) {
            return true;
        }

        if (preg_match('/^[A-Za-z0-9_.-]+$/', $trimmed) === 1 && !str_contains($trimmed, ' ')) {
            return true;
        }

        if (preg_match('/^[A-Za-z0-9_\\\\]+(::[A-Za-z0-9_]+)?$/', $trimmed) === 1) {
            return true;
        }

        if (str_starts_with($trimmed, 'tests/') || str_starts_with($trimmed, 'DOC/')) {
            return true;
        }

        return false;
    }
}
