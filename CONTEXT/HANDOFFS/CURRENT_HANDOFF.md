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
10. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A28B_SECURITY_GRAPHICAL_PRIMARY_NAVIGATION_2026-08-14.md`
11. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base OPUS publiée

`f61382ea8e8c2e590176e25ef98208a7ff8ceaee` — `opus_p117w_r45d2a28a_security_view_isolation_fragment_elimination`.

R45D2A28 et R45D2A28A sont publiés et validés navigateur.

## Gates acquis — Security

- routes principales et sous-vues Security localisées ;
- français : `/sécurité/identités`, `/sécurité/rôles`, `/sécurité/permissions`, `/sécurité/attributions`, `/sécurité/ressources-et-acl` ;
- aucune query technique `?view=...` générée en navigation normale ;
- suppression du fragment historique `#ow-security-unclassified` ;
- une seule sous-vue métier rendue à la fois ;
- lifecycle Identités Preview/Commit ;
- assignment grant/revoke Preview/Commit ;
- protections dernière identité administrative et dernière attribution administrative ;
- UI mutation strictement sous `$canMutate`, viewer lecture seule ;
- zéro JavaScript Security pour le routage/navigation métier.

## Défaut UX observé

La chaîne graphique Security existe, mais elle ressemble encore à une rangée de liens secondaires. En particulier, la présence et le rôle de `Rôles` ne sont pas suffisamment évidents depuis `/sécurité`.

De plus, les rubriques `Rôles`, `Permissions`, `Attributions` et `Ressources & ACL` sont des `<details>` fermés : un clic sur le maillon change la route mais ne déplie pas immédiatement la rubrique attendue.

## Gate actif

R45D2A28B — Security Graphical Primary Navigation :

- `/sécurité` devient une vraie vue d'ensemble graphique ;
- chaîne métier visible : Utilisateur/Agent -> Identité -> Attribution -> Rôle -> Permission -> Ressource/Action -> ACL ;
- navigation persistante : Identités, Attributions, Rôles, Permissions, Ressources & ACL ;
- chaque maillon possède icône, libellé, compteur et lien localisé ;
- maillon courant marqué visuellement + `aria-current="page"` ;
- clic sur un maillon -> route localisée -> rubrique correspondante rendue immédiatement ouverte (`open`) ;
- une seule rubrique métier détaillée rendue à la fois ;
- retour graphique Vue d'ensemble ;
- métriques Utilisateurs/Agents/Rôles/Ressources navigables ;
- aucune query anglaise ni fragment URL ;
- changement de langue conserve la sous-vue ;
- SCORE + CSS + rendu serveur uniquement ;
- aucune modification REST/backend/ACL/FSM ;
- aucune mutation supplémentaire viewer.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
