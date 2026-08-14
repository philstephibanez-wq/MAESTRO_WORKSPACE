# HANDOFF — OPUS P117W R45D2A28B Security Graphical Primary Navigation

Date : 2026-08-14

## Base OPUS publiée

`f61382ea8e8c2e590176e25ef98208a7ff8ceaee` — `opus_p117w_r45d2a28a_security_view_isolation_fragment_elimination`.

## Cause

La navigation Security était techniquement présente mais peu lisible. Les rubriques `Rôles`, `Permissions`, `Attributions` et `Ressources & ACL` étaient des `<details>` fermés : le clic sur le maillon changeait la route sans présenter immédiatement la rubrique attendue.

## Livrable

`opus_p117w_r45d2a28b_security_graphical_primary_navigation.zip`

SHA-256 : `bce2d0b1cdc4730629fdda6fe23112c92be59bd4851b3bf39ac966e14c71b7e9`

## Comportement attendu

- `/fr-FR/sécurité` = vue d'ensemble graphique ;
- schéma persistant : Identités -> Attributions -> Rôles -> Permissions -> Ressources & ACL ;
- chaque maillon est cliquable, localisé, numéroté et possède un compteur ;
- maillon courant marqué `aria-current="page"` et visuellement actif ;
- clic Rôles -> `/fr-FR/sécurité/rôles` avec rubrique Rôles déjà ouverte ;
- clic Attributions -> `/fr-FR/sécurité/attributions` avec rubrique Attributions déjà ouverte ;
- même contrat pour Permissions et Ressources & ACL ;
- Identités reste directement développé dans sa sous-vue ;
- Vue d'ensemble accessible depuis toutes les sous-vues ;
- métriques Utilisateurs, Agents, Rôles et Ressources deviennent navigables ;
- providers visibles sur la vue d'ensemble ;
- correction de la frontière HTML du panneau Ressources/Providers ;
- aucun `?view=...`, aucun fragment `#ow-security-unclassified` ;
- changement de langue conserve la sous-vue ;
- aucune modification métier, REST, ACL, FSM ou backend ;
- viewer reste lecture seule ;
- SCORE + CSS + rendu serveur ; zéro JavaScript pour cette évolution.

## Gates navigateur

1. ouvrir `/fr-FR/sécurité` et vérifier la vue d'ensemble ;
2. cliquer successivement Identités, Attributions, Rôles, Permissions, Ressources & ACL ;
3. chaque clic doit afficher une seule rubrique détaillée et celle-ci doit être immédiatement ouverte ;
4. vérifier l'état actif du maillon ;
5. vérifier le retour Vue d'ensemble ;
6. vérifier le changement de langue depuis Rôles ou Attributions ;
7. vérifier qu'aucun fragment ni query technique n'apparaît.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
