# HANDOFF — OPUS P117W R45D2A25F Principal Column Consolidation

Date : 2026-08-14

## Base OPUS publiée

`bf2d62fd3f3d7f7eea66d0bb0369d232e15c0474` — `opus_p117w_r45d2a25e_security_identity_actions_compact_alignment`.

## Observation navigateur

La vue Security / Identités présente un cadre supérieur de création `Utilisateur` / `Agent`, puis un second cadre `Utilisateurs` / `Agents` pour la liste. Il ne s’agit pas d’un doublon de données mais d’un doublon de présentation.

## Cause source

Les formulaires `identity.reference` sont rendus dans un bloc extérieur `.ow-security-quick-actions` avant `.ow-security-principal-grid-visible`. Les listes sont ensuite rendues dans deux colonnes principales séparées.

## Gate actif

R45D2A25F déplace chaque formulaire de création dans la colonne correspondante et supprime le conteneur/CSS extérieur devenu inutile.

Contrat :
- un seul cadre Utilisateurs ;
- un seul cadre Agents ;
- création visible uniquement si `security.identity_reference_supported` ;
- viewer sans Ajouter / Classifier / Modifier / Supprimer ;
- backend, REST, FSM, ACL inchangés ;
- SCORE/CSS uniquement.

## Livrable

```text
ZIP     : opus_p117w_r45d2a25f_principal_column_consolidation.zip
SHA-256 : 3038c9ec4a2d69b4b6d1d475291ffcdcf66a51d70242fc2c55e78bd441270e67
BASE    : bf2d62fd3f3d7f7eea66d0bb0369d232e15c0474
FILES   : 2
```

Après validation navigateur et publication : recontrôle viewer final, puis clôture lifecycle Security.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
