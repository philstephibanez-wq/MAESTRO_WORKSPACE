# MAESTRO WORKSPACE — Contract Amendment P112Q3E0

## Delivery Test & Regression Recipe Gate

**Status:** active contract amendment  
**Scope:** all MAESTRO_WORKSPACE sectors and repositories  
**Applies to:** ASAP, ASAP_REF_BOOK, MAESTRO_V5, MO_KB_DAEMON, MO_KB_FRONT, reference books, tools, scripts, APIs, UI, documentation, generators, recipes and future workspace projects.

---

## 1. Purpose

Every delivery must prove two things before it can be considered validated:

1. the new feature or correction delivered by the patch works;
2. the existing workspace did not regress because of hidden side effects.

A patch validated only by a local feature smoke is not a validated delivery.

---

## 2. Mandatory delivery gate

Every delivery must provide and run, when applicable:

1. a targeted test for the delivered functionality;
2. at least one unit or contract test for the delivered public behavior;
3. a smoke test for the delivered runtime path;
4. a global anti-regression recipe for the concerned repository or sector;
5. an observable report, log or artifact proving what ran and what passed or failed.

Expected delivery status markers:

```text
<PALIER>_FEATURE_SMOKE_OK
<PALIER>_UNIT_OR_CONTRACT_TEST_OK
<PALIER>_DELIVERY_RECIPE_OK
<SECTOR>_GLOBAL_REGRESSION_RECIPE_OK
ExitCode=0
```

A delivery fails when the feature works but the global regression recipe fails.

```text
<PALIER>_FEATURE_SMOKE_OK
<SECTOR>_GLOBAL_REGRESSION_RECIPE_FAILED
ExitCode=1
```

This state is not acceptable as a validation point.

---

## 3. No false OK rule

A command must never print an OK marker when the checked behavior did not actually run.

Forbidden patterns:

```text
OK although dependency was missing
OK although test file was not found
OK although report generation failed
OK although a required runtime path was skipped
OK based only on static text without executing the contract path
```

Allowed explicit states:

```text
OK
FAILED
SKIPPED_EXPLICITLY_WITH_REASON
NOT_APPLICABLE_WITH_REASON
```

A required test cannot be silently skipped. If a required dependency is unavailable, the delivery gate must fail with a clear error.

---

## 4. Observable recipe requirement

Every delivery recipe must be observable by the user or by a later audit.

At least one of these artifacts must be produced:

```text
JSON report
Markdown report
HTML report
log file
Mailpit email
visible test page
CLI summary with explicit markers and ExitCode
```

For rich UI and web deliveries, a visible page or browser-based recipe must be preferred when practical. For APIs, the recipe must include endpoint-level verification. For generators, the recipe must verify generated output and version markers.

---

## 5. Repository-level global recipes

Each code repository must progressively expose a stable global recipe command.

Target command names:

```text
tools\recipes\run_<repo>_global_regression_recipe.cmd
tools\recipes\run_<repo>_delivery_recipe.cmd
```

Examples:

```text
tools\recipes\run_asap_global_regression_recipe.cmd
tools\recipes\run_asap_delivery_recipe.cmd
tools\recipes\run_asap_ref_book_global_regression_recipe.cmd
tools\recipes\run_mo_kb_daemon_global_regression_recipe.cmd
```

The delivery recipe may call the global recipe after the feature-specific tests.

---

## 6. Windows execution contract

For Windows user-facing execution:

1. provide `.cmd` launchers, not `.bat`;
2. avoid long manual PowerShell blocks;
3. do not restart Apache, UwAmp, services or REAPER silently;
4. every launcher must return a meaningful ExitCode;
5. every launcher must print clear OK or FAILED markers.

VS Code tasks should be provided when a repository already uses `.vscode/tasks.json` or when the user asks for one-click execution.

---

## 7. Documentation-only deliveries

Documentation-only deliveries are not exempt.

They must provide at least:

1. a structure/link/render smoke when applicable;
2. a search/index/generation smoke when applicable;
3. a global documentation or RefBook regression recipe if the repository has one.

For ASAP_REF_BOOK, generated schemas are part of the documentation contract. Schema generation must be tested when schema data or rendering changes.

---

## 8. ASAP / ASAP_REF_BOOK special rule

ASAP is the source of truth for RefBook technical and functional metadata.

ASAP must progressively provide:

```text
Reflection-based public API scanner
RefBook attributes or structured PHPDoc metadata
RefBook contract validator
RefBook snapshot builder
RefBook API model
unit/contract tests for those contracts
global delivery recipe
```

ASAP_REF_BOOK must consume official ASAP data through snapshot or API and must not invent code signatures.

ASAP_REF_BOOK must also generate and validate schemas when applicable, including:

```text
FSM Mermaid diagrams
Router route graphs
ACL matrices
Security Dispatch sequences
class/domain dependency diagrams
coverage and documentation state diagrams
```

No schema that can be generated from real ASAP data should be maintained as a disconnected manual drawing.

---

## 9. Database / FSM deliveries

When a delivery depends on database or FSM changes:

1. no automatic database patch must be applied by the assistant;
2. manual SQL or manual Adminer operations must be provided explicitly when required;
3. validation queries must be provided;
4. the feature test must run after the user applies the manual database change;
5. the global regression recipe must run after the feature test.

A delivery that requires a database/FSM change but does not provide validation commands is incomplete.

---

## 10. Acceptance rule

A delivery can be called stable only after:

```text
feature-specific test passed
targeted unit or contract test passed
smoke test passed
global regression recipe passed
observable report produced
no silent skip occurred
ExitCode=0
```

If any item fails, the delivery remains a work-in-progress and must not be treated as a handoff checkpoint.

---

## 11. Handoff rule

A handoff is recommended only after a complete delivery gate passes.

A handoff created after a partial feature smoke but before the global regression recipe must be marked as partial and not stable.

---

## 12. Assistant workflow requirement

Before proposing or delivering a patch, the assistant must state the expected validation path:

```text
1. feature unit/contract test
2. feature smoke test
3. global regression recipe
4. observable report location
```

After the user runs the commands, the assistant must evaluate both the targeted result and the global recipe result. The assistant must not declare the patch validated from the targeted result alone.
