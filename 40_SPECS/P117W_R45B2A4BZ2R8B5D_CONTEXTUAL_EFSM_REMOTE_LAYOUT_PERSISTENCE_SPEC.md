# P117W R45B2A4BZ2 R8B5D — Contextual EFSM remote layout persistence

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source-of-truth gate

Final delivery is based on a fresh same-cycle read of:

- `README-FIRST.md` blob `1d7c00ade6521a5fe3fcb83139ce18d98033e810`;
- current OPUS GitHub `master` = `0a0805ae0a9e0981c80f1304ea167bab4740afe1`;
- exact R8B5C commit diff;
- `DEVELOPMENT_CONTRACT.md`, `ZERO_FALLBACK_CONTRACT.md`, `PATCH_DELIVERY_CONTRACT.md`, `GIT_AND_BRANCH_CONTRACT.md`;
- active `P117W_MICRO_EFSM_APPLICATION_SKELETON_ARCHITECTURE_SPEC.md`;
- current `OPUS_FSM_Diagram`, `FsmDiagramLayoutStore`, `FsmSiteLoader`;
- current OPUS REST `RestClient`, `RestServer`, `RestResourceCatalog`, `ComposerCommandRegistry`, `ApplicationCommandDispatcher`, `ComposerScripts`, root `composer.json`;
- current OWASYS-front `rest-api.json`, `rest.resources.json`, `FsmDiagramBuilder`, `FsmDesignerGateway`, `ScorePageRenderer`, `SecurityController` and ACL;
- current OWASYS-back REST/Composer catalogs, FSM provider registry and ACL;
- current `SiteCommandService`, which already rejects deletion of `owasys-front` and `owasys-back` with `OPUS_DELETE_SITE_PROTECTED`.

## Runtime report

Owner confirms R8B5C recovered OWASYS-front, but right-button dragging of STATE and SIGNAL presentation objects is no longer available on contextual selected-application EFSM diagrams.

## Cause

The right-button drag implementation still exists in generic `OPUS_FSM_Diagram` and is correct. It is emitted only when the diagram has writable layout client configuration.

Selected-application contextual diagrams currently come from `OwasysApplicationFsmModel::snapshot()` with `persistLayout: false`, so they never receive writable layout client configuration and therefore receive neither draggable markers nor the generic right-button interaction script.

The local `FsmDiagramLayoutStore::discover()` cannot be enabled blindly because it resolves ownership from the current web `DOCUMENT_ROOT`, which is OWASYS-front. The selected application can be another application/bastion. Selected-application layout authority must therefore remain remote and explicit.

## Authorization contract — owner clarified

No new layout-specific permission is introduced.

- `admin` has all development rights and may modify every application, including `owasys-front` and `owasys-back`;
- `admin` may never delete `owasys-front` or `owasys-back`; this is a structural backend invariant already enforced by `SiteCommandService` and is not weakened by R8B5D;
- `developer` may fully develop an existing application for which development access is granted: sources, configuration, SCORE, EFSM, STATE, SIGNAL, TRANSITION, GUARD, ACTION and diagram layout are all development operations;
- `viewer` is read-only.

For R8B5D, layout write uses the existing `fsm:update` capability. Current admin/developer `fsm:*` grants already satisfy it. Viewer receives only `fsm:read` on the backend layout projection.

## Required architecture

R8B5D restores portable diagram geometry through explicit remote authority:

`browser right-drag -> owasys-front CSRF/ACL -> secured REST -> owasys-back -> allow-listed Composer -> generic FsmDiagramLayoutStore bound to selected application/EFSM -> atomic *.fsm.layout.json write -> response -> front`

No selected-application filesystem access is introduced in OWASYS-front.

No JavaScript is added under `sites/owasys-back`.

Layout metadata remains presentation-only. It may alter only canvas/state coordinates, transition presentation geometry and presentation markers. It never mutates STATE, SIGNAL, transition, GUARD, ACTION or runtime state.

## Generic OPUS reuse/evolution

### `OPUS_FSM_Diagram`

The existing renderer remains the single drag implementation.

Existing public setters are reused for externally supplied persisted geometry:

- `setPersistedStatePositions()`;
- `setPersistedCanvas()`;
- `setPersistedTransitionGeometry()`;
- `setPersistedMarkerGeometry()`;
- `setLayoutPersistence()`.

Only the existing layout client metadata/transport is extended so a contextual writable diagram can declare semantic `efsm_id` and canonical definition SHA-256. The generic right-drag script sends these bounded values with its existing layout request. It keeps the existing local layout path intact. Token rotation accepts both existing HTML responses and secured OWASYS JSON responses.

### `FsmDiagramLayoutStore`

The generic store gains an explicit source-bound factory for trusted backend code. This bypasses `DOCUMENT_ROOT` discovery without guessing ownership.

It also gains a transport-neutral mutation method using its existing state/coordinate/geometry normalization rules for `save-state`, `save-signal` and `save-marker`.

The existing local HTTP/CSRF behavior remains unchanged.

## OWASYS-front

### Contextual layout projection

A dedicated read-only `OwasysApplicationFsmLayoutModel` requests the selected EFSM layout through secured REST.

It never receives or invents a filesystem root. The browser does not choose a source path.

The backend response carries application id, semantic EFSM id, canonical source path/hash, derived layout path, layout direction, normalized `OPUS_FSM_DIAGRAM_LAYOUT_V4` snapshot and whether the companion file already exists.

If the companion file does not yet exist, the backend returns deterministic automatic geometry without creating a file. The first successful drag creates it.

### REST client catalog parity

`sites/owasys-front/config/rest-api.json` points to the front-owned `config/rest.resources.json`; therefore the layout GET/PUT routes must be declared there as well as in the two backend resource declarations.

R8B5D modifies all three resource catalogs and the applicator requires exact resource-list parity before any write:

- `sites/owasys-front/config/rest.resources.json`;
- `sites/owasys-back/config/backend.rest.json` inline resources;
- `sites/owasys-back/config/backend.resources.json` external catalog.

This guarantees that `RestClient::assertRequest()` accepts the new resources and that the front/back catalog fingerprints stay identical.

### `OwasysFsmDiagramBuilder`

The contextual builder combines the already-resolved canonical EFSM definition with the REST layout projection and renders the same generic `OPUS_FSM_Diagram` in VIEW and DESIGN.

VIEW applies saved layout but is not writable. DESIGN with existing `fsm:update` applies the same saved layout, sets writable layout client configuration, uses the existing designer CSRF token, exposes semantic `efsm_id` and definition SHA only, and restores generic STATE/SIGNAL right-drag.

### `OwasysFsmDesignerGateway`

The gateway gains one mutually-exclusive layout-request kind identified by existing `owasys_action=persist-fsm-layout` plus contextual `efsm_id`.

This interception occurs before Security/Structure controllers because current SecurityController treats every unmatched POST as a security mutation.

The gateway requires authentication, current selected application, `fsm:update`, valid semantic `efsm_id`, definition SHA, layout action, bounded geometry and existing designer CSRF token. It sends only action-specific optional fields: STATE sends `state_id/x/y`, MARKER sends `marker_id`, SIGNAL sends neither. This is required by the strict Composer request argument validator, which treats a present null field as an invalid supplied argument.

No site id or source path from the browser is authoritative. Current application remains server-owned session context; `efsm_id` is only the permitted semantic selector and the backend resolves its source through `FsmSiteLoader::resolveEfsm()`.

## OWASYS-back

A dedicated `OwasysFsmLayoutCommandProvider` owns contextual EFSM layout read/write.

REST resources:

- `GET /api/v1/applications/{site_id}/fsm/layouts/{efsm_id}` -> `fsm.layout.read`;
- `PUT /api/v1/applications/{site_id}/fsm/layouts/{efsm_id}` -> `fsm.layout.write`.

Composer public scripts in root `composer.json`:

- `owasys:fsm-layout-read` -> `Opus\\Composer\\ComposerScripts::run`;
- `owasys:fsm-layout-write` -> `Opus\\Composer\\ComposerScripts::run`.

Application aliases/commands:

- `owasys:fsm-layout-read` -> `owasys:fsm:layout-read`;
- `owasys:fsm-layout-write` -> `owasys:fsm:layout-write`.

Read roles: admin/developer/viewer. Write roles: admin/developer.

The provider validates actor/ACL, resolves `site_id + efsm_id` through `FsmSiteLoader::resolveEfsm()`, reads the canonical definition through File/StructuredFileLoader, derives the companion layout path, preserves an existing valid layout direction, binds `FsmDiagramLayoutStore` explicitly to that source, computes deterministic geometry using generic `OPUS_FSM_Diagram`, returns missing layout without creating it on read, checks optimistic source SHA before writes, mutates only bounded presentation geometry, atomically writes the companion file, returns source/layout hashes, and emits metadata-only Profiler events.

## Portable file naming

The companion path is derived only on the backend from canonical EFSM source:

- `config/application.fsm.json` -> `config/application.fsm.layout.json`;
- `config/security.fsm.json` -> `config/security.fsm.layout.json`;
- `config/fsm.json` -> `config/fsm.layout.json`.

No browser-authored source path is accepted. An existing companion direction is preserved; this prevents the committed vertical `owasys-front/config/fsm.layout.json` from being silently rewritten horizontal.

## R8B5C baseline observation

Current OPUS commit `0a0805ae0a9e0981c80f1304ea167bab4740afe1` contains the intended R8B5C `NavigationBuilder.php` change plus a committed `sites/owasys-front/config/fsm.layout.json` update. R8B5D treats both as authoritative baseline and does not reset them.

## Exact R8B5D source surface

Expected differential: **17 paths = 13 modified + 4 new**.

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

## Final delivery artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b5d_contextual_efsm_remote_layout_persistence.zip`;
- ZIP SHA-256: `502d26a7113ef874f3af9452d2349f2b3c88f39976e82b55ed76222394d66dab`;
- applicator: `apply_a4bz2r8b5d.php`;
- applicator SHA-256: `beb4b65f17abadcc9410de6d6f77cc569b3eba12efcacd80e49d9c4023b50ac7`;
- applicator size: 72890 bytes;
- ZIP contains exactly one applicator.

The earlier pre-final artifact with ZIP SHA `3159708ab154e9e27757cbd3e56e4fdeea2dc762e505b0b0a1e4fb171fffde9e` is superseded and must not be delivered/applied because it omitted the front REST client resource catalog.

## Acceptance gates

### Static/repository enforced by applicator

- exact baseline `0a0805ae0a9e0981c80f1304ea167bab4740afe1`;
- exact target blobs checked, including front REST client catalog blob `16f7286df9bd105a17b0c3e5a963e48a94413b6a`;
- clean worktree/index and no untracked paths before apply;
- PHP parse/lint all changed/new PHP before write and after write;
- changed JSON parsed before write and loaded through `StructuredFileLoader` after write;
- exact differential inventory = 13 tracked modified + 4 new;
- front/back REST resource catalog parity before write;
- `git diff --check` PASS;
- no JS/TS/Node/package artifact under `sites/owasys-back`;
- no new layout-specific ACL permission;
- admin/developer write path uses `fsm:update`;
- viewer layout read only;
- no deletion-policy change for OWASYS;
- a temporary out-of-repository smoke executes the new source-bound `FsmDiagramLayoutStore` and persists one STATE then one SIGNAL geometry;
- `composer dump-autoload -o` PASS;
- `composer opus:validate-site -- owasys-front` PASS;
- `composer opus:validate-site -- owasys-back` PASS;
- `composer opus:validate-site -- essai` PASS;
- post-write failure rolls source differential back and exits non-zero.

### Runtime owner acceptance

Using a selected generated application such as `essai`:

1. open Structure DESIGN (`efsm_id=navigation`);
2. right-button drag one STATE; geometry moves live and persists;
3. reload; STATE remains at saved position;
4. right-button drag one SIGNAL card; geometry moves live and persists;
5. reload; SIGNAL remains at saved position;
6. repeat in Security DESIGN (`efsm_id=security`);
7. companion files are created only in the selected application with canonical derived names;
8. VIEW uses the saved layout but is not writable;
9. viewer can read saved layout but cannot persist a drag;
10. admin can perform the same layout modifications when `owasys-front` or `owasys-back` is selected where the contextual EFSM exists;
11. Sources + Git remains functional and sees created companion files;
12. front/back Logger/Profiler show secured REST/Composer layout operations without secrets;
13. no selected-application filesystem access occurs from OWASYS-front;
14. existing R8B5 COMMAND/EVENT Security handshake and reauthentication ownership remain unchanged.
