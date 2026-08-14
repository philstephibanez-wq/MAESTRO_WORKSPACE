# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-14.

## Dépôt canonique

OPUS master : `3d4b0cb06e8a825326809ce9173b6fefb36827e9` — `opus_p117w_r45d2a27_assignment_revoke_ui`.

## Acquis lifecycle Identités

- navigation `À classifier` validée ;
- actions Classifier/Modifier/Supprimer visibles en admin/developer ;
- suppression d'une identité legacy validée via Preview puis Commit ;
- classification `unknown -> user` validée sur `steve` ;
- rôle `admin` conservé après classification ;
- suppression du dernier administrateur refusée avant écriture ;
- messages métier Security localisés ;
- actions Modifier/Supprimer compactes ;
- un seul cadre Utilisateurs et un seul cadre Agents, avec création intégrée à la colonne ;
- gardes de mutation dérivées de `$canMutate`, aucun contrôle de mutation en viewer.

## Acquis Attributions

R45D2A26 et R45D2A27 sont publiés :

- `assignment.revoke` ;
- capacité `assignment_revoke` ;
- Preview avec `access_delta.lost` ;
- commit atomique sur le store local ;
- protection de la dernière attribution administrative ;
- action SCORE `Révoquer` uniquement sur les attributions locales modifiables ;
- messages métier localisés ;
- aucune action de révocation en viewer.

## État courant observé

- 1 Utilisateur : `steve`, actif, rôle `admin` ;
- 0 Agent ;
- 1 identité legacy restante : `home`.

## Défaut de routage Security

La route principale est correctement localisée (`/fr-FR/sécurité`), mais les sous-vues sont encore générées sous forme de query technique anglaise, par exemple :

`/fr-FR/sécurité?view=assignments`

La cause est `OwasysSecurityController::securityUrl()`, qui expose directement la clé interne au lieu d'utiliser `LocalizedRouteResolverInterface` pour chaque sous-vue.

## Gate actif

R45D2A28 — Security Localized View Routes.

Livrable : `opus_p117w_r45d2a28_security_localized_view_routes.zip`.
SHA-256 : `814030ed1095172fc860805af861dbe9ed8c10f1fd735465d6001de9a75faba6`.
Base : `3d4b0cb06e8a825326809ce9173b6fefb36827e9`.

Objectifs : cinq sous-routes Security localisées sur les 25 langues de base, URLs françaises avec accents (`identités`, `rôles`, `attributions`), aucune query `?view=` générée, compatibilité legacy avec redirection GET vers le chemin canonique, conservation de la sous-vue lors du changement de langue, aucun changement métier Security/REST/ACL/FSM et zéro JavaScript.
