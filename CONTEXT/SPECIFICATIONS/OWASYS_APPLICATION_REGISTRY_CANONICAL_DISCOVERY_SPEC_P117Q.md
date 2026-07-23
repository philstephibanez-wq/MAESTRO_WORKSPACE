# OWASYS P117Q — CANONICAL APPLICATION REGISTRY DISCOVERY SPECIFICATION

## 1. Purpose

This specification defines deterministic discovery and presentation rules for the OWASYS Applications state.

The Registry must never let filesystem iteration order decide which autonomous OPUS application owns a `site_id`.

## 2. Source applications

Discovery candidates are autonomous sites matching:

`OPUS/sites/*/config/site.json`

Accepted site contracts remain:

- `OPUS_SITE_APPLICATION_TREE_V2`;
- `OPUS_SITE_APPLICATION_TREE_V1_ETERNAL`.

Each configuration file is read through `Opus\File\File` and parsed through `Opus\File\StructuredFileLoader` using its selected JSON, YAML/YML or XML parser.

## 3. Candidate grouping

Candidates are grouped by canonical `site_id` before any SQLite upsert.

The Registry must preserve:

- candidate root;
- site identifier;
- site metadata;
- discovery conflict information.

Direct per-file last-write-wins upserts are forbidden.

## 4. Canonical-root selection

For one `site_id`, apply exactly this order:

1. when exactly one candidate root is `sites/<site_id>`, select it;
2. when exactly one candidate exists, select it;
3. when several candidates exist and none exactly matches `sites/<site_id>`, select none and report `OWASYS_REGISTRY_DISCOVERY_DUPLICATE_AMBIGUOUS`.

No alphabetical, timestamp, newest-file, modified-file or filesystem-order fallback is permitted.

## 5. Duplicate diagnostics

A discovery conflict contains:

- `id`;
- `canonical_root` or an empty value when unresolved;
- `rejected_roots`;
- `resolved`;
- `error`.

The synchronization result contains:

- `discovered_candidates`;
- `discovered_imported`;
- `duplicate_ids`;
- `duplicate_roots`;
- `discovery_conflicts`.

Duplicate roots are diagnostics, not additional selectable applications.

## 6. Target OWASYS case

When both roots exist:

- `sites/owasys`;
- `sites/owasys_old`;

and both declare `site_id=owasys`, the canonical root is `sites/owasys` and the `_old` root is reported as rejected.

The copied root must not overwrite the canonical SQLite row and must not be used by the Singleton inspector.

## 7. Seed contract

The OWASYS Registry seed must define:

- `id`: `owasys`;
- `root_path`: `sites/owasys`;
- `default_locale`: `fr-FR`;
- `role`: `standard-opus-application`.

The seed is imported before canonical discovery. Canonical discovery may refresh metadata for the same identifier but may not replace it with a rejected duplicate root.

## 8. Current-context reconciliation

The SSO session stores a current-application snapshot.

After synchronization of the Applications state:

- resolve the snapshot identifier against the canonical Registry entries;
- replace the session snapshot with the canonical entry when found;
- clear the session context when the identifier no longer exists;
- do not create a user `select_app` event for technical reconciliation.

FSM `has_current_app` must use the reconciled context.

## 9. Singleton inspection

Each canonical Registry entry is inspected against `OPUS_APPLICATION_SINGLETON_V1`.

Minimum composition-root requirements:

- declared runtime architecture `singleton`;
- declared application class and source file;
- declared public entrypoint;
- private constructor;
- static instance slot;
- `instance()` factory;
- `run()` entry method;
- front controller delegates to `Class::instance(...)->run()`.

The contract applies to the autonomous application's composition root, not every internal object.

## 10. Applications ViewModel

The Registry ViewModel exposes:

- canonical application entries;
- current application;
- Singleton result per entry;
- discovery metrics;
- duplicate conflicts;
- recent events;
- SQLite synchronization metrics.

Business/config data must not be loaded by SCORE templates.

## 11. SCORE presentation

The Applications state contains five functional blocks:

1. current application context;
2. discovery integrity;
3. Singleton compliance;
4. canonical application selector;
5. Registry runtime/events.

Application cards must present fields on distinct readable lines:

- name and status;
- kind and role;
- root;
- locale and theme;
- Singleton result;
- current/select action.

The current application's disabled selector must remain fully legible.

## 12. I18n

All visible discovery labels must exist in each of the 25 base-language Registry catalogs. Regional catalogs continue to inherit their base-language catalog explicitly.

No key-name fallback and no silent English fallback are allowed.

Required discovery keys:

- `registry.discovery.title`;
- `registry.discovery.description`;
- `registry.discovery.candidates`;
- `registry.discovery.canonical`;
- `registry.discovery.duplicate_ids`;
- `registry.discovery.ignored_roots`;
- `registry.discovery.clean`;
- `registry.discovery.conflict`;
- `registry.discovery.canonical_root`;
- `registry.discovery.rejected_roots`.

## 13. FSM, ACL and SSO

The authoritative pipeline remains:

request
-> browser/regional locale
-> SSO identity
-> ACL deny-by-default
-> route signal
-> FSM transition and guards
-> ViewModel
-> SCORE.

Discovery diagnostics do not bypass authentication, authorization, current-application guards or FSM transitions.

Auth0 proxy and bastion implementations remain SSO-provider work and must remain behind the OPUS SSO boundary.

## 14. OPUS component contract

P117Q does not introduce a concrete framework class.

Every future concrete OPUS framework class must implement its homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The exhaustive P117M-R1 audit remains a release gate.

## 15. Acceptance criteria

On the target Windows installation:

- `sites/owasys` is the Registry root for `owasys`;
- `sites/owasys_old` is shown as rejected when it exists;
- OWASYS is Singleton compliant;
- current context is reconciled to `sites/owasys`;
- application cards are readable and not compressed into one line;
- all base Registry catalogs contain discovery keys;
- menu and Mermaid-FSM navigation remain synchronized;
- PHP lint passes;
- Registry audit passes;
- P117M-R1 audit passes;
- `git diff --check` passes;
- browser console contains no navigation/Mermaid errors.

No OPUS commit is authorized before these acceptance checks.
