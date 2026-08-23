# P117W R45B2A4BZ2 R8B4C — System Security micro-EFSM registry repair handoff

State: READY FOR OWNER APPLY — NOT YET APPLIED

## Source-of-truth gate

All source facts used for this delivery were re-read from GitHub in the same work cycle; no memorized source state was used.

Current OPUS `master`:

`4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`

`opus_p117w_r45b2a4bz2r8b4b1_security_sso_localized_route_committed_baseline_repair`

Current target blobs:

- `sites/owasys-front/config/site.json`: `0c705f40b05128ab0f7197b99310c5d14c6f79da`;
- `sites/owasys-back/config/site.json`: `e5a67b2ee58158bc96e989fc079eaf90f620caa6`.

The current repository listings confirm that neither system application contains `config/security.fsm.json` at this baseline.

## Runtime defect supplied by owner

From the OWASYS-front UI on port 8000, selecting either system application and opening `/fr-FR/sécurité` fails with HTTP 500:

`OWASYS_APPLICATION_EFSM_SOURCE_UNRESOLVED`

Affected selected applications:

- `owasys-front`;
- `owasys-back`.

The generated application `essai` remains valid and was previously fully accepted with its explicit `efsms.security` registry entry.

## Root cause

Current `OwasysApplicationFsmModel::snapshot()` resolves named EFSM authority from selected `site.json.efsms`.

It has a compatibility fallback only for `navigation`. It intentionally has no Security fallback.

Both OWASYS system `site.json` files predate the R8B4 contextual registry migration and have no `efsms` map. Therefore `security` has no source authority and the model throws the exact owner-visible error.

## Repair

R8B4C completes the migration rather than weakening source resolution.

Exact differential:

1. modify `sites/owasys-front/config/site.json`;
2. create `sites/owasys-front/config/security.fsm.json`;
3. modify `sites/owasys-back/config/site.json`;
4. create `sites/owasys-back/config/security.fsm.json`.

Each system site receives:

- `efsms.navigation = config/fsm.json`;
- `efsms.security = config/security.fsm.json`.

Each new Security source is a dedicated `OPUS_SECURITY_FSM_V1` definition owned by its application, with `efsm_id=security` and the accepted authentication/reauthentication lifecycle skeleton.

No fallback `security -> config/fsm.json` is introduced. The existing navigation/execution FSMs remain separate.

No JavaScript/TypeScript/Node/package-manager artifact is introduced into `sites/owasys-back`.

## Artifact

ZIP:

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair.zip`

ZIP SHA-256:

`6280f951ff6d217d8c01b0db6c1f31f82abe42800278f09030190269db238c73`

Contained applicator only:

`apply_a4bz2r8b4c.php`

Applicator SHA-256:

`a46c4cc42f92045de8372567192a7f24e7b035ca1aed49f8e25e4d9d9116bd66`

PHP lint: PASS.

## Applicator construction validation

The applicator uses structural JSON mutation only; there are no textual replacement anchors.

A complete deterministic mock Git-repository execution was performed before delivery. It exercised:

- exact HEAD gate;
- clean-worktree gate;
- exact blob gates;
- File/StructuredFileLoader reads;
- structural site registry mutation;
- creation of both Security definitions;
- definition/runtime validation;
- repository-status verification;
- exact four-path differential.

The first mock run exposed an applicator-only verification defect before delivery: `trim()` on `git status --porcelain` removed the leading worktree status space from the first line. The post-write failure path rolled back correctly. The applicator was corrected to preserve leading porcelain status whitespace and the full mock execution was repeated successfully.

Successful construction-test markers:

- `P117W_R45B2A4BZ2R8B4C_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B4C_REPO_CHANGES_VERIFIED`;
- `P117W_R45B2A4BZ2R8B4C_APPLIED`;
- `changed_paths=4`.

The mock final Git status was exactly:

- modified `sites/owasys-front/config/site.json`;
- modified `sites/owasys-back/config/site.json`;
- new `sites/owasys-front/config/security.fsm.json`;
- new `sites/owasys-back/config/security.fsm.json`.

## Owner apply gate

Apply only on exact OPUS HEAD `4043702f4bc6b190fd51f2acc1fe6d939e3c19c1` with a completely clean worktree/index.

Required successful markers:

- `P117W_R45B2A4BZ2R8B4C_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B4C_REPO_CHANGES_VERIFIED`;
- `P117W_R45B2A4BZ2R8B4C_APPLIED`;
- `baseline_head=4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`;
- `changed_paths=4`;
- front/back Security source markers.

Do not commit/push after application until CLI and runtime acceptance pass.

## Acceptance after apply

CLI:

- `composer opus:validate-site -- owasys-front` => valid;
- `composer opus:validate-site -- owasys-back` => valid;
- `composer opus:validate-site -- essai` => valid;
- Git status exactly four expected paths.

Runtime through OWASYS-front `:8000`:

1. select `owasys-front`, open `/fr-FR/sécurité`;
   - no source-unresolved error;
   - authority `owasys-front / security / config/security.fsm.json`;
2. select `owasys-back`, open `/fr-FR/sécurité`;
   - no source-unresolved error;
   - authority `owasys-back / security / config/security.fsm.json`;
3. select `essai`;
   - accepted `essai / security / config/security.fsm.json` remains unchanged;
4. Structure remains bound to each application's navigation source.

Only after these gates may the owner commit/push OPUS.

## Next slice

After R8B4C acceptance, continue the planned architecture from the then-current GitHub HEAD: explicit SecurityContext runtime ownership plus the first Security/Navigation inter-EFSM COMMAND/EVENT cooperation. Generic generated-application PHP ACTION/GUARD source authoring remains subsequent.