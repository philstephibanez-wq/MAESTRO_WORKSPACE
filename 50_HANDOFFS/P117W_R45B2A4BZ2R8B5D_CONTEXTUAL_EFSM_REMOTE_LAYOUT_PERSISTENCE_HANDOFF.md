# P117W R45B2A4BZ2 R8B5D — Contextual EFSM remote layout persistence — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source of truth

Final same-cycle gate:

- MAESTRO `README-FIRST.md` blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`;
- OPUS baseline/master: `0a0805ae0a9e0981c80f1304ea167bab4740afe1`;
- active architecture: `P117W_MICRO_EFSM_APPLICATION_SKELETON_ARCHITECTURE_SPEC.md` blob `1cff3b8b31bd2db97b5a6e1f52642c5e468b6331`;
- R8B5D final spec blob: `a48b4e8754e650c7a938abfc454e153fad1a646f`;
- R8B5D final spec commit: `005daf821d7819755604ce9bdf09f3b436f606ee`.

Applicable MAESTRO contracts were reread at their current blobs: Development `185b8a4637dc8a43119192712b1d742ac8371324`, Patch Delivery `6f4c86c5194345357530f47bca4a981ebf7d77a7`, Git/Branch `685ee3d2d91322e281232cf597d0118165b1c83c`, Zero Fallback `29f4be7be52cb5b535f310af45151cc9995ae4ff`.

## Runtime cause being treated

R8B5C recovered OWASYS-front, but selected-application contextual EFSM diagrams no longer expose right-button movement of STATE/SIGNAL.

The generic `OPUS_FSM_Diagram` drag code is still present. Contextual diagrams are rendered without writable layout persistence, so the generic renderer emits neither writable drag markers nor the interaction script.

Local `FsmDiagramLayoutStore::discover()` cannot be enabled for a selected application because it derives ownership from current `DOCUMENT_ROOT` and would bind to OWASYS-front. R8B5D therefore restores persistence through the distributed OWASYS authority path instead of a local filesystem workaround.

## Final architecture

`browser right-drag -> owasys-front CSRF/ACL -> secured REST -> owasys-back -> allow-listed Composer -> FsmDiagramLayoutStore bound to selected application/EFSM -> atomic *.fsm.layout.json -> response -> front`

No selected-application filesystem access is introduced in OWASYS-front. No JavaScript/TypeScript/Node/package artifact is introduced in OWASYS-back.

## Authorization invariant

Owner clarification recorded and applied:

- admin can modify every application, including `owasys-front` and `owasys-back`;
- admin cannot delete `owasys-front` or `owasys-back`; existing `SiteCommandService` already rejects these IDs with `OPUS_DELETE_SITE_PROTECTED`;
- developer may fully develop an existing application for which development access is granted, including EFSM semantics and graphical layout;
- viewer is read-only.

R8B5D creates no layout-specific ACL permission. Write uses existing `fsm:update`; viewer receives backend `fsm:read` only.

## Important final-gate correction

A pre-final R8B5D artifact was rejected before delivery because it updated only the backend REST resource declarations.

Current OWASYS-front `config/rest-api.json` points to its own `config/rest.resources.json`. Without updating that client catalog, `RestClient::assertRequest()` would reject the new layout endpoint locally and the front/back catalog fingerprint would diverge.

The final applicator therefore modifies all three resource declarations and requires exact resource-list parity before any write:

1. front `sites/owasys-front/config/rest.resources.json`;
2. back inline `sites/owasys-back/config/backend.rest.json`;
3. back external `sites/owasys-back/config/backend.resources.json`.

The superseded pre-final ZIP SHA `3159708ab154e9e27757cbd3e56e4fdeea2dc762e505b0b0a1e4fb171fffde9e` MUST NOT be applied.

## Final artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b5d_contextual_efsm_remote_layout_persistence.zip`;
- ZIP SHA-256: `502d26a7113ef874f3af9452d2349f2b3c88f39976e82b55ed76222394d66dab`;
- ZIP contents: exactly `apply_a4bz2r8b5d.php`;
- applicator SHA-256: `beb4b65f17abadcc9410de6d6f77cc569b3eba12efcacd80e49d9c4023b50ac7`;
- applicator size: 72890 bytes;
- applicator PHP lint: PASS;
- final ZIP was re-extracted and its payload byte-compared with the final applicator: PASS.

## Exact differential

17 paths = 13 modified + 4 new.

Modified:

1. `Opus/Fsm/Diagram.class.php`;
2. `Opus/Fsm/FsmDiagramLayoutStore.php`;
3. `composer.json`;
4. `sites/owasys-front/application/default/bootstrap.php`;
5. `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
6. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
7. `sites/owasys-front/application/default/services/FsmDesignerGateway.php`;
8. `sites/owasys-front/config/rest.resources.json`;
9. `sites/owasys-back/config/backend.rest.json`;
10. `sites/owasys-back/config/backend.resources.json`;
11. `sites/owasys-back/config/backend.operations.json`;
12. `sites/owasys-back/config/composer.commands.json`;
13. `sites/owasys-back/config/acl.json`.

New:

14. `sites/owasys-front/application/fsm/models/ApplicationFsmLayoutModel.php`;
15. `sites/owasys-back/application/fsm/layout.console.php`;
16. `sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProviderInterface.php`;
17. `sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProvider.php`.

## Applicator guarantees

Before write:

- exact OPUS HEAD;
- clean tracked/index/untracked state;
- exact blob SHA for every modified target, including front REST catalog;
- all new paths absent;
- every textual replacement anchor occurs exactly once;
- all staged PHP linted;
- all staged JSON parsed;
- front/back REST resource-list parity checked;
- no forbidden backend JS/TS path.

After write, before success marker:

- changed PHP linted again;
- changed JSON loaded through `StructuredFileLoader`;
- source-bound generic `FsmDiagramLayoutStore` smoke persists a STATE then SIGNAL geometry in an out-of-repository temporary site;
- exact differential inventory enforced: 13 modified + 4 new;
- index remains clean;
- `git diff --check`;
- HEAD unchanged;
- `composer dump-autoload -o --no-interaction`;
- `composer opus:validate-site -- owasys-front`;
- `composer opus:validate-site -- owasys-back`;
- `composer opus:validate-site -- essai`.

Any post-write exception rolls the 17 source paths back and exits with `P117W_R45B2A4BZ2R8B5D_POST_WRITE_FAILED:...`.

## Expected success markers

- `P117W_R45B2A4BZ2R8B5D_PREFLIGHT_BEGIN`;
- `P117W_R45B2A4BZ2R8B5D_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B5D_REPO_CHANGES_VERIFIED`;
- `P117W_R45B2A4BZ2R8B5D_APPLIED`;
- `baseline_head=0a0805ae0a9e0981c80f1304ea167bab4740afe1`;
- `changed_paths=17`;
- `layout_transport=front>rest>back>composer`;
- `layout_write_acl=fsm:update`;
- `layout_read_acl=fsm:read`;
- `right_drag=state+signal`.

## Owner runtime acceptance pending

Do not commit/push R8B5D until these runtime gates are observed:

1. select a generated app such as `essai`;
2. Structure -> Conception (`navigation`): right-drag a STATE, reload, position remains;
3. right-drag a SIGNAL, reload, position remains;
4. Security -> Conception (`security`): repeat STATE and SIGNAL persistence;
5. VIEW displays persisted geometry but is not writable;
6. generated companion layout files live only under selected application and use canonical derived names;
7. Sources + Git sees the new companion files;
8. front/back Logger/Profiler show the secured REST/Composer layout request without secrets;
9. existing Security COMMAND/EVENT coordination and R8B5B reauthentication ownership remain functional.

Only after owner runtime acceptance should OPUS be committed/pushed and the next slice be started.
