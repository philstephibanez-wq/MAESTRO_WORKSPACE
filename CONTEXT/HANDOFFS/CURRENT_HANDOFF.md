# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-26

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_OWASYS_DUAL_AUTONOMOUS_SUBAPPLICATIONS_SEPARATE_BASTIONS_SPEC_2026-07-26.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_OWASYS_DUAL_AUTONOMOUS_APPLICATIONS_2026-07-26.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
remote head     : 4fb3a92605f14d84b8060ff36fde78828da49273
owner local     : H:\OPUS + HF10B appliqué
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
```

## Architecture owner validée

OWASYS est composé de deux sous-applications OPUS autonomes :

```text
sites/owasys/front
sites/owasys/back
```

Elles peuvent être installées sur deux serveurs ou deux bastions distincts.

Le modèle `un site + un Singleton partagé + runtime_mode=front|back` est abandonné.

## Structure cible

```text
sites/owasys/
  shared/
    contracts/
    schemas/
    defaults/
    i18n-source/
    deployment/

  front/
    application/default/
    application/<module>/
    config/
    www/
    var/

  back/
    application/default/
    application/<module>/
    config/
    www/
    var/
```

`shared` n'est pas une application. Il ne contient aucun Singleton, bootstrap, serveur, secret, journal, profiler ou état runtime.

## Deux Singletons OPUS

### Front

```text
OwasysFrontApplication
OwasysFrontApplicationInterface
```

Contrat complet : Singleton, FSM frontend, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy, SCORE-only, client REST sécurisé, Logger et Profiler.

### Back

```text
OwasysBackApplication
OwasysBackApplicationInterface
```

Contrat complet : Singleton, FSM backend, I18n API, ACL deny-by-default, SSO/identité de service/bastion, REST sécurisé, Composer allow-listé, Logger et Profiler.

## Bastions distincts

Chaque sous-application possède son propre artefact de déploiement et sa propre configuration locale.

```text
owasys-front artifact
owasys-back artifact
```

Les données communes sont résolues et copiées dans chaque artefact. Aucun partage de fichiers runtime entre bastions n'est autorisé.

Les manifests déclarent :

```text
shared_contract_version
shared_contract_sha256
api_contract_version
minimum_opus_version
```

Les secrets sont injectés séparément par le déploiement ou le secret manager. Ils ne sont jamais stockés dans `shared` ni dans Git.

## Preuve du rejet HF10B

Frontend :

```text
trace_id        : 5f52a28017dc564d
exception_class : RuntimeException
exception_file  : Opus/Fsm/FsmSiteLoader.php
exception_line  : 193
```

Le chargeur FSM impose encore `default_root = application/default`. HF10B tentait de faire d'un site unique une arborescence `application/front/default`, incompatible avec ce contrat.

Backend :

```text
trace_id     : 911f9e7f8708bf84
message      : process.starting
runtime_mode : back
port         : 8792
```

Cela prouve uniquement le démarrage du processus backend, pas une requête REST ni Composer.

## Statut livrables

```text
HF10A : rejeté
HF10B : installé, runtime rejeté, architecture remplacée
P117W : nouveau différentiel requis
```

Aucun ZIP HF10A/HF10B ne doit être considéré comme architecture acceptée.

## Livrable P117W requis

Le prochain ZIP différentiel direct doit :

1. créer `sites/owasys/front` et `sites/owasys/back` ;
2. créer deux Singletons et deux interfaces ;
3. fournir deux `config/site.json` indépendants ;
4. fournir deux FSM, deux ACL, deux compositions SSO ;
5. fournir deux Logger et deux Profiler ;
6. conserver SCORE uniquement côté front ;
7. conserver REST sécurisé -> Composer côté back ;
8. convertir `shared` en contrats/sources sans runtime ;
9. fournir deux commandes Composer visant deux identités de site distinctes ;
10. produire deux artefacts déployables séparément ;
11. tester deux racines ou bastions simulés ;
12. propager le même `trace_id` de front vers back ;
13. rester un ZIP différentiel direct superposable à `H:\OPUS`.

## Contrats permanents

- toute classe concrète sous `Opus/**/*.php` implémente son interface homonyme ;
- chaque interface homonyme étend les quatre marqueurs standards ;
- configuration via `File` puis `Json`, `Xml` ou `Yaml` ;
- aucun echo UI ni mélange HTML/PHP ;
- aucun fallback silencieux ;
- Logger et Profiler obligatoires ;
- aucune mutation métier dans le frontend ;
- toute mutation OWASYS passe par REST sécurisé puis Composer.

## Nettoyage

Aucune suppression autorisée avant validation du différentiel P117W. Préserver :

```text
sites/owasys_old
sites/owasys/var
sites/owasys/application/shared
sites/owasys/application/front
sites/owasys/application/back
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
