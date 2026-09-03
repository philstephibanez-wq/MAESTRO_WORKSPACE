# P117W R8B7O — I18N TRACE + APPLICATION TOPOLOGY HANDOFF

Status: READY FOR OWNER PREFLIGHT / APPLY

## Authority

- OPUS baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` are authoritative.
- R8B7O supersedes R8B7N and all earlier uncommitted Applications presentation candidates.

## Fresh evidence

The owner screenshots show anonymous `⚠` placeholders on Applications, Data sources and Navigation. Fresh front logs contain no dedicated missing-I18n event for those successful page requests, and fresh Profiler JSONL contains no corresponding I18n warning event. The existing OWASYS-local translation runtime is the cause: it catches `OPUS_I18N_MESSAGE_MISSING` and returns only `⚠`.

## Delivery

Native ZIP: `R8B7O.zip`

SHA-256:
`de0d82d4c988ac126ddcc1c2152bec65ec436ee43df2710c5bd05e9311126293`

Complete files in ZIP:

1. `Opus/I18n/ApplicationTranslationRuntime.php`
2. `sites/owasys-front/application/default/bootstrap.php`
3. `sites/owasys-front/application/registry/templates/index.score`
4. `sites/owasys-front/www/asset/themes/owasys/css/theme.css`

Required tracked deletion after extraction:

`sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`

## Target result

- one framework I18n runtime authority; OWASYS local shadow removed;
- missing message renders `⚠ <exact.i18n.key>`;
- same missing key is duplicated to `owasys-front.log` with `channel=opus.i18n`, `message=message.missing`, exact `i18n_key`, locale, module and current trace ID;
- same trace receives OPUS Profiler `category=i18n`, `name=message.missing`, `status=warning`;
- OWASYS core front/back side-by-side on desktop;
- generated applications below in a distinct connected group;
- diagnostic clutter removed from the primary Applications workspace;
- no REST/back/FSM/ACL change.

## Pre-delivery verification

- framework runtime baseline reconstructed and matched Git blob `61fb1682731331f2dffbe82451ae5c2162828771`;
- OWASYS bootstrap baseline reconstructed and matched Git blob `050f76893890cd642dc060bc4ff11c740bb6f552`;
- both modified PHP files lint successfully in build environment;
- SCORE structure balanced: 21/21 if, 2/2 foreach;
- archive contains exactly four final files;
- archive read-back and integrity test pass;
- final SHA-256 verified.

## Stepwise owner workflow

Gate 1 is preflight and archive verification. The owner may still have an earlier presentation candidate applied locally. Any unexpected HEAD or dirty path outside the known I18n/presentation candidate paths is a stop condition.

Expected baseline HEAD: `ec3586496acdac83f155a248c46013e3001cbef4`.

After Gate 1 is accepted, Gate 2 applies the ZIP, removes the obsolete tracked local runtime with `git rm`, runs PHP lint, `git diff --check`, site validation, status and diff inspection. Runtime verification comes only after these checks pass.

Runtime acceptance requires one real missing key to appear simultaneously as:

- `⚠ <exact key>` in UI;
- `opus.i18n / message.missing` in `owasys-front.log` with the exact key and trace ID;
- `i18n / message.missing` warning in the OPUS Profiler under the same trace ID.

No commit/push before runtime acceptance.
