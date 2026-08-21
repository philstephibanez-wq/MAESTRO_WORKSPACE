# P117W R45B2A4BW — Registry compaction and FSM height reduction

State: DELIVERABLE READY — OWNER APPLY + RUNTIME VALIDATION REQUIRED

## Preconditions

README-FIRST is authoritative.

A4BW is a follow-up to A4BV and requires the A4BV deletion semantics to be present in the local OPUS tree before it writes anything:

- user signal `begin_application_deletion` exists;
- `t_delete_begin` is the operational registry self-loop;
- `t_delete_app` uses `clear_deleted_app_context`;
- `g_delete_current_application` targets `registry`.

The owner GitHub `master` may still show A4BU until A4BV is committed/pushed; A4BW therefore validates the local semantic baseline instead of assuming a new Git commit SHA.

## Cause 1 — Registry deletion controls outside the useful card height

The current registry CSS applies these selectors to every form/button inside an application tile:

```css
.ow-tree-app form { height: 100%; }
.ow-tree-app button { ... height: 100%; ... min-height: 154px; }
```

The tile contains two distinct forms:

1. application selection;
2. deletion confirmation (`.ow-delete-form`).

The broad selectors therefore force the deletion form/button into the same full-height card rules intended only for the selection surface. The result is excessive tile height and the confirmation field/button being pushed below the visible viewport.

### A4BW correction

- selection height/button rules are scoped to `form:not(.ow-delete-form)` only;
- deletion form keeps natural height;
- deletion confirmation input and button receive a dedicated compact SCORE-compatible layout;
- mobile layout collapses the delete form to one column;
- no template-side HTML/PHP workaround is introduced.

This treats the selector-scope cause rather than adding viewport hacks.

## Cause 2 — FSM diagram vertically over-expanded

The generic OWASYS FSM CSS deliberately gives the vertical diagram no independent vertical viewport: document height follows the persisted EFSM geometry. Therefore reducing CSS height, clipping, adding a scroll container or applying `zoom` would only hide/scale the symptom.

The canonical persisted layout currently carries an approximately 2970 px canvas and correspondingly spread vertical Y geometry.

### A4BW correction

The existing generic OPUS persisted-layout capability is sufficient; no local renderer fork is introduced.

A4BW applies an exact vertical geometry factor of `2/3` (~33.3% reduction) to persisted diagram geometry:

- `canvas.height`;
- persisted `y` / `*_y` coordinates;
- Y coordinates inside persisted transition `path` and `leader_path` values;
- persisted state/transition/signal/marker geometry where present.

Horizontal X geometry, node sizes, signal semantics, guards, actions and FSM topology are unchanged.

On the current 2970 px canvas, expected height is 1980 px.

The layout `definition_sha256` remains unchanged because A4BW does not modify `fsm.json`; the applicator first verifies that the stored definition hash matches the exact current FSM bytes.

## Generic OPUS rule

README-FIRST requires proposing a generic OPUS evolution before a local non-business workaround.

No new generic framework API is needed here because OPUS already owns persisted FSM geometry generically. A4BW changes only the OWASYS persisted geometry data through that existing contract. It does not add CSS zoom, renderer special-casing or an OWASYS-only diagram engine.

## Differential targets

A4BW changes only:

- `sites/owasys-front/www/asset/css/owasys.css`
- `sites/owasys-front/config/fsm.layout.json`

No backend file changes.
No JavaScript changes.
No FSM semantic changes.
No SCORE template changes.
No REST/Composer changes.
No ACL/SSO changes.

## Baseline guards

CSS exact expected Git blob before A4BW:

`2c3992c9abbf0eebedae4979b12c979d88258c9a`

FSM layout is guarded semantically rather than by an exact blob so the owner may retain the A4BV layout hash/transition update and any still-compatible persisted positions. Required conditions:

- contract `OPUS_FSM_DIAGRAM_LAYOUT_V4`;
- direction `vertical`;
- `fsm_path = config/fsm.json`;
- `definition_sha256` matches exact current `fsm.json` bytes;
- current canvas height is in the pre-compaction range 2400..4000 px;
- A4BV FSM deletion semantics are present.

A second application is refused because the compacted canvas falls outside the pre-compaction range.

## Delivery

Artifact:

`opus_p117w_r45b2a4bw_registry_compaction_and_fsm_height.zip`

ZIP SHA-256:

`31a4c5e42fb3182b4d0534a44e37b34a2e5328029441e2a034175343d7825ddc`

Contained one-shot applicator:

`apply_a4bw.php`

Applicator SHA-256:

`f3d66a932deaa9160d4536a4f54052ce9857fbc4e8f69f5c263c25b29768a8f4`

Applicator lint: OK under PHP 8.4.23.

## Runtime acceptance

After apply:

1. `composer opus:validate-site -- owasys-front` remains valid;
2. application tiles no longer stretch because of the deletion form;
3. for every deletable generated application, confirmation label, input and delete button are immediately visible beneath the selection surface;
4. delete behavior remains exactly A4BV;
5. FSM diagram is approximately one third shorter while keeping its horizontal placement and readability;
6. current persisted drag geometry remains proportionally preserved;
7. no vertical clipping, CSS zoom or nested diagram scroll viewport is introduced;
8. diagram/menu signal origin/actionability behavior is unchanged.
