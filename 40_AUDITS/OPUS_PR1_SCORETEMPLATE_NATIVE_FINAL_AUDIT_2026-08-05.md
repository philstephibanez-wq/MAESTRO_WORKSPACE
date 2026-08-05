# OPUS PR #1 — ScoreTemplate native final contract audit

Date: 2026-08-05
Repository: `philstephibanez-wq/OPUS`
Pull request: `#1 P116B ScoreTemplate native final contract`

## Decision

Do not merge PR #1 into the current `master` branch.

The pull request is an obsolete historical implementation based on the former `framework/Opus/Template` tree. The current repository has diverged by more than one thousand commits and now owns the native renderer under `Opus/Score`, with a homonymous interface, profiler integration, I18n integration, structured nested parsing, include-cycle detection and stricter path containment.

PR #1 remains useful only as a source of historical contract requirements and test cases.

## Current pull request state

- Open, not draft, not merged and currently non-mergeable.
- Head: `p116b-scoretemplate-final` at `5b385a6796735ab1fda6f03efbcc241084474346`.
- Six commits, twelve changed files, 627 additions and 545 deletions.
- No submitted review and no review thread.
- The only conversation comment reports that the Codex review was not executed because usage limits were reached.
- No pull-request workflow run was found for the head commit.
- The branch and current `master` are diverged: current `master` is 1256 commits ahead while the PR contains six branch-only commits.

## Contract implemented by the historical branch

The branch introduced:

- escaped and explicit raw interpolation;
- controlled `.score` includes;
- simple `if/else` blocks;
- simple `foreach` blocks with key/value support;
- `loop.index`, `loop.index0`, `loop.first`, `loop.last` and `loop.length`;
- whitelisted `upper`, `lower`, `trim`, `default` and `date` filters;
- explicit failures for missing data, unknown directives, forbidden paths and PHP tags;
- a focused historical smoke and a historical template recipe.

## Blocking incompatibilities

1. The implementation targets obsolete paths under `framework/Opus/Template`; the current source tree uses `Opus/Score`.
2. The historical concrete renderer implements only the generic `TemplateRendererInterface`; the current framework contract requires the homonymous `ScoreTemplateRendererInterface` extending the four standard OPUS marker interfaces.
3. The historical recipe requires legacy adapters to be absent. Adapter removal must never be used as proof of complete migration; all consuming applications must first be inventoried and confirmed migrated to `.score`.
4. The historical documentation patch replaces broad repository history in `CHANGELOG.md`, `PATCH.md` and `TODO.md`, creating unacceptable documentation regression risk.
5. The historical smoke and recipe paths no longer exist in the current repository layout.
6. No current CI or full-recipe evidence exists for the PR head.

## Current master assessment

The current native renderer already supersedes most P116B behavior:

- homonymous OPUS contract interface;
- nested structured parser;
- escaped and raw interpolation;
- include, condition and loop nodes;
- loop metadata;
- whitelisted filters, including `length`;
- I18n directives;
- profiler span and event emission;
- include-cycle detection;
- real-path root containment.

One explicit historical safeguard still requires reconciliation: the current renderer audit did not find a direct PHP-tag rejection before template parsing. This must be covered by a focused current-master contract test and, if confirmed, corrected in the current `Opus/Score/ScoreTemplateRenderer.php` implementation rather than by rebasing PR #1.

## Remaining work for the final native SCORE contract

1. Treat current `master` as the only implementation baseline.
2. Create a current-path SCORE contract smoke outside the differential delivery ZIP.
3. Verify and enforce explicit rejection of PHP opening and closing tags in `.score` sources.
4. Add regression cases for nested blocks, malformed terminators, include cycles, path traversal, symlink escape, missing values, escaping/raw output, filter arguments, loop metadata, I18n and profiler events.
5. Validate `ScoreTemplateRendererInterface` and the four OPUS marker interfaces in the repository-wide interface recipe.
6. Inventory all consuming applications before declaring Twig, Smarty or any migration bridge removable.
7. Append contract documentation without replacing repository history.
8. Run targeted validation, global interface validation and the full OPUS recipe with no regression.
9. Deliver only a differential ZIP; keep tests and workspace documents outside the ZIP.
10. Let the owner apply, test, commit and push OPUS. Update `MAESTRO_WORKSPACE` directly with the resulting handoff and remaining work.

## Next-action checklist

- [ ] Keep PR #1 unmerged; preserve it only as historical reference.
- [ ] Diff its unique safeguards against current `Opus/Score/ScoreTemplateRenderer.php`.
- [ ] Confirm the PHP-tag rejection gap with a current-master smoke.
- [ ] Correct only confirmed gaps in the current architecture.
- [ ] Validate interfaces, SCORE behavior, profiler integration and full recipe.
- [ ] Produce the next differential ZIP only after the current active R45B2A4 validation state is reconciled.
