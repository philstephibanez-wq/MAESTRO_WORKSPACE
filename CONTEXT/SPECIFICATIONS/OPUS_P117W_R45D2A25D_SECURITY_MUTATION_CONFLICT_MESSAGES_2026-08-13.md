# OPUS P117W R45D2A25D — Security Mutation Conflict Messages

Date : 2026-08-13

## Cause

OWASYS back renvoie des codes métier précis pour les conflits Security, mais le front affiche encore le générique `security.mutation_error` sauf pour quelques cas particuliers.

Incident navigateur validant le besoin : tentative de création d'une identité déjà existante (`steve`) refusée correctement, mais sans message utilisateur spécifique alors que le backend renvoie `OWASYS_SECURITY_IDENTITY_ALREADY_REFERENCED`.

## Contrat

R45D2A25D spécialise côté front SCORE les conflits métier suivants :

- `OWASYS_SECURITY_IDENTITY_ALREADY_REFERENCED` ;
- `OWASYS_SECURITY_IDENTITY_NOT_FOUND` ;
- `OWASYS_SECURITY_IDENTITY_UPDATE_UNCHANGED` ;
- `OWASYS_SECURITY_ROLE_ALREADY_EXISTS` ;
- `OWASYS_SECURITY_ASSIGNMENT_ALREADY_EXISTS` ;
- `OWASYS_SECURITY_PERMISSION_ALREADY_GRANTED`.

Chaque code garde son détail technique mais reçoit un message I18n explicite dans les 25 langues de base.

Aucune modification backend, REST, ACL, FSM ou JavaScript.

## Base OPUS

`05c0075027ac5818fb6960680e390721fa028b3f` — `opus_p117w_r45d2a25c_unclassified_metric_navigation`.

## Livrable

`opus_p117w_r45d2a25d_security_mutation_conflict_messages.zip`

SHA-256 : `77a30e0fa65ef7460aa3c60056c6eace391008175b521e2109b6ed4a4be808a7`

## Gate

- applicateur : `OPUS_R45D2A25D_APPLIED locales=25` ;
- smoke : `OPUS_R45D2A25D_SECURITY_MUTATION_CONFLICT_MESSAGES_OK locales=25` ;
- navigateur français : une nouvelle tentative de création de `steve` affiche `Cette identité existe déjà dans l’application.` ;
- le détail technique conserve `OWASYS_SECURITY_IDENTITY_ALREADY_REFERENCED`.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
