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
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A28_SECURITY_LOCALIZED_VIEW_ROUTES_2026-08-14.md`
10. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base OPUS publiée

`3d4b0cb06e8a825326809ce9173b6fefb36827e9` — `opus_p117w_r45d2a27_assignment_revoke_ui`.

## Gates acquis — lifecycle Identités

- routes principales frontend localisées avec accents ;
- backend `identity.update` / `identity.delete` avec Preview/Commit ;
- exposition SCORE lifecycle admin/developer ;
- navigation métrique `À classifier` ;
- suppression réelle d'une identité legacy validée ;
- classification réelle `unknown -> user` validée sur `steve`, rôle `admin` conservé ;
- conflits métier Security localisés explicitement ;
- protection de la dernière identité administrative validée ;
- actions Modifier/Supprimer compactes ;
- un seul cadre Utilisateurs et un seul cadre Agents, création intégrée à la liste ;
- contrôles de mutation dérivés de `$canMutate`, donc aucun contrôle de mutation en viewer.

## Gates acquis — Attributions

R45D2A26 et R45D2A27 sont publiés :

- backend `assignment.grant` / `assignment.revoke` ;
- Preview `access_delta.lost` ;
- commit atomique ;
- protection de la dernière attribution administrative ;
- action SCORE `Révoquer` sous capacité `assignment_revoke_supported` ;
- messages localisés ;
- aucune mutation viewer.

## Défaut observé

Les sous-vues Security restent exposées avec une query technique anglaise :

`/fr-FR/sécurité?view=assignments`

Le code courant `securityUrl()` construit `?view=<clé interne>` au lieu d'utiliser le routeur localisé OPUS.

## Gate actif

R45D2A28 — Security Localized View Routes :

- remplacer les query `?view=...` générées par des routes localisées ;
- français canonique : `/fr-FR/sécurité/identités`, `/rôles`, `/permissions`, `/attributions`, `/ressources-et-acl` sous le préfixe `/fr-FR/sécurité/` ;
- 25 langues de base, variantes régionales héritées ;
- les clés internes anglaises restent internes ;
- ancien `?view=...` accepté en compatibilité et redirigé en GET ;
- changement de langue conserve la sous-vue ;
- aucun changement métier Security, REST, ACL ou FSM ;
- zéro JavaScript.

Livrable : `opus_p117w_r45d2a28_security_localized_view_routes.zip`.
SHA-256 : `814030ed1095172fc860805af861dbe9ed8c10f1fd735465d6001de9a75faba6`.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
