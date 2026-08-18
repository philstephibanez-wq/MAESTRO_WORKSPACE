# P117W R45B2A4BC — FSM Menu Context Visibility

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

Owner OPUS HEAD:

`0f1356ee479336202518b253836f5a48bdc098af` — `opus_p117w_r45b2a4bb_application_fsm_resource_surface`

A4BB is owner committed/pushed and is the exact source baseline.

## Owner evidence

On the authenticated Applications screen with no current application selected, the top FSM navigation still shows:

- `Connexion`;
- internal creation states such as `Application`, creation `Sécurité`, `Récapitulatif`, `Créer l'application`, `Création impossible`, `Résultat généré`;
- current-application modules (`Sources de données`, `Structure`, application `Sécurité`, `FSM`, `Sources et Git`, `Construction et validation`) as disabled references.

The owner contract is:

- `Création impossible` and all creation workflow/result states have no place in the permanent menu;
- once an application is selected or created, every permanent application module allowed by ACL must be present in the menu.

## Root cause

Two independent facts were conflated in the menu projection:

1. `config/fsm.json` declared internal creation workflow/result states with `navigation.visible = true` although those states are runtime/diagram states, not permanent navigation destinations.
2. `OwasysNavigationBuilder` copied configured visibility without contextualizing it with authentication and `requires_current_app`, so unavailable application modules were still rendered as disabled menu references and login stayed visible after authentication.

The FSM topology itself is not wrong and must not be altered to fix this UI projection.

## Contract

A canonical FSM state may exist in runtime and diagram without being a permanent menu item.

Permanent menu projection is determined from canonical FSM metadata plus runtime context:

- configured `navigation.visible = false` => never projected as permanent navigation;
- `requires_current_app = true` => projected only while a current application exists;
- `login` => projected only before authentication;
- ACL deny => not projected;
- FSM states/transitions remain unchanged in the diagram regardless of menu visibility.

Expected contexts:

### Unauthenticated

`Connexion`

### Authenticated, no current application

- `Applications`
- `Compte`
- `Changer le mot de passe`

### Creation workflow active

The wizard states remain in the FSM/diagram and are operated by their SCORE controls/signals, but are not permanent top-menu items. Permanent navigation remains:

- `Applications`
- `Compte`
- `Changer le mot de passe`

### Current application selected or created

All ACL-allowed permanent modules are present:

- `Applications`
- `Sources de données`
- `Structure`
- `Sécurité`
- `FSM`
- `Sources et Git`
- `Construction et validation`
- `Compte`
- `Changer le mot de passe`

## Implementation

### `sites/owasys-front/config/fsm.json`

Set `navigation.visible = false` only for these internal states:

- `creation_basics`
- `creation_security`
- `creation_review`
- `application_creating`
- `application_creation_failed`
- `application_created`

No state, signal, transition, guard, action, rank, order, route or topology change.

### `sites/owasys-front/application/default/services/NavigationBuilder.php`

Keep configured visibility as the source declaration, then project it through runtime context:

- hide `requires_current_app` items when there is no current app;
- hide `login` once an identity is authenticated;
- keep ACL filtering;
- do not change guarded signal actionability, GET/POST bindings, origin semantics, global rails or self-loop handling.

## Delivery

Artifact:

`opus_p117w_r45b2a4bc_fsm_menu_context_visibility.zip`

SHA-256:

`93d1ee3c7f36e0adc940422cf1c33c083da32dcd20160840d22ade7678115a0c`

Exactly two complete files:

1. `sites/owasys-front/config/fsm.json`
2. `sites/owasys-front/application/default/services/NavigationBuilder.php`

## Source integrity

Exact owner A4BB source blobs used before modification:

- `config/fsm.json` Git blob: `220b9f83bdd669cbf23e346ded0d94f4ebcb8d7c`;
- `NavigationBuilder.php` Git blob: `6995b099c7940e782441b7f9527cef2f8996c85d`.

Local extraction from prior owner artifacts reproduced both Git blob hashes exactly before the A4BC edits.

## Validation

- `php -l NavigationBuilder.php`: OK;
- JSON parse `fsm.json`: OK;
- no trailing whitespace;
- source diff limited to six `navigation.visible` flags and navigation visibility context calculation/comments;
- smoke result: `A4BC_SMOKE_OK`;
- smoke verified unauthenticated, authenticated/no-app, active creation, selected-app and freshly-created-app contexts;
- ZIP contains exactly two complete files plus directory entries.

No controller, SCORE template, CSS, REST, backend, ACL, source, Git, Composer, profiler or JavaScript change.
