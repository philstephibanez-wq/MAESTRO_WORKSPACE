# MAESTRO_WORKSPACE HANDOFF — OWASYS P117O-R1

Date: 2026-07-23
Status: differential ZIP prepared; static and synthetic validation complete; target-browser validation pending
Source OPUS head: `f7bf7bf89eaa85e1bc2e90b2cbc1dcfe669ec2dd` (`p117n_r5`)

## Purpose

P117O-R1 supersedes the uncommitted P117O navigation delivery. In OWASYS, navigation is one contractual subsystem with two synchronized representations:

- the horizontal SCORE menu;
- the interactive Mermaid FSM diagram.

Both representations must be generated from the same FSM states, the same regional URLs, the same SSO identity and the same ACL/FSM availability projection.

## Confirmed regression

The regionalization work did not break the Mermaid renderer. The Mermaid framework component and the OWASYS Mermaid client were unchanged from the previously working version.

The regression was in the navigation ViewModel. `OwasysNavigationBuilder` projected only ACL authorization into `item.allowed`. It did not project the FSM `requires_current_app` guard. As a result, when no application was selected:

- Structure, Data, Workflows, Security and Source were displayed as clickable in the menu;
- the same states were wrapped as clickable links in the Mermaid diagram;
- the runtime FSM then correctly rejected the transition with `current_app_required`;
- OWASYS redirected back to Applications, making both navigation representations appear non-functional.

## Corrected projection

Every visible FSM navigation state now carries two distinct booleans:

- `allowed`: ACL authorization for `<module>:open`;
- `available`: ACL authorization plus satisfaction of the FSM `requires_current_app` guard.

Rules:

- ACL-denied states are absent from both representations;
- ACL-allowed and FSM-available states are interactive in both representations;
- ACL-allowed but FSM-blocked states remain visible but disabled in both representations;
- the menu and diagram receive the same regional URL for each available state;
- the current state remains highlighted in both representations.

Without a current application, the interactive states are exactly:

- Registry / Applications;
- Build.

With a current application, all seven navigation states are interactive.

## SCORE menu

The horizontal menu remains SCORE-only.

Available states are rendered as anchors. States requiring a current application are rendered as non-interactive spans with `aria-disabled="true"` until an application is selected. No fake link, JavaScript router or local fallback is introduced.

## Mermaid FSM diagram

The diagram keeps all ACL-authorized nodes visible. Guard-blocked nodes use a dedicated `blocked` Mermaid class and are omitted from `routes_json`; therefore `fsm-mermaid.js` wraps only available nodes as native SVG links.

No change is made to `Opus\Componants\Diagram\MermaidDiagram` or the generic Mermaid runtime.

`OwasysFsmMermaidBuilder` now reads `site.json` and the FSM through `Opus\File\StructuredFileLoader`, removing the remaining direct configuration reads.

## Regional URLs

The active regional locale remains part of every generated URL, for example:

- `/fr-FR/applications`;
- `/fr-BE/build`;
- `/de-CH/structure`;
- `/uk-UA/data`.

The locale resolver, browser negotiation and regional catalog inheritance are unchanged.

## Security and application contracts

The pipeline remains:

request -> regional locale -> SSO identity -> deny-by-default ACL -> FSM event/guard -> ViewModel -> SCORE menu and Mermaid diagram.

P117O-R1 adds no concrete OPUS framework class and changes no framework class. The P117M-R1 exhaustive homonymous-interface/four-marker audit remains mandatory.

No Auth0 credential, bastion bypass, application-local router, PHP view, UI `echo` or HTML/PHP mixed file is introduced.

## Delivery

Differential ZIP:

`opus_owasys_p117o_r1_menu_fsm_navigation.zip`

SHA-256:

`d2d0b7e90716418fb0a3c61c77b401a0a52210058e686d13d2a4acea29387846`

The ZIP contains eight runtime/maintenance files and no Markdown, smoke file or root-level application launcher.

No write was made to the OPUS repository. No OPUS commit is requested before target-browser validation confirms both menu and diagram behavior.

## Validation performed

- PHP syntax validation for every PHP file in the differential;
- static check of FSM, ACL, regional locale and SCORE contracts;
- synthetic navigation projection with and without a selected application;
- synthetic Mermaid route projection;
- exact no-application interactive state set: `registry`, `build`;
- exact current-application interactive state count: seven;
- regional route-prefix preservation;
- no direct `file_get_contents()` in the corrected FSM builder;
- no framework class addition.

The target Windows browser and live session/SQLite context were not executed in the artifact-generation environment.
