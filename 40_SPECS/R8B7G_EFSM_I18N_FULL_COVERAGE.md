# R8B7G — Couverture I18n complète des EFSM OWASYS front + back

Date: 2026-09-01
Baseline GitHub OPUS relue: `6f4ed3c5e1dbd8cda3c9da2c7a459b367963227e` (`R8B7F`).

## Autorités

Application stricte de `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` et `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md`.

## Décision owner

Toutes les traductions visibles des états et transitions EFSM de `owasys-front` et `owasys-back` sont à la charge du chat MAESTRO.

## Contrat

1. Chaque EFSM visible possède des libellés I18n pour chaque `state` et chaque `transition`.
2. Les IDs techniques restent strictement inchangés et ne sont jamais traduits.
3. La clé canonique d'état est `fsm.<efsm_id>.state.<state_id>.label`, sauf `label_key` explicite dans la définition.
4. La clé canonique de transition est `fsm.<efsm_id>.transition.<transition_id>.label`, sauf `label_key` explicite.
5. Les 38 locales régionales exposées par `owasys-front`, y compris `en-EN`, matérialisent explicitement toutes les clés EFSM du front.
6. Les mêmes 38 locales matérialisent explicitement les clés EFSM de `owasys-back` afin qu'une projection du back depuis le front utilise toujours la locale exacte active.
7. La résolution EFSM est strictement locale exacte: aucun parent, aucune langue de base, aucun fallback français. Les métadonnées `inherits` historiques des catalogues UI front sont hors périmètre de cette tranche et ne sont ni utilisées ni ajoutées par la résolution EFSM; leur suppression globale reste dans l'audit NO-FALLBACK.
8. Une traduction EFSM manquante reste visible sous forme `⚠ <id>`; R8B7G doit éliminer ces marqueurs pour toutes les clés couvertes.
9. Les géométries `*.fsm.layout.json` sont hors périmètre et ne doivent jamais être modifiées.
10. `owasys-back` reste PHP-only absolu; le livrable I18n n'ajoute aucun artefact JavaScript.

## Inventaire GitHub relu

### owasys-front

EFSMs contractuels:
- `config/navigation.fsm.json`
- `config/security.fsm.json`
- `config/registry.fsm.json`
- `config/application.fsm.json`
- `config/data.fsm.json`
- `config/source.fsm.json`
- `config/git.fsm.json`
- `config/build.fsm.json`

Couverture calculée: **146 clés EFSM** (states + transitions) par locale exacte.

### owasys-back

EFSMs contractuels:
- `config/fsm.json` projeté comme EFSM `navigation`;
- `config/security.fsm.json`.

Couverture calculée: **26 clés EFSM** (states + transitions) par locale exacte.

## Locales et fichiers

- 38 catalogues régionaux front mis à jour;
- 38 catalogues régionaux back livrés, y compris `en-EN` pour la projection exacte depuis le front;
- total du ZIP R8B7G: **76 fichiers JSON**;
- aucun fichier FSM ou layout dans le ZIP.

## Critères d'acceptation

- 146/146 clés front présentes et non vides dans chacun des 38 catalogues front;
- 26/26 clés back présentes et non vides dans chacun des 38 catalogues back;
- JSON valide;
- aucun layout modifié;
- aucun ID technique traduit;
- runtime front sans 500;
- Navigation/Security/Registry/Application/Data/Source/Git/Build sans `⚠ <id>` pour les éléments OWASYS couverts;
- projection EFSM du back sans `⚠ <id>` dans les locales couvertes;
- `git diff --check` propre.
