# MAESTRO_WORKSPACE HANDOFF — OPUS P117W OWASYS DUAL AUTONOMOUS APPLICATIONS

Date : 2026-07-26  
Statut : architecture owner validée ; HF10B rejeté ; différentiel P117W requis

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
Branch          : master
HEAD            : 4fb3a92605f14d84b8060ff36fde78828da49273
Owner local     : H:\OPUS
```

## Décision owner

OWASYS est un système composé de deux sous-applications OPUS autonomes :

```text
sites/owasys/front
sites/owasys/back
```

Elles peuvent être déployées sur deux bastions distincts.

Le modèle suivant est abandonné :

```text
application/shared/Application.php
application/front
application/back
un Singleton commun avec deux runtime_mode
```

## Nouvelle structure

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

`shared` n'est pas une application. Il ne contient aucun Singleton, bootstrap, secret, serveur ou état runtime.

## Deux contrats applicatifs OPUS

### Front

```text
OwasysFrontApplication
OwasysFrontApplicationInterface
```

Contrats : Singleton, FSM front, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy, SCORE-only, client REST sécurisé, Logger et Profiler.

### Back

```text
OwasysBackApplication
OwasysBackApplicationInterface
```

Contrats : Singleton, FSM back, I18n API, ACL deny-by-default, SSO/service identity/bastion, REST sécurisé, Composer allow-listé, Logger et Profiler.

## Déploiement distinct

Chaque bastion reçoit son propre artefact :

```text
owasys-front
owasys-back
```

Chaque artefact embarque localement la version résolue des contrats/configurations communs. Aucun accès à un dossier partagé distant n'est autorisé.

Les manifests front/back déclarent :

```text
shared_contract_version
shared_contract_sha256
api_contract_version
minimum_opus_version
```

Les secrets sont injectés séparément par le déploiement. Ils ne sont jamais versionnés dans `shared`.

## Preuve runtime HF10B

Le Profiler owner fournit :

```text
trace_id        : 5f52a28017dc564d
runtime_mode     : front
exception_class  : RuntimeException
exception_file   : H:\OPUS\Opus\Fsm\FsmSiteLoader.php
exception_line   : 193
```

Le chargeur FSM impose actuellement `default_root = application/default`. HF10B présentait un site unique stratifié et entre donc en conflit avec le contrat canonique. Deux sites autonomes restaurent chacun une racine OPUS standard.

Le log backend prouve seulement le démarrage d'un processus distinct :

```text
trace_id     : 911f9e7f8708bf84
runtime_mode : back
port         : 8792
```

Aucune requête REST n'est encore validée.

## Livrable requis

Le prochain ZIP différentiel direct doit :

- créer les deux sites autonomes ;
- créer les deux Singletons et interfaces ;
- créer deux configurations `site.json` ;
- créer deux FSM ;
- créer deux ACL ;
- créer deux compositions SSO ;
- séparer Logger et Profiler ;
- déplacer les sources communes sans runtime dans `shared` ;
- fournir deux commandes Composer visant deux identités de site distinctes ;
- valider une simulation de déploiement sur deux bastions ;
- valider REST sécurisé -> Composer ;
- propager le même `trace_id` de front vers back ;
- rester directement superposable à `H:\OPUS`.

## Nettoyage

Aucune suppression avant acceptation runtime du nouveau différentiel. Préserver :

```text
sites/owasys_old
sites/owasys/var
sites/owasys/application/shared
sites/owasys/application/front
sites/owasys/application/back
```

Ces chemins servent de repli et de source de migration jusqu'à validation des nouveaux sites.
