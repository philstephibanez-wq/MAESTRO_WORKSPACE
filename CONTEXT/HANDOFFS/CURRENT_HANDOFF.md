# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-13

## Lecture obligatoire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_2026-08-13.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25_IDENTITY_LIFECYCLE_UI_2026-08-13.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25C_UNCLASSIFIED_METRIC_NAVIGATION_2026-08-13.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25D_SECURITY_MUTATION_CONFLICT_MESSAGES_2026-08-13.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base OPUS publiée

`05c0075027ac5818fb6960680e390721fa028b3f` — `opus_p117w_r45d2a25c_unclassified_metric_navigation`.

## Gates acquis

- routes frontend localisées avec accents ;
- lifecycle Security backend `identity.update` / `identity.delete` avec Preview/Commit ;
- exposition SCORE lifecycle admin/developer ;
- navigation métrique `À classifier` ;
- suppression réelle d'une identité legacy validée ;
- classification réelle `unknown -> user` validée sur `steve`, rôle `admin` conservé ;
- refus de doublon confirmé côté backend lors d'une tentative de recréation de `steve`.

## Incident UX actif

Le refus de doublon est correct mais l'interface n'affiche que `Mutation de sécurité refusée`. Le backend fournit pourtant le code précis `OWASYS_SECURITY_IDENTITY_ALREADY_REFERENCED`.

## Gate actif

R45D2A25D — messages explicites pour les conflits métier Security.

Livrable :

```text
ZIP     : opus_p117w_r45d2a25d_security_mutation_conflict_messages.zip
SHA-256 : 77a30e0fa65ef7460aa3c60056c6eace391008175b521e2109b6ed4a4be808a7
BASE    : 05c0075027ac5818fb6960680e390721fa028b3f
FILES   : 3
```

Gate navigateur français attendu pour doublon `steve` : `Cette identité existe déjà dans l’application.`

Après R45D2A25D, reprendre la validation finale lifecycle : protection dernière identité administrative puis recontrôle viewer sans contrôles de mutation.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
