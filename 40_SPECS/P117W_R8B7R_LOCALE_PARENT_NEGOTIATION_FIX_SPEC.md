# P117W R8B7R — Locale parent negotiation fix

Date: 2026-09-04
Status: READY FOR OWNER VALIDATION

## Baseline

OPUS master: `a6c9acf3cbfd1a32f4aa5ebd96b2a4666b46850a` (`R8B7Q`).

## Runtime evidence

Fresh OWASYS traces supplied by the owner show:

- `owasys-back`: 430 profiler traces, zero failed traces;
- `owasys-front`: 76 profiler traces, 23 failed traces;
- all 23 failed front traces are `GET /favicon.ico` and fail with `OWASYS_FRONT_RUNTIME_FAILED`;
- front log identifies `Opus\\I18n\\BrowserLocaleNegotiator.php` line 74 as the exception origin.

## Cause

`BrowserLocaleNegotiator::match()` walks locale parents with `Locale::parent()`, but `Opus\\I18n\\Locale` does not implement `parent()` and `LocaleInterface` does not contract it.

The favicon request is only the reproducer: the defect is generic locale-parent negotiation for browser-driven requests without an explicit route locale.

## Required correction

1. Add `Locale::parent(): ?Locale`.
2. Add the same method to `LocaleInterface`.
3. Parent semantics are BCP-47 truncation by rightmost subtag:
   - `zh-Hant-TW` -> `zh-Hant` -> `zh` -> `null`;
   - `fr-FR` -> `fr` -> `null`;
   - language-only locale -> `null`.
4. Do not special-case `/favicon.ico`.
5. Do not change routing, SCORE, EFSM, REST, ACL, OWASYS application code or translation catalogs in this slice.

## Differential

- `Opus/I18n/Locale.php`
- `Opus/I18n/LocaleInterface.php`

## Acceptance

- PHP syntax valid for both files;
- Composer autoload regenerated successfully;
- `composer opus:validate-site -- owasys-front` succeeds;
- `composer opus:validate-site -- owasys-back` succeeds;
- browser request to `/favicon.ico` no longer produces a 500 / `OWASYS_FRONT_RUNTIME_FAILED` from locale negotiation;
- normal localized OWASYS pages remain functional;
- no new failed back trace;
- no unrelated OPUS/OWASYS source changes.

Translation-key warnings visible in the supplied front log are intentionally out of scope for R8B7R and remain a later catalog-completeness cleanup, because they are warnings and not the cause of the observed runtime failures.
