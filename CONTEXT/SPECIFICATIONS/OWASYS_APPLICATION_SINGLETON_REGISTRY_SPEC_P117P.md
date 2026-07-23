# OWASYS P117P — APPLICATION SINGLETON REGISTRY SPECIFICATION

## 1. Scope

This specification governs:

- the application-level Singleton architecture of autonomous OPUS applications;
- the OWASYS Registry inspection of that architecture;
- the presentation of compliance in the Applications FSM state.

## 2. Application-level Singleton

An autonomous OPUS application has exactly one composition-root instance per PHP request/runtime process.

The composition root:

- is final;
- owns the application service graph;
- has private static `?self` instance storage;
- has a private constructor;
- exposes `public static function instance(...)`;
- exposes one `public function run(): void` application entrypoint;
- cannot be cloned;
- cannot be unserialized into another instance.

This requirement applies to the application composition root. It does not require every model, controller or immutable value object to use the Singleton pattern.

## 3. Site runtime declaration

Each OPUS site declares:

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

Rules:

- all paths are relative to the autonomous site root;
- `..`, absolute drive paths and cross-site paths are forbidden;
- the class file and entrypoint must exist;
- the declared class must match the implementation invoked by the entrypoint;
- missing declarations are non-compliance, not implicit compatibility.

## 4. Public entrypoint

The site public entrypoint may:

- normalize the PHP development-server request;
- locate Composer autoload;
- serve explicitly authorized OPUS framework assets;
- read site configuration through the OPUS structured-file boundary;
- load application runtime class files when Composer does not own them.

It must then delegate application execution through:

`ApplicationCompositionRoot::instance(...)->run();`

The entrypoint must not construct the application controller/service graph directly.

## 5. OWASYS composition root

OWASYS uses `OwasysApplication` as its unique composition root.

It owns one instance each of the request-scoped application services required by `OwasysRuntimeController`, including session, SSO/ACL security and SCORE page rendering.

The composition root must reject a second `instance()` call targeting another site root.

## 6. Registry inspection

The application-local `OwasysApplicationSingletonInspector` is itself a Singleton bound to one OPUS root.

For each Registry application entry it:

1. validates the application root;
2. reads `config/site.json` with `StructuredFileLoader`;
3. validates `OPUS_APPLICATION_SINGLETON_V1`;
4. reads class and entrypoint source with `Opus\File\File`;
5. verifies the composition-root implementation and delegation;
6. returns an explicit compliance record.

Inspection is non-persistent. The SQLite Registry schema remains unchanged.

## 7. Compliance record

The result contains:

- `contract`;
- `architecture`;
- `class`;
- `file`;
- `entrypoint`;
- `compliant`;
- `error`.

A failed check returns `compliant=false` and an explicit stable diagnostic code.

## 8. Applications state ViewModel

Every Registry entry exposes:

- `singleton_compliant`;
- `singleton_noncompliant`;
- `singleton_contract`;
- `singleton_class`;
- `singleton_entrypoint`;
- `singleton_error`.

The aggregate Registry ViewModel exposes:

- `singleton_all_compliant`;
- `singleton_has_noncompliant`;
- compliant and non-compliant counts.

## 9. SCORE presentation

The Applications state remains SCORE-only.

It displays:

- a Singleton architecture audit panel;
- compliant/non-compliant totals;
- an overall result message;
- a compliance badge on each application card;
- the explicit technical diagnostic for a non-compliant application.

No controller emits translated HTML. New labels are provided by the Registry i18n catalogs.

## 10. I18n

All new Singleton labels must exist in the 25 base Registry catalogs:

- `registry.singleton.title`;
- `registry.singleton.description`;
- `registry.singleton.compliant`;
- `registry.singleton.noncompliant`;
- `registry.singleton.all_compliant`;
- `registry.singleton.remediation_required`.

Regional catalogs inherit base messages through the canonical explicit fallback chain. No English or key-name fallback is allowed.

## 11. FSM, ACL and SSO

Singleton inspection does not bypass the existing runtime pipeline:

request -> locale -> SSO -> ACL -> FSM -> ViewModel -> SCORE.

The Applications state remains the FSM `registry` state. Registry write actions remain protected by ACL. Direct route and state guards remain server-authoritative.

## 12. File and parser boundary

`site.json` and other structured configuration files are read through:

- `Opus\File\File`;
- `Opus\File\StructuredFileLoader`;
- the JSON, YAML/YML or XML parser selected by extension.

Application runtime code must not introduce direct structured-config reads.

## 13. Framework contract

P117P introduces no OPUS framework class.

Any concrete framework class added in later milestones must implement a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The P117M-R1 exhaustive audit remains mandatory.

## 14. Strict repository audit

The maintenance audit scans all `sites/*/config/site.json` found on the target OPUS workspace.

It prints one `SINGLETON_OK` or `SINGLETON_FAIL` line per application and aggregate counts.

The audit exits non-zero when any application is non-compliant. This is intentional: the statement “all OPUS applications are Singletons” is valid only when the target audit has zero failures.

## 15. Acceptance criteria

- OWASYS `www/index.php` delegates only to `OwasysApplication::instance(...)->run()` after bootstrap;
- OWASYS is reported compliant;
- every discovered OPUS application is visible with an explicit Singleton status;
- strict audit reports zero non-compliant applications before the global Singleton claim is accepted;
- existing application selection and current-context behavior still work;
- menu and FSM navigation remain synchronized;
- PHP lint passes;
- 25 base Registry catalogs contain all six new keys;
- P117M-R1 component audit passes;
- `git diff --check` passes;
- browser verification is performed on the Windows target.
