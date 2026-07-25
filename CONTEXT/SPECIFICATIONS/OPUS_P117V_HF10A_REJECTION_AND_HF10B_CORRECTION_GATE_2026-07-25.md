# OPUS P117V — HF10A REJECTION AND HF10B CORRECTION GATE

Date: 2026-07-25

## Owner evidence

The owner reproduced `GET /fr-FR/applications/` as HTTP 500 after HF10A.

The provided frontend runtime log proves:

```text
runtime_mode : front
error_code   : OPUS_RCP_CLIENT_TOKEN_NOT_CONFIGURED
backend call : not emitted
backend log  : therefore absent
```

`/fr-FR/applications/new` completes because that GET path does not require the Registry RCP synchronization performed by `/fr-FR/applications`.

## Decision

HF10A is rejected as an active deliverable.

Reasons:

1. it provides process-mode routing but does not physically migrate OWASYS to:

```text
application/shared
application/front
application/back
```

2. it does not provide a contractual local launch boundary that injects the same non-committed token and HMAC secret into both front and back processes;
3. the frontend therefore fails before REST dispatch and no backend trace can exist.

## HF10B mandatory scope

HF10B must be a direct differential ZIP superposable on `H:\OPUS` and contain only complete files at final paths.

It must provide:

- real OWASYS physical runtime layout under `application/shared`, `application/front`, `application/back`;
- separate front and back bootstraps;
- no `application/full`;
- fullstack as composition of shared + front + back;
- a local runtime launcher that generates or loads one token/HMAC pair and passes it to both child processes without committing or logging secrets;
- front logs in a front-specific file;
- back REST/Composer logs in a back-specific file;
- correlated profiler traces;
- strict route refusal by runtime mode;
- SCORE-only UI;
- REST-secured Composer mutation boundary;
- cleanup commands only after validation of the new paths.

## Immediate runtime diagnosis

Until HF10B is installed, the current HTTP 500 is not a backend failure. It is a frontend configuration failure:

```text
OPUS_RCP_CLIENT_TOKEN_NOT_CONFIGURED
```

The backend cannot log a request it never receives.

## Delivery status

```text
HF10A : rejected
HF10B : required, not yet delivered
```

No claim of correction or physical separation is valid before HF10B runtime evidence.