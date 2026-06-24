# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

## Permanent rules

```text
NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
```

OPUS is an applicative web framework. HTML output must come from `.score` templates through explicit data/view-model contracts. Do not assemble product HTML in PHP, do not query data from templates, and do not bypass generators or runtime contracts.

## Current validated OPUS state — P6D8

```text
OPUS root      : H:\OPUS
OPUS GitHub    : philstephibanez-wq/OPUS
Workspace root : H:\MAESTRO_WORKSPACE
Workspace repo : philstephibanez-wq/MAESTRO_WORKSPACE
```

Validated OPUS commits:

```text
545b40b P6A_REMOVE_LEGACY_RUNTIME_BOUNDARY
20febaa P6A_REMOVE_RESIDUAL_LEGACY_AUTOLOADER_NEW2
470a755 P6A_FIX_LEGACY_REMOVAL_SMOKE_CONTRACT
05fbe29 P6B_ARCHIVE_P6A_MIGRATION
3a52a81 P6C_FIX_RUNTIME_REFERENCE_SCOPE
d174b7f P6D_ADD_RUNTIME_APPLICATION_NAMESPACE_AND_REFBOOK_DOC_AUDIT
abba89a P6D3_REPAIR_RUNTIME_REFBOOK_DOC_AUDIT_AND_REGISTER_SMOKE
506b165 P6D4_DOCBLOCK_RUNTIME_CORE_BATCH1
58c10d2 P6D5_DOCBLOCK_HTTP_APPLICATION_FOUNDATION_BATCH2
ac89d3d P6D6_DOCBLOCK_BREADCRUMB_SECURITY_LEGACY_COMPONENTS_BATCH3
36fb893 P6D7_DOCBLOCK_CONFIG_CONTROLLER_CORE_EXCEPTION_BATCH4
4f4a058 P6D8_DOCBLOCK_ALL_REMAINING_REFBOOK_CLASSES
```

Runtime state:

```text
Opus/Legacy removed from Git and disk.
Opus/Runtime/Application.php is active.
Opus/Runtime/Application.php still exposes historical global class OPUS_Application.
Opus/Runtime/Bootstrap.php remains stable.
www/index.php is Composer-only.
tools/audits/audit_p6c_select_next_runtime_cleanup_target.py is active.
tools/audits/audit_p6d_runtime_application_namespace_readiness.py is active.
```

Validated checks:

```text
P6D_RUNTIME_APPLICATION_NAMESPACE_AND_REFBOOK_DOC_AUDIT_OK
P3B_OPUS_TOOLS_LAYOUT_SMOKE_OK
P5B_CURRENT_RUNTIME_LAYOUT_SMOKE_OK
git status clean
```

## P6D RefBook autodoc state after P6D8

```text
CHECK_REFBOOK_CLASS_DOCBLOCK_COVERAGE_100_PERCENT=OK
CLASS_LIKE_TOTAL=79
CLASS_LIKE_NAMESPACED=35
CLASS_LIKE_GLOBAL=44
CLASS_LIKE_WITH_DOCBLOCK=79
CLASS_LIKE_MISSING_DOCBLOCK=0
OPUS_Application runtime references=11
DECISION=P6D_READY_FOR_RUNTIME_APPLICATION_NAMESPACE_MIGRATION
NEXT_SAFE_STEP=P6D_APPLY_RUNTIME_APPLICATION_NAMESPACE_CONTRACT
```

P6D4 documented:

```text
Opus/Runtime/Application.php
Opus/Runtime/Bootstrap.php
Opus/Runtime/Kernel.php
Opus/Routing/Router.php
Opus/View/View.php
```

P6D5 documented:

```text
Opus/Http/Request.php
Opus/Http/Response.php
Opus/Application/ApplicationDefinition.php
Opus/Application/ApplicationRegistry.php
Opus/Foundation/Support.php
```

P6D6 documented:

```text
Opus/Componants/Breadcrumb/BreadcrumbItem.php
Opus/Componants/Breadcrumb/RouterBreadcrumbBuilder.php
Opus/Security/Acl.php
Opus/Componants/Link/Link.class.php
Opus/Componants/Menu/Menu.class.php
```

P6D7 documented:

```text
Opus/Config/ConfigLoader.class.php
Opus/Config/Configuration.class.php
Opus/Controller/Controller.class.php
Opus/Core/Singleton.class.php
Opus/Exception/Exception.class.php
```

P6D8 documented all remaining RefBook class/interface declarations, including:

```text
Acl legacy classes
Db legacy classes, including OPUS_adodb5
Debug
FSM legacy + namespaced classes
Ftp
Helper
Html
I18n legacy + namespaced classes
Mail legacy classes
Model
Rest
Router legacy
Site legacy classes
Smtp embedded classes
Url
Validation
Xml
```

Runtime references to OPUS_Application still remain:

```text
Opus/Componants/Menu/Menu.class.php
Opus/Controller/Controller.class.php
Opus/Helper/Helper.class.php
Opus/Html/Html.class.php
Opus/I18n/I18n.class.php
Opus/Mail/PhpMailer.class.php
Opus/Model/Model.class.php
Opus/Router/Router.class.php
Opus/Runtime/Application.php
Opus/Url/Url.class.php
www/index.php
```

## Immediate next work

```text
1. P6D_APPLY_RUNTIME_APPLICATION_NAMESPACE_CONTRACT.
2. Inspect the 11 OPUS_Application runtime references.
3. Prepare a minimal migration patch for the runtime application namespace contract.
4. Preserve runtime compatibility explicitly; no fallback silencieux.
5. Validate with P6D audit, P3B smoke, P5B smoke and runtime checks before commit.
```

## Specific handoffs

```text
CONTEXT/HANDOFFS/P6D8_20260624_OPUS_ALL_REMAINING_REFBOOK_DOCBLOCKS.md
CONTEXT/HANDOFFS/P6D6_20260624_OPUS_BREADCRUMB_SECURITY_LEGACY_COMPONENTS_DOCBLOCK_BATCH3.md
CONTEXT/HANDOFFS/P6D5_20260624_OPUS_HTTP_APPLICATION_FOUNDATION_DOCBLOCK_BATCH2.md
CONTEXT/HANDOFFS/P6D4_20260624_OPUS_RUNTIME_CORE_DOCBLOCK_BATCH1.md
CONTEXT/HANDOFFS/P6D_20260624_OPUS_RUNTIME_APPLICATION_REFBOOK_DOC_AUDIT.md
CONTEXT/HANDOFFS/P6C_20260624_OPUS_RUNTIME_CLEANUP_TARGET_SELECTED.md
CONTEXT/HANDOFFS/P6B_20260624_OPUS_LEGACY_REMOVED.md
```

## Repository write policy

```text
MAESTRO_WORKSPACE : assistant may write directly to GitHub for contracts, ADRs, handoffs and project context updates.
OPUS              : no direct assistant write/commit/push; local runners only, then user validates and commits/pushes.
All repositories  : no direct mutation outside explicitly authorized scope.
```

## Current source-of-truth rule

```text
OPUS code and OPUS-owned sites : philstephibanez-wq/OPUS
Workspace context              : philstephibanez-wq/MAESTRO_WORKSPACE
No direct work on removed roots : H:\OPUS_REF_BOOK, H:\LOGANDPLAY.ORG
```
