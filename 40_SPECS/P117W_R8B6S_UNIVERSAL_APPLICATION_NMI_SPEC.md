# P117W R8B6S — Universal application NMI contract

Status: READY FOR OWNER APPLICATION
Date: 2026-09-05

## Authority

This specification follows README-FIRST, the native ZIP delivery contract, the stepwise workflow contract, and extends the existing A4F NMI semantics without weakening them.

## Owner correction

Every OPUS application must expose non-maskable interruption paths for both classes of out-of-band failure:

1. security violation / loss of trusted security context;
2. critical runtime failure requiring immediate recovery.

These interruptions are application-level NMI transitions. They are not ordinary navigation, are never states, never use guards, and preempt the normal state relation.

## Canonical rules

- normal transitions remain finite and explicit;
- `from:"*"` remains forbidden except with `interrupt:"nmi"`;
- NMI signal is explicit and automatic;
- NMI carries no guard;
- recovery target must be a real declared safe state of the application;
- NMI is rendered out-of-band by OPUS;
- NMI remains auditable by Logger/Profiler/runtime semantics;
- application-specific signal names may differ when an established canonical signal already represents one class.

## Required current applications

### sites/essai

- `security_violation` NMI -> `connexion`;
- `critical_error` NMI -> `connexion`.

### owasys-front

- existing `auth_required` remains the canonical security NMI -> `login` with `clear_session`;
- add `critical_error` NMI -> `login` with `clear_session`.

### owasys-back

- existing `fail` remains the canonical critical-error NMI -> `api`;
- add `security_violation` NMI -> `api`.

## Generic scaffold

`Opus/Scaffold/SiteScaffoldPlan.php` must generate both NMI classes for every newly generated OPUS application:

- frontend/fullstack: `security_violation` and `critical_error`, both recovering to `begin`;
- backend: `security_violation` and `critical_error`, both recovering to `api`.

This is the generic-first correction. Existing applications are then brought into conformance explicitly.

## Non-goals

- no ordinary FSM topology redesign;
- no layout geometry change;
- no NMI color change;
- no REST, ACL, SSO, SCORE or Composer flow redesign;
- no change to the existing A4F rule that NMI is out-of-band.

## Acceptance

1. Every current target application has security and critical NMI coverage.
2. Generated frontend/fullstack/backend application FSMs include both NMI classes.
3. All NMI transitions use `from:"*"`, `interrupt:"nmi"`, explicit automatic signal, valid target, no guards.
4. Existing OWASYS front `auth_required` and back `fail` remain intact.
5. PHP lint and JSON parsing succeed.
6. Runtime diagrams show NMI out-of-band, never as a state.
