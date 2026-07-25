# MAESTRO_WORKSPACE HANDOFF — HF10A REJECTED, HF10B REQUIRED

Date: 2026-07-25

## Source of truth

```text
OPUS remote HEAD : 41f77ad7187c0facb125a5737b62d10928809e66
Owner local      : H:\OPUS + HF10A overlay
Evidence         : owasys-frontend.log supplied by owner
```

## Runtime evidence

Repeated failures on `/fr-FR/applications`:

```text
runtime_mode=front
error_code=OPUS_RCP_CLIENT_TOKEN_NOT_CONFIGURED
```

Successful GET on `/fr-FR/applications/new` is also recorded.

Conclusion:

```text
frontend logger  : active
frontend profiler: active
REST request     : not emitted
backend logger   : cannot receive an event
```

## Architectural finding

HF10A only introduced process-mode selection. It did not perform the owner-approved physical OWASYS migration:

```text
application/shared
application/front
application/back
```

HF10A is therefore rejected and must not be committed as the accepted milestone.

## Immediate local recovery

Both processes must inherit the same `OPUS_OWASYS_BACKEND_TOKEN` and `OPUS_OWASYS_BACKEND_HMAC` values. Secrets must remain ephemeral or in an ignored local runtime store; they must not enter Git, logs, profiler data, argv or the differential ZIP.

## Required next differential

HF10B must provide:

- direct-overlay ZIP delivery;
- physical shared/front/back layout;
- separate bootstraps;
- correlated front/back launcher;
- distinct front and backend logs;
- strict runtime route isolation;
- no silent fallback;
- post-validation cleanup commands for obsolete paths.

## Active status

```text
HF10A deliverable : withdrawn
HF10B deliverable : required
Cleanup            : forbidden before HF10B validation
```

Preserve `sites/owasys_old`, all current logs, profiler traces and Registry data.