# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-26

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_OWASYS_DUAL_AUTONOMOUS_SUBAPPLICATIONS_SEPARATE_BASTIONS_SPEC_2026-07-26.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_DUAL_AUTONOMOUS_APPLICATIONS_DEV_SERVER_DELIVERY_SPEC_2026-07-26.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_DELIVERY_2026-07-26.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE master
```

## Architecture owner

Considérer OWASYS comme trois racines distinctes :

```text
sites/owasys-front
sites/owasys-back
sites/owasys-shared
```

Considérer `owasys-front` et `owasys-back` comme deux applications OPUS autonomes, installables sur deux bastions distincts.

Ne pas considérer `owasys-shared` comme une application. Ne pas y placer de Singleton, bootstrap, serveur, secret, Logger, Profiler ou état runtime.

## Deux Singletons

### Front

```text
OwasysFrontApplication
OwasysFrontApplicationInterface
```

Appliquer Singleton, FSM, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy/bastion, SCORE, client REST, Logger et Profiler. Interdire toute mutation métier et toute exécution Composer locale.

### Back

```text
OwasysBackApplication
OwasysBackApplicationInterface
```

Appliquer Singleton, FSM métier, I18n API, ACL deny-by-default, SSO/identité de service/bastion, REST sécurisé, Composer allow-listé, Logger et Profiler. Interdire tout rendu UI.

## Livrable actif

```text
ZIP : opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 : 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
Base : 4fb3a92605f14d84b8060ff36fde78828da49273
Fichiers : 60
Octets : 69297
État : installer et valider côté owner
```

Considérer HF10A et HF10B comme rejetés et remplacés par P117W.

Livrer le ZIP directement à la racine `H:\OPUS`, sans installateur, payload, patch, staging, rapport, journal ou copie complète du dépôt.

## Serveur de développement générique

Utiliser :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Exiger trois arguments variables :

```text
application-id
--host
--port
```

Ne coder aucune adresse ni aucun port fixe. Réserver cette commande au développement local. Conserver `opus:serve-site` uniquement pour compatibilité historique.

Lancer le backend :

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
```

Lancer ensuite le frontend :

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Résoudre dynamiquement l'endpoint backend depuis :

```text
runtime/development/servers.json
```

Créer ou réutiliser les secrets locaux dans :

```text
runtime/development/owasys-rcp-secrets.json
```

Ne jamais versionner `runtime/development` et ne jamais utiliser ce mécanisme en production.

## Installation owner

```cmd
cd /d H:\OPUS
git status --short
git rev-parse HEAD
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_owasys_dual_autonomous_applications_dev_server.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_owasys_dual_autonomous_applications_dev_server.zip" -C H:\OPUS
call sites\owasys-shared\tools\cmd\MIGRATE_OWASYS_P117W.cmd
composer dump-autoload -o
php sites\owasys-shared\tools\smoke\smoke_p117w_owasys_dual_applications.php
php tools\maintenance\opus_contractualize_all.php --audit --root="%CD%"
```

Attendre :

```text
P117W_OWASYS_DUAL_APPLICATION_MIGRATION_OK
P117W_OWASYS_DUAL_APPLICATIONS_SMOKE_OK
```

## Diagnostics

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler/runtime
sites/owasys-front/var/profiler/dev-server

sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler/runtime
sites/owasys-back/var/profiler/rcp
sites/owasys-back/var/profiler/dev-server
```

Propager le même `trace_id` de `owasys-front` vers `owasys-back`, la FSM REST et Composer.

## Validations exécutées

```text
Relire et analyser tous les fichiers PHP            : OK
Analyser les 36 fichiers JSON                       : OK
Réouvrir et contrôler le ZIP                        : OK
Valider les deux Singletons et leurs interfaces     : OK
Valider les quatre marqueurs des interfaces         : OK
Valider le registre générique de développement      : OK
Valider le client RCP V2 par endpoint_env           : OK
Exécuter le smoke P117W                             : OK
Détecter les entrées interdites dans le ZIP          : 0
```

## Continuer

1. installer le ZIP ;
2. exécuter la migration ;
3. reconstruire l'autoload ;
4. exécuter le smoke et l'audit ;
5. lancer le backend ;
6. lancer le frontend ;
7. tester REST vers Composer ;
8. contrôler Logger, Profiler et `trace_id` ;
9. transmettre les sorties exactes ;
10. préparer le nettoyage uniquement après acceptation complète.

## Nettoyage

Ne supprimer aucun ancien chemin avant acceptation de P117W. Préserver :

```text
sites/owasys
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
