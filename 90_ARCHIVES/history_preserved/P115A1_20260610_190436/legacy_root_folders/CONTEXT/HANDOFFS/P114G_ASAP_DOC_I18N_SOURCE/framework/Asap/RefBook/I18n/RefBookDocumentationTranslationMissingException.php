<?php

declare(strict_types=1);

namespace ASAP\RefBook\I18n;

use RuntimeException;

/**
 * PUBLIC missing translation error.
 *
 * Role:
 *   Stop localized documentation export when an ASAP source text is not translated.
 *
 * Contract:
 *   - missing translations are explicit;
 *   - the source path and source text are preserved for recipes;
 *   - no English fallback is returned for non-English documentation.
 */
final class RefBookDocumentationTranslationMissingException extends RuntimeException
{
    public static function forSourceText(string $language, string $path, string $sourceText): self
    {
        return new self(
            'ASAP_REFBOOK_DOC_TRANSLATION_MISSING'
            . ' lang=' . $language
            . ' path=' . $path
            . ' source=' . $sourceText
        );
    }
}
