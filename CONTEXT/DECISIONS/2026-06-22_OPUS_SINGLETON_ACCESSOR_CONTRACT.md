# Decision — OPUS singleton / accessor contract

Date: 2026-06-22
Project: OPUS
Status: accepted for implementation tooling

## Decision

OPUS keeps the historical ASAP intent:

- OPUS is a framework shared by applications/sites.
- Each site/application may have its own singleton instance scope.
- Framework classes should keep internal variables protected.
- Access to protected state must go through getters/setters.
- Automatic getter/setter behavior is a core OPUS feature, not legacy debris.

## Contract

The OPUS framework will introduce or restore:

```text
OPUS_AccessorInterface
OPUS_Singleton
```

`OPUS_AccessorInterface` requires:

```text
get(property)
set(property, value)
has(property)
```

`OPUS_Singleton` provides dynamic accessors:

```text
getXxx()
setXxx(value)
hasXxx()
```

Property resolution must support protected underscore properties, so `getSite()` may resolve `$_site`.

## Singleton scope

The singleton is not only global. It must support scoped instances:

```text
getInstance()
getInstanceForSite(siteId)
getInstanceForApplication(applicationId)
```

This means one instance per concrete class and per site/application scope.

## Important boundary

A singleton does not prevent two browser sessions or two tabs by itself. That is a separate lock/guard concern.

Future explicit guard:

```text
OPUS_SiteSessionGuard
OPUS_ApplicationLock
```

## Active OPUS commits around this decision

P0 validated:

```text
P0_OPUS_REBORN_CLEANUP
```

P1/P1B validated:

```text
P1_OPUS_BOOT_RENDER_SMOKE_OK
P1B_OPUS_VIEW_SCORETEMPLATE_SMOKE_OK
```

P1D validated:

```text
P1D_OPUS_NAMING_STANDARDIZATION
```

P2 tooling delivered in OPUS:

```text
P2_ADD_SINGLETON_ACCESSOR_APPLY_TOOL
P2_ADD_SINGLETON_ACCESSOR_SMOKE
P2_DOC_SINGLETON_ACCESSOR_CONTRACT
```

## Rationale

This preserves the original ASAP design value while modernizing the implementation carefully:

```text
As Simple As Possible
protected state
controlled access
no hand-written boilerplate getters/setters
no silent fallback
```

## Next

Run local P2 apply/smoke in `H:\OPUS`, then commit the generated framework changes only if all smokes pass.
