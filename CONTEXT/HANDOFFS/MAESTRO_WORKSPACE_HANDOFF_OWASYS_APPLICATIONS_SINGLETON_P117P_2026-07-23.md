# MAESTRO_WORKSPACE HANDOFF — OWASYS P117P

Date: 2026-07-23
Status: differential ZIP prepared and statically validated
Source OPUS head: `f336347e83d3f3610396dc527891496ca6d4d32f` (`p117o`)

## Purpose

P117P continues the OWASYS Applications state and verifies the Singleton architecture of autonomous OPUS applications.

The Applications state now exposes, for every registered/discovered OPUS application:

- its runtime Singleton compliance;
- its declared Singleton contract;
- its composition-root class;
- its public entrypoint;
- its explicit non-compliance diagnostic when the contract is absent or invalid.

## Confirmed OWASYS defect at source head

At `f336347…`, `sites/owasys/www/index.php` directly constructs:

- `OwasysAuthSession`;
- `OwasysRuntimeSecurity`;
- `OwasysRuntimeController`;
- `OwasysScorePageRenderer`.

OWASYS therefore did not satisfy the required application-level Singleton architecture at that source head.

P117P introduces `OwasysApplication`, the unique application composition root. It has:

- private static instance storage;
- private constructor;
- `instance()` factory;
- clone prevention;
- unserialization prevention;
- one `run()` entrypoint.

The public `www/index.php` now performs bootstrap and static-asset dispatch, then invokes only:

`OwasysApplication::instance($siteRoot, $siteConfig)->run();`

## Generic application Singleton contract

Each autonomous OPUS site declares its runtime contract in `config/site.json`:

```json
{
  "runtime": {
    "contract": "OPUS_APPLICATION_SINGLETON_V1",
    "architecture": "singleton",
    "class": "ApplicationCompositionRootClass",
    "file": "application/default/Application.php",
    "entrypoint": "www/index.php",
    "factory": "instance",
    "runner": "run"
  }
}
```

This is an application contract, not a new framework service. P117P therefore does not modify OPUS framework classes.

## Singleton inspection

`OwasysApplicationSingletonInspector` is an application-local Singleton service used by the Registry model. It validates every discovered OPUS site through the OPUS File boundary:

- `site.json` is parsed with `StructuredFileLoader`;
- the declared class and entrypoint are read with `Opus\File\File`;
- paths are constrained to the autonomous site root;
- the class must be final;
- the constructor must be private;
- static instance storage and `instance()` must exist;
- `run()` must exist;
- the public entrypoint must invoke the declared composition root through `instance()->run()`.

No application is silently treated as compliant when the contract is missing.

## Applications state

The Registry model enriches each application entry with a non-persistent Singleton inspection result. No SQLite schema change is required.

The SCORE page displays:

- total compliant applications;
- total non-compliant applications;
- an overall compliant/remediation-required message;
- one compliance badge and diagnostic per application card.

All new presentation strings exist in the 25 base-language Registry catalogs. Regional catalogs inherit them through the established explicit locale chain.

The existing Registry selection, creation-flow event, context clearing, SQLite synchronization, recent events, FSM routing, ACL and SSO behavior remain unchanged.

## Navigation

P117P is cumulative with the synchronized P117O-R1 menu/FSM navigation correction because the OPUS source head contains `p117o` but not a separate verified P117O-R1 commit.

The menu and Mermaid diagram retain their shared ACL plus `requires_current_app` availability projection.

## Framework component contract

P117P changes no concrete framework class and adds no concrete framework class.

The mandatory P117M-R1 audit remains a release gate. Any future concrete OPUS framework class must implement its homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

## File/configuration boundary

Runtime configuration is read through `Opus\File\File` and parsed through `StructuredFileLoader`, which selects JSON, YAML/YML or XML from the developer-selected extension.

P117P does not introduce a direct configuration `file_get_contents()` path in application runtime code.

## Security and rendering

The request path remains:

request -> browser/regional locale -> SSO -> deny-by-default ACL -> FSM -> ViewModel -> SCORE.

No PHP/HTML mixed view, UI-producing `echo`, local router, Auth0 bypass or bastion bypass is introduced.

## Verification status for all OPUS applications

The generation environment confirms OWASYS was non-Singleton at the GitHub source head and supplies its correction.

The included strict audit scans every `sites/*/config/site.json` on the target workspace. It reports every site individually and exits non-zero when any OPUS application remains non-compliant. This is required because the complete runtime site set, including locally present/uncommitted autonomous sites, can only be resolved on `H:\OPUS`.

No claim is made that every application is already compliant before that target audit is run.

## Delivery

Differential ZIP:

`opus_owasys_p117p_applications_singleton.zip`

The ZIP contains runtime files only plus maintenance scripts. It contains no Markdown, root launcher, smoke file or application-owned copy of framework assets.

No direct write is made to OPUS GitHub by the assistant.
