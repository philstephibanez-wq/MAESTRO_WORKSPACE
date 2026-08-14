# OPUS P117W R45D2A27 — Assignment Revoke UI

Date : 2026-08-14

## Base OPUS publiée

`9256f6dd4837a5465f801018368113fa0a740499` — `opus_p117w_r45d2a26_assignment_revoke_backend`.

## Cause

R45D2A26 ajoute `assignment.revoke` au backend Security, avec `access_delta.lost`, commit atomique et protection du dernier administrateur. Le front Security ne connaît cependant encore que `assignment.grant` dans la vue Attributions : la capacité backend n’est donc pas exposée graphiquement.

## Contrat cible

- exposer `assignment_revoke_supported` uniquement lorsque `$canMutate` est vrai et que le backend annonce `assignment_revoke` ;
- autoriser `assignment.revoke` uniquement dans la vue `assignments` du contrôleur Security ;
- rendre chaque attribution existante avec une action SCORE `Révoquer` uniquement lorsqu’elle provient du runtime local réellement modifiable ;
- la révocation doit exiger motif + réauthentification OWASYS puis passer par le pipeline Preview -> confirmation -> Commit existant ;
- la Preview doit afficher les accès perdus retournés par le backend ;
- le refus de retirer la dernière attribution administrative doit être présenté avec un message métier localisé ;
- une attribution ou identité déjà absente doit produire un message métier localisé ;
- aucun contrôle Révoquer en viewer ;
- aucune décision de sécurité seulement visuelle ; le backend reste décisif ;
- zéro JavaScript ;
- aucun changement du contrat REST ni de la FSM de mutation ;
- conserver les langues de l’Union européenne et l’ukrainien, avec accents corrects.

## Livrable

```text
ZIP     : opus_p117w_r45d2a27_assignment_revoke_ui.zip
SHA-256 : 828836dea799d75296463fa676dcf52a80b37c816f22bfb4cab883e42f662611
BASE    : 9256f6dd4837a5465f801018368113fa0a740499
FILES   : 3
```

## Gate attendu

En admin/developer, la vue Attributions affiche `Révoquer` sur chaque attribution locale réellement révocable lorsque le backend le supporte. Une Preview de révocation non administrative montre `Accès perdus`. Une tentative de révocation de la dernière attribution administrative est refusée avant écriture avec un message explicite. En viewer, aucune action de mutation n’est visible.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
