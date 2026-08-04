# OPUS P117W R45B2A1R1 — Autorisation collective everyone dans le runtime généré

Date : 2026-08-04  
Statut : livrable owner actif  
Base OPUS : `edf17d28d32b1c2f293ba7993252b6e1748c906c`

## Acquisition

R45B2A1 est poussé et acquis au HEAD owner courant. Le site généré n'est pas une cible de correction locale.

## Cause traitée

Le scaffold génère correctement la politique d'accueil public avec `roles = ["everyone"]`. Le runtime générique `GeneratedSiteRuntime` représente cependant une identité non connectée avec l'état `anonymous` et ne contrôle que l'intersection entre les rôles de l'identité et les rôles de la politique. Comme `everyone` n'est pas un rôle métier, cette intersection est vide et l'accueil public échoue avec `OPUS_AUTH_REQUIRED`.

## Contrat

- `anonymous` reste exclusivement un état d'authentification ;
- `everyone` reste un sujet collectif implicite et ne devient pas un rôle métier ;
- une politique accordée à `everyone` autorise toute identité, connectée ou non ;
- une politique sans `everyone` reste deny-by-default et exige un rôle métier explicitement accordé ;
- une identité anonyme refusée conserve `OPUS_AUTH_REQUIRED` ;
- une identité authentifiée refusée conserve `OPUS_ACL_DENIED` ;
- aucune correction locale d'un site généré.

## Différentiel

```text
ZIP     : opus_p117w_r45b2a1r1_everyone_runtime_authorization.zip
SHA-256 : 719df05a387a62426ef570e34fd6c7d4115ad82c6c43d929139c5ec3810b0c34
FILES   : 1
BASE    : edf17d28d32b1c2f293ba7993252b6e1748c906c
```

Chemin :

- `Opus/Application/Runtime/GeneratedSiteRuntime.php`

## Profiler observé

La trace `cad81bd24182fb453451c46582191e12` contient 4 spans et 38 événements. La timeline principale affiche les 4 spans. Le panneau Configuration est vide parce que cette requête ne contient aucun événement `config.*` ; aucune donnée ne doit être inventée.

## Validation owner

PHP lint, autoload Composer, validation OWASYS front/back, création d'un nouveau site depuis OWASYS, ouverture publique de l'accueil, refus d'une route non accordée, contrôle Profiler et `git diff --check`.

## Suite

Après acquisition de R45B2A1R1, R45B2A2 implémente la rétention bornée et la rotation JSONL configurables. R45B3 reste ensuite le client REST frontend générique et les validateurs croisés.
