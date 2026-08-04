# OPUS P117W R45B2A1 — FSM nommée, everyone et timeline synthétique

Date : 2026-08-04  
Statut : livrable owner actif  
Base OPUS : `dac97628f182b62ee7d2759583441f5bdf179c36`

## Cause traitée

Le scaffold frontend et backend génère `application.fsm.json` sans propriété `name`, alors que `FsmProcessor` l'exige. Le wizard confond en outre l'état d'identité `anonymous` avec un rôle ACL. Enfin, la chronologie Profiler fusionne spans et événements et duplique ainsi la lecture d'une trace.

## Contrat

- chaque FSM générée porte le nom canonique `<site_id>.application` ;
- `opus:validate-site` refuse une FSM sans nom canonique ;
- `anonymous` demeure exclusivement un état d'authentification ;
- `everyone` est le sujet collectif implicite autorisé dans `home_roles` et les ressources publiques ;
- les rôles métier par défaut ne contiennent que `admin` ;
- une page authentifiée ne peut pas être ouverte à `everyone` ;
- la timeline principale affiche les spans mesurés et ne retombe sur les événements que lorsqu'aucun span n'existe ;
- aucune correction locale d'un site généré.

## Différentiel

```text
ZIP     : opus_p117w_r45b2a1_fsm_everyone_timeline.zip
SHA-256 : 4d4b1ee5b8585f8d1529578e08b4cbb6575ef1414c8c6c4ca86b3752776399fd
FILES   : 4
BASE    : dac97628f182b62ee7d2759583441f5bdf179c36
```

Chemins :

- `Opus/Console/Service/SiteCommandService.php`
- `Opus/Profiler/WebProfilerView.php`
- `Opus/Scaffold/SiteScaffoldPlan.php`
- `sites/owasys-front/application/creation/controllers/CreationController.php`

## Validation owner

PHP lint, autoload Composer, création depuis OWASYS, validation du site généré, ouverture par `opus:dev-server`, contrôle ACL `everyone`, timeline Profiler et `git diff --check`.

## Suite

R45B2A2 implémente le stockage borné et la rotation configurable des traces JSONL conformément au contrat Profiler. R45B3 reste ensuite le client REST frontend générique et les validateurs croisés.
