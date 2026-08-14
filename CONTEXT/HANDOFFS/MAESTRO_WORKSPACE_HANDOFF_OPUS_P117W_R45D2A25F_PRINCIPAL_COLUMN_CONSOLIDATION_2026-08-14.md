# HANDOFF — OPUS P117W R45D2A25F Principal Column Consolidation

Date : 2026-08-14

## Publication OPUS

`de6c8e74985f690f18e77ea701555712aa598c24` — `opus_p117w_r45d2a25f_principal_column_consolidation`.

## Cause traitée

La vue Security / Identités rendait les formulaires `identity.reference` dans un bloc extérieur `.ow-security-quick-actions`, puis rendait séparément les colonnes Utilisateurs/Agents. Cela produisait deux cadres pour une même catégorie.

## Résultat validé

- un seul cadre Utilisateurs ;
- un seul cadre Agents ;
- création intégrée dans la colonne correspondante ;
- liste conservée dans la même colonne ;
- backend, REST, FSM et ACL inchangés ;
- SCORE/CSS uniquement ;
- les gardes `identity_reference_supported`, `identity_update_supported` et `identity_delete_supported` restent dérivées de `$canMutate`.

## État Security courant

- 1 Utilisateur : `steve`, actif, rôle `admin` ;
- 0 Agent ;
- 1 identité legacy restante : `home` ;
- protection de la dernière identité administrative validée : suppression de `steve` refusée avant écriture avec message localisé ;
- suppression réelle d’une identité legacy validée ;
- classification réelle `unknown -> user` validée ;
- conflits métier Security localisés ;
- actions Modifier/Supprimer compactes ;
- colonnes Utilisateurs/Agents fusionnées.

## Suite

Le lifecycle Identités est considéré acquis. Le prochain travail doit auditer les autres objets Security (Attributions, Rôles, Permissions, Ressources/ACL) afin d’identifier les mutations manquantes avant toute nouvelle UI.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
