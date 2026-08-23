# P117W R45B2A4BZ2 R8B4C — System Security micro-EFSM registry repair

State: SPECIFIED — IMPLEMENTATION IN PROGRESS

## Source-of-truth gate

This slice was specified only after re-reading the current GitHub sources in the same work cycle.

Current OPUS `master`:

`4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`

`opus_p117w_r45b2a4bz2r8b4b1_security_sso_localized_route_committed_baseline_repair`

Current tracked target blobs:

- `sites/owasys-front/config/site.json`: `0c705f40b05128ab0f7197b99310c5d14c6f79da`;
- `sites/owasys-back/config/site.json`: `e5a67b2ee58158bc96e989fc079eaf90f620caa6`.

Current `README-FIRST.md`, `00_COMMON_CONTRACTS/DEVELOPMENT_CONTRACT.md` and `00_COMMON_CONTRACTS/PATCH_DELIVERY_CONTRACT.md` were re-read before this specification.

## Runtime evidence

After full acceptance of the generated-application `essai` contextual Security slice, the owner selected each OWASYS system application from the OWASYS-front UI and opened `/fr-FR/sécurité`.

Both selections fail with HTTP 500:

`OWASYS_APPLICATION_EFSM_SOURCE_UNRESOLVED`

The failure is produced by the contextual selected-application EFSM projection, not by the generated `essai` definition.

## Root cause

`OwasysApplicationFsmModel::snapshot()` resolves a named micro-EFSM from the selected application's `config/site.json` registry `efsms`.

For `navigation` only, legacy/system fallback exists to `config/fsm.json`.

For `security`, no fallback exists by design; an unresolved registry entry throws:

`OWASYS_APPLICATION_EFSM_SOURCE_UNRESOLVED:security`

Both system applications currently have:

- `navigation.fsm = config/fsm.json`;
- no `efsms` registry;
- no dedicated `config/security.fsm.json`.

Therefore R8B4 migrated generated applications such as `essai`, but did not complete the same contextual-authority migration for `owasys-front` and `owasys-back`.

## Architectural decision

Do **not** add `security -> config/fsm.json` fallback.

That would re-project the host/navigation/execution FSM as Security and would violate the contextual micro-EFSM architecture as well as the zero-fallback development contract.

Each OWASYS bastion receives a dedicated declared Security micro-EFSM and an explicit registry entry.

## Exact differential

Four paths only:

1. modify `sites/owasys-front/config/site.json`;
2. create `sites/owasys-front/config/security.fsm.json`;
3. modify `sites/owasys-back/config/site.json`;
4. create `sites/owasys-back/config/security.fsm.json`.

No JavaScript, TypeScript, Node artifact or JavaScript package artifact may be added to `sites/owasys-back`.

## Registry contract

Both system `site.json` files receive:

```json
"efsms": {
    "navigation": "config/fsm.json",
    "security": "config/security.fsm.json"
}
```

The existing `navigation.fsm` remains unchanged.

## Security definition contract

Each new `config/security.fsm.json` is a dedicated `OPUS_SECURITY_FSM_V1` definition with:

- `site_id` equal to the owning application;
- `efsm_id = security`;
- initial state `anonymous`;
- states `anonymous`, `authenticating`, `authenticated`, `reauthenticating`;
- signals `login_requested`, `authentication_succeeded`, `authentication_failed`, `logout_requested`, `session_expired`, `reauth_required`, `reauthentication_succeeded`, `reauthentication_failed`;
- the canonical authentication/reauthentication lifecycle transitions already accepted for generated Security micro-EFSMs.

This slice establishes explicit Security definition ownership for the two system applications. It does not yet claim runtime COMMAND/EVENT ownership or replace the existing bastion SSO/REST implementation; that remains the next architectural slice.

## Applicator safety gate

The differential applicator must:

- require exact HEAD `4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`;
- require an entirely clean worktree and index;
- require the two tracked `site.json` blobs above;
- require both new `security.fsm.json` paths to be absent;
- read configuration through OPUS File/StructuredFileLoader boundaries;
- mutate JSON structurally, never through textual anchors;
- validate both Security definitions using the current `FsmDefinitionValidator`;
- instantiate the current `FsmProcessor` for both definitions to verify runtime contract compatibility;
- write atomically;
- roll back all four paths on any post-write failure;
- verify the exact final repository differential: two modified tracked files plus two untracked Security definition files.

## Acceptance

Repository gate:

- exactly four changed paths;
- no other source change;
- both sites remain valid under `composer opus:validate-site`.

Runtime gate from OWASYS-front on port 8000:

- select `owasys-front`, open `/fr-FR/sécurité`: no `OWASYS_APPLICATION_EFSM_SOURCE_UNRESOLVED`; authority must show `owasys-front / security / config/security.fsm.json`;
- select `owasys-back`, open `/fr-FR/sécurité`: no `OWASYS_APPLICATION_EFSM_SOURCE_UNRESOLVED`; authority must show `owasys-back / security / config/security.fsm.json`;
- select `essai`: previously accepted `essai / security / config/security.fsm.json` remains unchanged;
- Structure still resolves each application's navigation authority independently.

No commit/push of OPUS/OWASYS until owner runtime acceptance.