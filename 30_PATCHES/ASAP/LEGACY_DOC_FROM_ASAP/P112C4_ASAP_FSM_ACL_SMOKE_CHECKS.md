# P112C4 — ASAP FSM + ACL — Smoke checks PHP

## Rôle

Ce palier valide le premier squelette PHP moderne FSM + ACL.

## Contrat

NO DOC CONTRACT, NO PATCH.

Le smoke check vérifie :

- chargement des classes FSM
- transition FSM autorisée
- transition FSM refusée explicitement
- chargement des classes ACL
- décision ACL autorisée
- décision ACL refusée

## Interdits

- aucun vendor
- aucun réseau
- aucune mutation runtime hors stdout
- aucun fallback silencieux

## Commande

H:\UwAmp\bin\php\php-8.5.6\php.exe tests\smoke\p112c4_fsm_acl_smoke.php

## Sortie attendue

P112C4 FSM smoke OK
P112C4 ACL smoke OK
P112C4 ASAP smoke checks OK
