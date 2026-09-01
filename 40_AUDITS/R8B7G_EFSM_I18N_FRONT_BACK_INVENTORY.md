# R8B7G — Inventaire I18n complet des EFSM OWASYS front + back

Date: 2026-09-01
Baseline OPUS GitHub: `6f4ed3c5e1dbd8cda3c9da2c7a459b367963227e` (`R8B7F`).

## Autorités

Appliquer intégralement `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` et `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md`.

## Décision owner

Les traductions visibles de **tous les états et de toutes les transitions EFSM** de `owasys-front` et `owasys-back` sont à la charge du chat MAESTRO.

Le chat maintient directement MAESTRO_WORKSPACE. Aucune action workspace n'est déléguée à l'owner.

## Inventaire GitHub réalisé

La lecture est faite directement sur les sources GitHub du HEAD R8B7F.

### owasys-front

EFSM canoniques prises en charge:

- `config/fsm.json` — workflow canonique front;
- `config/application.fsm.json`;
- `config/navigation.fsm.json`;
- `config/security.fsm.json`;
- `config/registry.fsm.json`;
- `config/data.fsm.json`;
- `config/source.fsm.json`;
- `config/git.fsm.json`;
- `config/build.fsm.json`.

La tranche R8B7G matérialise 251 clés exactes d'états/transitions par locale front: 105 pour `config/fsm.json` et 146 pour les micro-EFSM contextuelles.

### owasys-back

EFSM canoniques prises en charge:

- `config/fsm.json`;
- `config/security.fsm.json`.

La tranche matérialise 25 clés exactes d'états/transitions par locale back.

## Locales

- front: 38 locales exactes, dont `en-EN`;
- back avant R8B7G: 37 locales;
- R8B7G aligne le back sur les mêmes 38 locales et crée un catalogue exact pour chacune.

## Contrat de traduction

- utiliser `label_key` lorsqu'il est explicitement déclaré;
- sinon utiliser `fsm.<efsm_id>.state.<state_id>.label` et `fsm.<efsm_id>.transition.<transition_id>.label`;
- aucune résolution par parent/base/région;
- aucun `inherits` dans les catalogues livrés;
- IDs techniques inchangés;
- libellés humains concis et sémantiquement reliés aux états/transitions sources;
- aucune modification des fichiers `*.fsm.layout.json`.

## Livrable

`R8B7G.zip` contient uniquement des fichiers complets aux chemins finaux:

- 38 catalogues exacts `owasys-front/application/default/local/<locale>.json`;
- 38 catalogues exacts `owasys-back/application/default/local/<locale>.json`;
- `sites/owasys-back/config/site.json` pour aligner `en-EN` côté back.

Total: 77 fichiers de catalogues/configuration plus le `site.json` back, soit 78 fichiers dans le ZIP.

SHA-256 du ZIP: `c5818c2ac5202605ac64c96a126f13576f691ca671dae5c517c8f85013cedb6b`.

## Gate owner

Avant application du ZIP, l'owner fournit uniquement l'état OPUS local (`git rev-parse HEAD`, `git status --short`). Aucun travail MAESTRO_WORKSPACE n'est demandé.
