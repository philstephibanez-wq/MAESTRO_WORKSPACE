# P117W R45B2A4BZ2R8B4A — Contextual Security + Navigation micro-EFSM foundation

State: DELIVERY TARGET — CONSOLIDATED FROM R8B2

## Baseline

OPUS owner/master baseline:

`76b59191492f4efabf343e85be841f4832fe0ced`

`opus_p117w_r45b2a4bz2r8b2_actual_graphical_handler_authoring`

R8B4A is intentionally consolidated directly from this baseline. It supersedes the previously prepared but non-integrated R8B3 package.

## Owner evidence / diagnosed cause

The owner opened the selected application `essai` on `/fr-FR/sécurité` and still saw the large OWASYS host navigation EFSM (`begin`, `login`, `registry`, creation states, Sources, Build, etc.). The owner also reported no OPUS repository changes from the previous attempt.

Runtime logs show that the Security body itself is already correctly scoped to the selected application: the front serves `/fr-FR/sécurité`, then the back receives `GET /api/v1/applications/essai/security` and successfully executes the allow-listed `owasys:security-snapshot` Composer command.

The wrong diagram therefore is not a Security snapshot problem and is not a cache symptom. The root cause is architectural: `OwasysScorePageRenderer` injects the FSM diagram globally and the normal-view `OwasysFsmDiagramBuilder` still loads the OWASYS host navigation FSM. The prior R8B3 only changed selected-application authority in design mode; that is insufficient for the newly locked micro-EFSM architecture.

## Corrected invariant

Context ownership applies identically to VIEW and DESIGN modes.

For a selected generated application:

- Security context -> selected application `security` micro-EFSM;
- Structure context -> selected application `navigation` micro-EFSM for this first foundation slice;
- other OWASYS domains remain explicitly on the host navigation projection until their own micro-EFSM slice is delivered;
- there is no top-level user destination named FSM;
- the browser never chooses a canonical source path; only an EFSM semantic identifier can be transported and the server resolves the path from the application registry.

The same canonical definition drives view and design. Design mode adds editing; it does not switch to a different graph.

## Generic OPUS micro-EFSM registry

Generated applications gain a site-level `efsms` registry.

Frontend example:

```json
{
  "efsms": {
    "navigation": "config/application.fsm.json",
    "security": "config/security.fsm.json"
  }
}
```

Backend generation uses `rest` + `security` semantic entries instead of pretending a backend has UI navigation.

`FsmSiteLoader` gains generic named-EFSM resolution while preserving its existing default resolver for compatibility.

Pure EFSM STATE objects do not implicitly create application modules. A module participates in the directory contract only when the STATE explicitly declares `module`.

## Generated Security micro-EFSM

The scaffold generates `config/security.fsm.json` with runtime-compatible contract `OPUS_SECURITY_FSM_V1`. The architecture remains a Security micro-EFSM; the contract suffix deliberately follows the canonical OPUS runtime FSM contract grammar accepted by `FsmProcessor`.

Initial skeleton:

STATE:

- `anonymous`;
- `authenticating`;
- `authenticated`;
- `reauthenticating`.

SIGNAL:

- `login_requested`;
- `authentication_succeeded`;
- `authentication_failed`;
- `logout_requested`;
- `session_expired`;
- `reauth_required`;
- `reauthentication_succeeded`;
- `reauthentication_failed`.

The initial file is intentionally a skeleton: roles, users and providers are data/services of Security, never STATE. The existing procedural login/session runtime is not falsely claimed to have been replaced by a full inter-EFSM SignalBus in this slice.

## Navigation micro-EFSM

For a generated frontend, the existing canonical `config/application.fsm.json` becomes the registered `navigation` micro-EFSM without creating a duplicate file.

R8B4A also carries forward the canonical signal-registry repair and profiler-residue cleanup required for a valid generated definition.

The separate first Navigation view is projected in the current OWASYS `Structure` context. A later UI slice may refine the structure/navigation workspace without changing the EFSM authority contract.

## Designer authority and persistence

R8B4A carries forward and extends the R8B3 corrections:

- selected application is the authority, not OWASYS host;
- context EFSM id is explicit;
- canonical source path is server-resolved through the application EFSM registry;
- STATE create/rename/delete persists through front -> secured REST -> back -> allow-listed Composer -> generic OPUS definition editor -> atomic source write;
- browser-authored arbitrary definition/source paths are rejected by construction;
- JS initialization TDZ is removed;
- direct STATE create opens the editor instead of requiring a hidden second canvas click;
- source/hash/application/efsm are visible in the diagram authority banner.

Generated-application PHP handler authoring remains deliberately isolated in R8B4A because the existing managed handler catalog/source belongs to `owasys-front`. It must not be silently redirected to a generated application. A subsequent slice will establish the generic target-application ACTION/GUARD PHP source contract.

## Security workspace

Existing Security functionality is retained and reused, not rewritten:

- selected-application Security snapshot;
- users/identities;
- roles;
- permissions;
- assignments;
- resources/ACL;
- controlled preview/commit mutations;
- fresh-auth proof/reauthentication;
- deny-by-default ACL;
- existing SSO providers and identity normalization.

A dedicated `SSO` view is added to expose the real provider snapshot and default provider without rendering secret values.

SSO remains a provider/service concern consumed by Security actions; it is not a separate EFSM.

## Current `essai` migration

R8B4A migrates the current generated `essai` fixture/runtime target by:

- adding `site.json.efsms.navigation`;
- adding `site.json.efsms.security`;
- repairing `application.fsm.json` signal declaration/profiler residue;
- creating `config/security.fsm.json`.

After application, `/fr-FR/sécurité` for selected `essai` must no longer show the large OWASYS host FSM. It must show the small `essai / security` micro-EFSM with its canonical source/hash.

The `Structure` context must show `essai / navigation`.

## Boundaries / not claimed by R8B4A

R8B4A is the micro-EFSM authority and scaffold foundation. It does not yet claim:

- full `FsmSignalBus`/network runtime cooperation between Security and Navigation;
- SecurityContext writer/read-only interface split;
- generic generated-application ACTION/GUARD PHP managed-source authoring;
- full SSO mutation/configuration UI;
- complete split of every current OWASYS menu domain into a micro-EFSM.

Those are subsequent vertical slices and must build on this canonical named-EFSM authority.

## Validation gates

Owner acceptance requires:

1. applicator preflight marker;
2. applicator repo-change verification marker;
3. PHP lint of changed PHP;
4. JS syntax check;
5. Composer optimized autoload;
6. `opus:validate-site` for `owasys-front`, `owasys-back`, `essai`;
7. Security page visually shows `essai / security`, not host monolith;
8. Structure page visually shows `essai / navigation`;
9. Security Conception STATE create persists and survives reload;
10. no JS/Node artifact under `sites/owasys-back`;
11. Sources + Git remains unchanged functionally.
