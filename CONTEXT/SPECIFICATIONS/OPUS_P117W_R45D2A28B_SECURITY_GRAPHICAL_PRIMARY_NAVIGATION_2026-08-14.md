# OPUS P117W R45D2A28B — Security Graphical Primary Navigation

Date : 2026-08-14

## Base

OPUS publié : `3d4b0cb06e8a825326809ce9173b6fefb36827e9` (`R45D2A27`).

Pré-requis local avant application : R45D2A28 puis R45D2A28A appliqués et validés.

## Cause traitée

La page Security expose techniquement des liens dans le diagramme de flux, mais ils ne constituent pas une navigation principale suffisamment identifiable. Le rôle, les permissions, les attributions et les ressources sont difficiles à trouver depuis `/sécurité`.

## Contrat UX

1. `/sécurité` devient une vraie vue d'ensemble, sans formulaire métier implicite.
2. Une navigation graphique persistante affiche explicitement :
   - Identités ;
   - Rôles ;
   - Permissions ;
   - Attributions ;
   - Ressources & ACL.
3. Chaque entrée contient une icône, un libellé et un compteur contextuel.
4. La vue active est visuellement marquée et porte `aria-current="page"`.
5. Les métriques Rôles et Ressources du dashboard deviennent elles-mêmes cliquables.
6. La métrique À classifier navigue vers Identités, sans fragment URL.
7. Les routes publiques restent les routes localisées R45D2A28.
8. Aucune mutation supplémentaire ; ACL inchangée ; viewer reste lecture seule.
9. SCORE + CSS uniquement ; zéro JavaScript.
10. Aucun changement REST/FSM/backend.

## Critères navigateur

- `/fr-FR/sécurité` affiche la vue d'ensemble et la navigation principale.
- clic Rôles -> `/fr-FR/sécurité/rôles` ;
- clic Attributions -> `/fr-FR/sécurité/attributions` ;
- retour Vue d'ensemble possible depuis toute sous-vue ;
- une seule sous-vue détaillée est rendue à la fois ;
- aucun `?view=...` ni `#ow-security-unclassified` généré.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
