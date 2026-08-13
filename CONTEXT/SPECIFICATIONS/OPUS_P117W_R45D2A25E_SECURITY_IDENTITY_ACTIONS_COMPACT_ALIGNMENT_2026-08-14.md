# OPUS P117W R45D2A25E — Security Identity Actions Compact Alignment

Date : 2026-08-14

## Cause

Dans les cartes Utilisateur/Agent du cockpit Security, les actions `Modifier` et `Supprimer` sont des éléments `<details>` frères placés dans `.ow-security-card-actions`, un conteneur flex.

Le conteneur ne définit pas `align-items:flex-start`. Avec le comportement flex par défaut (`stretch`), lorsqu'une action est ouverte, l'action sœur fermée est étirée à la même hauteur. Le navigateur affiche alors une grande zone vide bordée, notamment sur `Supprimer` lorsque `Modifier` est ouvert.

## Contrat

R45D2A25E corrige uniquement le layout SCORE/CSS :

- `.ow-security-card-actions` aligne ses enfants sur le début de l'axe transversal ;
- chaque `.ow-security-inline-action` reste à sa hauteur intrinsèque lorsqu'il est fermé ;
- ouvrir `Modifier` ne doit plus étirer `Supprimer`, et inversement ;
- aucune modification backend, REST, ACL, FSM, I18n ou JavaScript ;
- aucune modification des capacités admin/developer/viewer ;
- aucune modification des formulaires Preview/Commit.

## Base OPUS

`9ce171a56412d4b1142cdbed89b11f99ea0b9709` — `opus_p117w_r45d2a25d_security_mutation_conflict_messages`.

## Livrable

`opus_p117w_r45d2a25e_security_identity_actions_compact_alignment.zip`

SHA-256 : `c876a1b47de8a666e220bff8c822b2d7ffdd749e40326e1d62c785b387b5af9e`

Fichiers : 2.

## Gate

- applicateur : `OPUS_R45D2A25E_APPLIED` ;
- smoke : `OPUS_R45D2A25E_SECURITY_IDENTITY_ACTIONS_COMPACT_ALIGNMENT_OK` ;
- `composer opus:validate-site -- owasys-front` reste vert ;
- navigateur admin/developer : ouvrir `Modifier` conserve `Supprimer` compact, sans panneau vide étiré ;
- viewer : aucun contrôle lifecycle ne réapparaît.

NO JAVASCRIPT.
NO VIEWER MUTATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
