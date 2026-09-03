# R8B7H — View-switch performance / exact source stat

## Baseline

OPUS/OWASYS baseline re-gated by owner on 2026-09-02: local `HEAD` and `origin/master` were both `f17c063671ff3387645b32d0149d84d4741d7cc8` (R8B7G), with a clean worktree and no untracked files.

## Evidence

Fresh front/back profiler captures supplied 2026-09-02 showed multi-second OWASYS front view changes while SCORE rendering itself consumed only milliseconds. A representative contextual EFSM view performed several serial REST calls, including a complete `source.list` solely to decide whether one exact locale catalog existed.

`OwasysFsmDiagramBuilder::applicationCatalogMessages()` called `OwasysSourceModel::list($applicationId, $identity)` to determine whether `application/default/local/<locale>.json` existed, then separately called `read()` for that exact file. The recursive source enumeration was therefore an avoidable dominant cost on ordinary view switches.

## Contract

1. NO FALLBACK remains absolute for contextual EFSM labels.
2. Do not cache or infer a different locale, source or application.
3. Do not restore parent-language or host-source substitution.
4. Replace full source enumeration for catalog existence by a secured exact-resource stat/probe contract.
5. Prefer a generic OPUS source-workspace capability when absent and expose it through OWASYS back REST.
6. Exact stat distinguishes an existing file from an absent file; malformed, forbidden or server-invalid requests remain errors.
7. Absence of the exact locale catalog must not become HTTP 500; it yields no catalog messages and therefore preserves the visible missing-translation marker.
8. `FsmDiagramBuilder` must perform at most exact stat plus exact read for the active locale catalog and must never use `source.list` for contextual label lookup.
9. Source-browser listing remains unchanged where a full list is actually requested.
10. Preserve ACL, SSO, HMAC/request signing, logger/profiler correlation, application ownership, exact path validation and REST semantics.
11. No FSM definition, persisted layout geometry or SCORE rendering change.

## Delivered implementation

The actual owner-applied implementation uses the existing generic `Opus\Application\Source\SiteSourceWorkspace` rather than introducing a separate probe component:

- `SiteSourceWorkspaceInterface::stat(string $siteId, string $relativePath)`;
- `SiteSourceWorkspace::stat()` with observation name `stat` and contract `OPUS_SITE_SOURCE_STAT_V1`;
- owasys-back command `owasys:source:stat` exposed as Composer alias `owasys:source-stat`;
- secured REST operation `source.stat`;
- secured resource `GET /api/v1/applications/{site_id}/source-stats/{*path}`;
- owasys-front `OwasysSourceModel::stat()`;
- `FsmDiagramBuilder::applicationCatalogMessages()` exact `stat()` followed by `read()` only when `exists=true`.

The source ACL action remains `read`. The source browser, EFSM definitions, layouts and SCORE rendering remain unchanged.

## Static owner evidence

Owner evidence supplied 2026-09-03:

- all five changed PHP files passed `php -l`;
- `composer validate --no-check-publish` returned valid, with only the existing package-version warning;
- `git diff --check` was clean;
- Composer optimized autoload regenerated successfully with 561 classes.

A direct `composer owasys:source-stat -- ...` test was invalid by design because application source commands require the secured `OPUS_REST_API_COMPOSER_COMMAND_REQUEST_V1` REST envelope. This CLI failure is not evidence of a `source.stat` implementation failure.

## Runtime incident found during acceptance

Fresh front/back logs supplied after the first runtime attempt showed:

- front `request.failed` with `OPUS_REST_API_CATALOG_MISMATCH`;
- back `source.read` rejected with the same mismatch;
- front visible UI consequently lost translated menu/EFSM labels and showed missing-translation markers;
- the server startup logs confirmed canonical ports: `owasys-front` on `127.0.0.1:8000` and `owasys-back` on `127.0.0.1:8080`.

Root cause: R8B7H updated `sites/owasys-back/config/backend.resources.json` and the inline resources in `backend.rest.json`, but the client fingerprint catalog `sites/owasys-front/config/rest.resources.json` was initially omitted. Because OPUS REST intentionally fingerprints the complete resource catalog, any request, including an otherwise unchanged `source.read`, was rejected when front and back fingerprints diverged.

The corrective differential adds the same `source.stat` resource to `sites/owasys-front/config/rest.resources.json`. This is a required part of the final R8B7H resource-catalog change set, not an I18n change.

## Acceptance still required

Final R8B7H runtime acceptance requires:

- front and back resource catalogs have identical fingerprints;
- ordinary contextual EFSM view switches no longer contain `source.list` caused by `applicationCatalogMessages()`;
- existing exact catalog: `source.stat` then exact `source.read`, with correct translated labels;
- missing exact catalog: `exists=false`, no fallback, no 500 and visible `⚠ <id>` markers;
- no cross-application source substitution;
- SCORE rendering unchanged;
- fresh profiler comparison demonstrates material latency reduction.

## Follow-up R8B7I

The incident exposed a systemic validation gap: local `opus:validate-site` can currently succeed while REST peers carry different resource-catalog fingerprints. R8B7I must add a generic pre-runtime parity gate for locally available REST peers declared through the site `exchange` contract, so a catalog drift is rejected during validation rather than during the first business request.
