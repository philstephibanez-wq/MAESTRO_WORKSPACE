# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-14.

## Dépôt canonique

OPUS master : `9256f6dd4837a5465f801018368113fa0a740499` — `opus_p117w_r45d2a26_assignment_revoke_backend`.

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

## Acquis Attributions backend

R45D2A26 est publié et ajoute :

- `assignment.revoke` ;
- capacité `assignment_revoke` ;
- Preview avec `access_delta.lost` ;
- commit atomique sur le store local ;
- refus si la révocation supprimerait la dernière attribution administrative effective.

## État courant observé

- 1 Utilisateur : `steve`, actif, rôle `admin` ;
- 0 Agent ;
- 1 identité legacy restante : `home`.

## Audit des autres vues Security

Identités dispose maintenant du lifecycle attendu. Attributions possède le backend grant/revoke, mais la révocation doit encore être exposée dans le front. Rôles, Permissions et Ressources restent à compléter ensuite pour atteindre le workflow contractuel complet de modification/suppression.

## Gate actif

R45D2A27 — Assignment Revoke UI.

Livrable : `opus_p117w_r45d2a27_assignment_revoke_ui.zip`.
SHA-256 : `828836dea799d75296463fa676dcf52a80b37c816f22bfb4cab883e42f662611`.
Base : `9256f6dd4837a5465f801018368113fa0a740499`.

Objectifs : action SCORE `Révoquer` uniquement sur une attribution locale réellement modifiable, motif + réauthentification, Preview/Commit existants, accès perdus explicites, messages métier localisés et zéro action de mutation en viewer.
