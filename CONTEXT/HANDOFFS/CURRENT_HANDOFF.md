# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-26

## Lecture obligatoire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R1_OWASYS_NO_SHARED_EXCHANGES_ONLY_2026-07-26.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R1_TWO_APPLICATIONS_REST_ONLY_DELIVERY_SPEC_2026-07-26.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R1_DELIVERY_2026-07-26.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial extrait, migration OK, smoke OK
```

## Architecture owner

Conserver exactement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Supprimer toute notion de `owasys-shared`.

Ne partager aucun fichier, dossier, volume, configuration, secret, catalogue, manifeste, état runtime ou artefact entre les deux applications.

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Contrats applicatifs

### Front

```text
Singleton : OwasysFrontApplication
Interface : OwasysFrontApplicationInterface
```

Appliquer FSM, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy/bastion, SCORE, Logger, Profiler et client REST sécurisé.

Interdire toute mutation métier et toute exécution Composer locale.

### Back

```text
Singleton : OwasysBackApplication
Interface : OwasysBackApplicationInterface
```

Appliquer FSM métier et REST, I18n API, ACL deny-by-default, SSO/identité de service/bastion, Logger, Profiler, API REST sécurisée et Composer allow-listé.

Interdire tout rendu UI.

## Statut des livrables

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, migration et smoke réussis, architecture rejetée
P117W R1 : livrable actif à appliquer et valider
```

Rejeter définitivement :

```text
opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
```

## Livrable actif

```text
ZIP : opus_p117w_r1_owasys_two_autonomous_applications_rest_only.zip
SHA-256 : 922009ecc3632cf70e0dca6d4f79d81916391aebdf8f7409f8a6103ed6cd9e5e
Fichiers : 14
Octets : 23211
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial appliqué et migré
```

Ne contenir aucune entrée `sites/owasys-shared` dans le ZIP.

## Appliquer P117W R1

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r1_owasys_two_autonomous_applications_rest_only.zip" -C H:\OPUS
call sites\owasys-front\tools\cmd\MIGRATE_OWASYS_FRONT_P117W_R1.cmd
call sites\owasys-back\tools\cmd\MIGRATE_OWASYS_BACK_P117W_R1.cmd
composer dump-autoload -o
php sites\owasys-front\tools\smoke\smoke_p117w_r1_front.php
php sites\owasys-back\tools\smoke\smoke_p117w_r1_back.php
```

Attendre :

```text
P117W_R1_OWASYS_FRONT_MIGRATION_OK
P117W_R1_OWASYS_BACK_MIGRATION_OK
P117W_R1_OWASYS_FRONT_SMOKE_OK
P117W_R1_OWASYS_BACK_SMOKE_OK
```

## Supprimer la troisième racine rejetée

```cmd
cd /d H:\OPUS
call sites\owasys-front\tools\cmd\CLEANUP_REJECTED_OWASYS_SHARED_P117W_R1.cmd
composer dump-autoload -o
php scripts\audit_opus_component_interfaces.php
```

Attendre :

```text
P117W_R1_REJECTED_SHARED_ROOT_REMOVED
OPUS_COMPONENT_INTERFACE_AUDIT_OK:<nombre>
```

Supprimer également le registre commun de développement initial et ses classes devenues inutilisées.

## Provisionner le canal REST local

```cmd
cd /d H:\OPUS
call sites\owasys-back\tools\cmd\PROVISION_OWASYS_DEVELOPMENT_EXCHANGE_P117W_R1.cmd 127.0.0.1 8000
```

Écrire deux fichiers locaux indépendants :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

Ne faire lire à aucune application le fichier de l'autre application.

## Lancer en développement

Backend :

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
```

Frontend :

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l'identifiant d'application, l'adresse et le port comme arguments variables. Interdire `opus:dev-server` en production.

## Contrôler

```cmd
cd /d H:\OPUS
type sites\owasys-back\var\logs\owasys-back.log
type sites\owasys-front\var\logs\owasys-front.log
dir /s /b sites\owasys-back\var\profiler
dir /s /b sites\owasys-front\var\profiler
dir /s /b sites\owasys-shared
```

Faire retourner aucune entrée pour `sites\owasys-shared`.

Tester :

```text
http://127.0.0.1:8000/api/v1/status
http://127.0.0.1:8080/fr-FR/
http://127.0.0.1:8080/fr-FR/applications
```

Vérifier le même `trace_id` dans le frontend, le backend, la FSM REST et Composer.

## Contrats permanents

- faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php` ;
- faire étendre chaque interface homonyme par les quatre marqueurs standards ;
- lire toute configuration via `File` et `StructuredFileLoader` ;
- utiliser `Json`, `Xml` ou `Yaml` selon le format ;
- interdire tout `echo` UI et tout mélange HTML/PHP ;
- rendre uniquement via SCORE côté front ;
- faire passer toute mutation par REST sécurisé puis Composer ;
- imposer Logger et Profiler dans les deux applications ;
- interdire tout fallback silencieux.

## Préserver

Ne pas supprimer avant acceptation runtime complète :

```text
sites/owasys
sites/owasys_old
sites/owasys/var
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
