# OPUS P117W R45D2A25F — Principal Column Consolidation

Date : 2026-08-14

## Base OPUS publiée

`bf2d62fd3f3d7f7eea66d0bb0369d232e15c0474` — `opus_p117w_r45d2a25e_security_identity_actions_compact_alignment`.

## Cause

Dans la vue Security / Identités, les formulaires de création Utilisateur et Agent sont rendus dans un bloc `ow-security-quick-actions` extérieur aux colonnes qui listent les Utilisateurs et Agents. L’interface présente donc deux cadres visuellement concurrents pour une même catégorie : créer puis lister.

## Contrat cible

- une seule colonne/carte `Utilisateurs` contenant : compteur, création si autorisée, puis liste des utilisateurs ;
- une seule colonne/carte `Agents` contenant : compteur, création si autorisée, puis liste des agents ;
- suppression du bloc extérieur `ow-security-quick-actions` et de son CSS devenu mort ;
- réutilisation des formulaires SCORE `identity.reference` existants, sans changement backend/REST/FSM/ACL ;
- maintien strict de la garde `security.identity_reference_supported`, elle-même dérivée de `$canMutate` : aucun contrôle Ajouter en viewer ;
- maintien des gardes `identity_update_supported` et `identity_delete_supported` ;
- zéro JavaScript.

## Livrable

```text
ZIP     : opus_p117w_r45d2a25f_principal_column_consolidation.zip
SHA-256 : 3038c9ec4a2d69b4b6d1d475291ffcdcf66a51d70242fc2c55e78bd441270e67
BASE    : bf2d62fd3f3d7f7eea66d0bb0369d232e15c0474
FILES   : 2
```

## Gate attendu

En admin/developer : un seul cadre Utilisateurs et un seul cadre Agents ; le contrôle de création est interne à la colonne correspondante. En viewer : mêmes listes en lecture seule mais aucun Ajouter / Classifier / Modifier / Supprimer.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
