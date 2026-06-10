<?php

declare(strict_types=1);

namespace ASAP\RefBook\I18n;

use InvalidArgumentException;

/**
 * PUBLIC RefBook documentation locale contract.
 *
 * Role:
 *   Own the strict list of languages supported by ASAP documentation APIs.
 *
 * Contract:
 *   - language is explicit in REST URLs and provider calls;
 *   - unsupported languages fail explicitly;
 *   - no silent fallback to English is allowed.
 */
final class RefBookDocumentationLocale
{
    public const DEFAULT = 'en';

    /** @return list<string> */
    public static function supported(): array
    {
        return ['fr', 'en', 'es', 'de', 'uk', 'it', 'pl', 'cs'];
    }

    public static function assertSupported(string $language): string
    {
        $language = strtolower(trim($language));

        if (!in_array($language, self::supported(), true)) {
            throw new InvalidArgumentException('ASAP_REFBOOK_DOC_LANG_UNSUPPORTED: ' . $language);
        }

        return $language;
    }
}
