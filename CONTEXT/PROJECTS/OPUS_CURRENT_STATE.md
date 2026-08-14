# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-14.

## Dépôt canonique

OPUS master : `de6c8e74985f690f18e77ea701555712aa598c24` — `opus_p117w_r45d2a25f_principal_column_consolidation`.

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
- gardes de mutation toujours dérivées de `$canMutate`, aucun contrôle de mutation en viewer.

## État courant observé

- 1 Utilisateur : `steve`, actif, rôle `admin` ;
- 0 Agent ;
- 1 identité legacy restante : `home`.

## Audit des autres vues Security

Le backend actuel est encore additif pour les autres objets :

- `role.create` ;
- `permission.grant` ;
- `assignment.grant` ;
- `resource.allow`.

Le contrat Security exige notamment la révocation d'une attribution de rôle, la suppression d'un rôle seulement lorsqu'il n'est plus attribué, et la suppression/retrait de permissions sans perte du dernier administrateur.

## Gate actif

R45D2A26 — Assignment Revoke Backend.

Livrable : `opus_p117w_r45d2a26_assignment_revoke_backend.zip`.
SHA-256 : `96b896192ee40bb6f198a63f1ff47e5c50cfb3417fbb9c18b012745930530555`.

Objectifs : `assignment.revoke`, perte d'accès explicite en Preview, commit atomique, refus de retirer le dernier administrateur effectif. Aucune UI dans cet incrément.
