# Decision 2026-06-28 — OPUS ScoreTemplate Ownership

Status: Accepted.

ScoreTemplate and `.score` belong to OPUS.

Do not describe ScoreTemplate as an ASAP component in the current architecture.

Historical documents that mention `ASAP ScoreTemplate Engine` or `ASAP\View\ScoreTemplate` are obsolete for the OPUS line.

Correct ownership:

- Product/framework owner: OPUS.
- Runtime/template responsibility: OPUS view layer.
- Template extension: `.score`.
- ASAP role: historical reference only, not the owner of ScoreTemplate.

Future work must use OPUS naming and OPUS namespace conventions.
