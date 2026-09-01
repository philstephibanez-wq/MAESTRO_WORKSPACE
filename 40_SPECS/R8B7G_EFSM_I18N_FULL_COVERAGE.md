# R8B7G — Couverture I18n complète des EFSM OWASYS front + back

Date: 2026-09-01
Baseline GitHub OPUS relue: `1034e0b7cc0bb323219458dbf08b07cf8843c316` (`R8B7C`).

## Autorités

Application stricte de `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` et `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md`.

## Décision owner

Toutes les traductions visibles des états et transitions EFSM de `owasys-front` et `owasys-back` sont à la charge du chat MAESTRO.

## Contrat

1. Chaque EFSM visible possède des libellés I18n pour chaque `state` et chaque `transition`.
2. Les IDs techniques restent strictement inchangés et ne sont jamais traduits.
3. La clé canonique d'état est `fsm.<efsm_id>.state.<state_id>.label`, sauf `label_key` explicite dans la définition.
4. La clé canonique de transition est `fsm.<efsm_id>.transition.<transition_id>.label`, sauf `label_key` explicite.
5. Les catalogues sont exacts par locale régionale. Aucun fallback, aucun `inherits`, aucune langue de base substituée, aucun fallback français.
6. Une traduction manquante doit rester explicitement visible sous forme `⚠ <id>`; le livrable R8B7G doit faire disparaître ces marqueurs pour toutes les clés EFSM livrées.
7. Les géométries `*.fsm.layout.json` sont hors périmètre et ne doivent jamais être écrasées.
8. `owasys-back` reste PHP-only absolu; le livrable I18n n'ajoute aucun artefact JavaScript.

## Inventaire GitHub relu

### owasys-front

EFSMs contractuels relus:
- `config/navigation.fsm.json`
- `config/security.fsm.json`
- `config/registry.fsm.json`
- `config/application.fsm.json`
- `config/data.fsm.json`
- `config/source.fsm.json`
- `config/git.fsm.json`
- `config/build.fsm.json`

La navigation hôte contient les états `registry`, `application`, `data`, `navigation`, `security`, `source`, `build` et leurs transitions `navigation.open.*` / `navigation.context.*.ready`.

### owasys-back

EFSMs contractuels relus:
- `config/fsm.json` (EFSM navigation/exécution backend)
- `config/security.fsm.json`

L'EFSM backend principale contient les états `begin`, `api`, `security`, `composer`; l'EFSM sécurité contient `anonymous`, `authenticating`, `authenticated`, `reauthenticating`.

## Locales

`owasys-front` expose actuellement 38 locales régionales, incluant `en-EN`.
`owasys-back` déclare actuellement 37 locales et n'inclut pas encore `en-EN`; cette divergence est une non-conformité à traiter dans la séquence NO-FALLBACK, sans créer de fallback.

Pour R8B7G, les traductions exactes nécessaires à l'affichage des EFSM devront exister pour toutes les locales front exposées, y compris lorsqu'une EFSM de `owasys-back` est projetée depuis le front.

## Critères d'acceptation

- aucune clé EFSM state/transition du périmètre ne manque dans les catalogues exacts livrés;
- aucun `inherits` ajouté;
- aucune modification de layout;
- JSON valide;
- runtime front sans 500;
- projection EFSM front et back sans marqueur `⚠ <id>` pour les éléments couverts;
- `git diff --check` propre.
