# MAESTRO_WORKSPACE HANDOFF — OWASYS P117Q

Date: 2026-07-23
Status: differential ZIP prepared; PHP/JSON/static validation complete; Windows browser validation pending
Source OPUS head: `f336347e83d3f3610396dc527891496ca6d4d32f` (`p117o`)

## Scope

P117Q continues the OWASYS `registry` / Applications state and supersedes the uncommitted P117P delivery.

The ZIP is cumulative for:

- P117O-R1 synchronized horizontal-menu and Mermaid-FSM navigation;
- P117P OWASYS Singleton composition root and application Singleton inspection;
- P117Q canonical application discovery, duplicate diagnostics, current-context reconciliation and restored Applications-tree styling.

## Observed target-state defects

The target browser showed:

- current application root `sites/owasys_old`;
- Singleton result `0` compliant / `1` non-compliant;
- one compressed application row because the `.ow-app-tree` / `.ow-tree-*` stylesheet rules were absent from the cumulative P117P ZIP.

The Registry discovery implementation scanned `sites/*/config/site.json` and upserted each discovered site immediately. Duplicate `site_id` values were therefore resolved implicitly by filesystem iteration order. A later directory such as `sites/owasys_old` could overwrite the canonical `sites/owasys` record.

This violated the MAESTRO zero-silent-fallback rule and made the Singleton audit inspect the wrong application root.

## Canonical discovery contract

P117Q groups discovered applications by `site_id` before writing SQLite.

Canonical selection is explicit:

1. `sites/<site_id>` wins when exactly present;
2. a single non-standard root is accepted when it is the only candidate;
3. multiple candidates without an exact directory-name match are ambiguous and are not silently imported.

Every rejected root is returned as a discovery conflict. The page displays:

- discovered candidates;
- canonical applications imported;
- duplicate identifiers;
- ignored roots;
- canonical root and rejected roots for each conflict.

For the target case, `sites/owasys` is canonical and `sites/owasys_old` is reported as rejected.

## Current application reconciliation

The authenticated session stores an application snapshot. After Registry synchronization, P117Q reconciles that snapshot against the canonical Registry entry.

If the identifier still exists, the session receives the canonical current entry. If the identifier no longer exists, the current application context is cleared. No new `select_app` event is recorded for this technical reconciliation.

This corrects the header and Applications-state context from `sites/owasys_old` to `sites/owasys`.

## Singleton status

OWASYS keeps the P117P application composition root:

`OwasysApplication::instance($siteRoot, $siteConfig)->run()`.

The canonical `sites/owasys` entry is inspected against `OPUS_APPLICATION_SINGLETON_V1`. Legacy or copied roots remain visible as discovery conflicts rather than replacing the canonical application.

The Singleton contract applies to each autonomous OPUS application's composition root. It does not require every controller, model or value object to be a Singleton.

## Applications presentation

The missing `sites/owasys/www/asset/css/owasys.css` tree rules are restored in the cumulative ZIP.

The Applications state now renders:

- canonical context panel;
- discovery-integrity panel;
- Singleton-compliance panel;
- readable tree/card application selector;
- SQLite Registry statistics;
- recent Registry events.

The current application card keeps full opacity while disabled and is clearly marked as current.

## Runtime contracts

The request pipeline remains:

request -> browser/regional locale -> SSO -> deny-by-default ACL -> FSM transition/guards -> ViewModel -> SCORE.

The page remains SCORE-only. No PHP/HTML mixed view, UI-producing `echo`, client router or alternative Registry is introduced.

Registry seed/site/config files are read through `Opus\File\File` and `Opus\File\StructuredFileLoader`; JSON/YAML/XML parser selection remains extension-driven.

## Framework contract

P117Q does not add or modify a concrete OPUS framework class. The P117M-R1 homonymous-interface and four-marker audit remains mandatory.

## Delivery

ZIP: `opus_owasys_p117q_registry_integrity.zip`

SHA-256: `2da8d42b0d39059a6dad2618572469d719b31a8d48fc411a4b4e20c1a8b23875`

Files: 44

No direct write was made to the OPUS repository.

## Validation completed

- PHP syntax validation for all PHP files in the differential;
- JSON parsing for all 27 JSON files in the differential;
- Registry i18n key parity across the 25 base catalogs;
- actual PHP reflection test of canonical selection:
  - `sites/owasys` selected over `sites/owasys_old`;
  - ambiguous duplicate roots produce `OWASYS_REGISTRY_DISCOVERY_DUPLICATE_AMBIGUOUS` and no implicit canonical fallback;
- static verification of current-context reconciliation;
- static verification of restored tree/discovery CSS;
- ZIP integrity validation.

The artifact-generation container did not provide the PHP SQLite3 extension, so the complete live Registry audit must run on the target Windows OPUS installation. Browser rendering, SSO session state and the target SQLite database were not executed here.

## Commit gate

Do not commit OPUS until the target audit and browser validation confirm:

- canonical root `sites/owasys`;
- OWASYS Singleton compliant;
- duplicate `sites/owasys_old` reported but not selected;
- readable Applications cards;
- menu and Mermaid-FSM navigation still synchronized.
