# P117W R45B2A4BZ2 R8B4C — System Security micro-EFSM registry repair handoff

State: OWNER RUNTIME ACCEPTED — OPUS COMMIT/PUSH REQUIRED BEFORE NEXT DIFFERENTIAL

## Source-of-truth gate

All source facts used for this delivery were re-read from GitHub in the delivery work cycle; no memorized source state was used.

Delivery baseline OPUS `master`:

`4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`

`opus_p117w_r45b2a4bz2r8b4b1_security_sso_localized_route_committed_baseline_repair`

Delivery target blobs:

- `sites/owasys-front/config/site.json`: `0c705f40b05128ab0f7197b99310c5d14c6f79da`;
- `sites/owasys-back/config/site.json`: `e5a67b2ee58158bc96e989fc079eaf90f620caa6`.

## Runtime defect supplied by owner

From the OWASYS-front UI on port 8000, selecting either system application and opening `/fr-FR/sécurité` failed with HTTP 500:

`OWASYS_APPLICATION_EFSM_SOURCE_UNRESOLVED`

Affected selected applications:

- `owasys-front`;
- `owasys-back`.

## Root cause

`OwasysApplicationFsmModel::snapshot()` resolves named EFSM authority from selected `site.json.efsms`.

It has a compatibility fallback only for `navigation`. It intentionally has no Security fallback.

Both OWASYS system `site.json` files predated the R8B4 contextual registry migration and had no `efsms` map. Therefore `security` had no source authority.

## Repair

R8B4C completed the migration rather than weakening source resolution.

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

## Owner acceptance

Owner report on 2026-08-24 after application/runtime test:

`réglé`

This is recorded as runtime acceptance of the R8B4C defect repair.

The GitHub OPUS source-of-truth was re-read immediately afterwards. At that time `master` still pointed to the delivery baseline `4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`; therefore the accepted R8B4C differential had not yet been committed/pushed to OPUS GitHub.

Per README-FIRST, the assistant never commits/pushes OPUS/OWASYS. The owner must now commit and push the accepted four-path differential before the next OPUS differential can be safely generated from a new exact GitHub baseline.

## Next slice gate

Planned next architecture remains:

1. explicit SecurityContext runtime ownership;
2. first Security/Navigation inter-EFSM COMMAND/EVENT cooperation;
3. only afterwards, generic generated-application PHP ACTION/GUARD source authoring.

The next differential must be designed from the **post-R8B4C GitHub HEAD**, not reconstructed from memory or an uncommitted local tree. Until that HEAD exists on GitHub, next-patch generation is intentionally blocked by the source-of-truth contract.