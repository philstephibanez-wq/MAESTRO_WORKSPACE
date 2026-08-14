# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-14

## Lecture obligatoire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_2026-08-13.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25_IDENTITY_LIFECYCLE_UI_2026-08-13.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25F_PRINCIPAL_COLUMN_CONSOLIDATION_2026-08-14.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A27_ASSIGNMENT_REVOKE_UI_2026-08-14.md`
9. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base OPUS publiée

`9256f6dd4837a5465f801018368113fa0a740499` — `opus_p117w_r45d2a26_assignment_revoke_backend`.

## Gates acquis — lifecycle Identités

- routes frontend localisées avec accents ;
- backend `identity.update` / `identity.delete` avec Preview/Commit ;
- exposition SCORE lifecycle admin/developer ;
- navigation métrique `À classifier` ;
- suppression réelle d'une identité legacy validée ;
- classification réelle `unknown -> user` validée sur `steve`, rôle `admin` conservé ;
- conflits métier Security localisés explicitement ;
- protection de la dernière identité administrative validée : suppression de `steve` refusée avant écriture ;
- actions Modifier/Supprimer compactes ;
- un seul cadre Utilisateurs et un seul cadre Agents, création intégrée à la liste ;
- contrôles de mutation dérivés de `$canMutate`, donc aucun contrôle de mutation en viewer.

## Gates acquis — Attributions backend

R45D2A26 est publié. Le backend supporte maintenant :

- `assignment.grant` ;
- `assignment.revoke` ;
- Preview `access_delta.lost` ;
- commit atomique sur le store local ;
- refus de révoquer la dernière attribution administrative effective.

## État navigateur courant

- 1 Utilisateur : `steve`, état `active`, rôle `admin` ;
- 0 Agent ;
- 1 identité legacy restante : `home`.

## Gate actif

R45D2A27 — Assignment Revoke UI :

- exposer `assignment_revoke_supported` côté front uniquement sous `$canMutate` ;
- action SCORE `Révoquer` sur les attributions locales réellement modifiables ;
- motif + réauthentification ;
- Preview puis confirmation/Commit via pipeline existant ;
- affichage explicite des accès perdus ;
- messages localisés pour attribution absente, identité absente et protection de la dernière attribution administrative ;
- 25 locales : langues de l’Union européenne + ukrainien ;
- aucun bouton Révoquer en viewer ;
- aucun changement REST/FSM ;
- zéro JavaScript.

Livrable : `opus_p117w_r45d2a27_assignment_revoke_ui.zip`.
SHA-256 : `828836dea799d75296463fa676dcf52a80b37c816f22bfb4cab883e42f662611`.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
