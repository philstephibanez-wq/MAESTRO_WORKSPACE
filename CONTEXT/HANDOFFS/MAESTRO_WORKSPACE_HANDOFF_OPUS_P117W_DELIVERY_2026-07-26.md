# MAESTRO_WORKSPACE HANDOFF — OPUS P117W

Date : 2026-07-26  
État : installer et valider côté owner

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine locale : H:\OPUS
```

## Livrable actif

```text
ZIP : opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 : 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
Fichiers : 60
Octets : 69297
```

Considérer HF10A et HF10B comme rejetés et remplacés.

## Architecture à installer

```text
sites/owasys-front
sites/owasys-back
sites/owasys-shared
```

### Front

```text
Singleton : OwasysFrontApplication
Interface : OwasysFrontApplicationInterface
Rôle : SCORE, FSM, I18n navigateur, ACL, SSO, client REST
Journal : sites/owasys-front/var/logs/owasys-front.log
Profiler : sites/owasys-front/var/profiler/runtime
```

Interdire toute mutation métier locale et toute exécution Composer locale.

### Back

```text
Singleton : OwasysBackApplication
Interface : OwasysBackApplicationInterface
Rôle : API REST, FSM métier, ACL, SSO/service identity, Composer allow-listé
Journal : sites/owasys-back/var/logs/owasys-back.log
Profiler : sites/owasys-back/var/profiler/runtime et rcp
```

Interdire tout rendu UI.

### Shared

Conserver uniquement les contrats, schémas, valeurs communes non secrètes, manifestes, smoke et migration. Ne créer aucun runtime partagé entre les bastions.

## Commande de développement

Utiliser exclusivement :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Exiger l'identifiant d'application, l'adresse et le port comme arguments variables.

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

Ne pas utiliser `opus:dev-server` en production. Confier les endpoints et listeners de production aux infrastructures des bastions.

## Installation

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

## Développement distribué local

Lancer `owasys-back` avant `owasys-front` afin de permettre au registre runtime de résoudre dynamiquement :

```text
OPUS_OWASYS_BACKEND_ENDPOINT
```

Utiliser :

```text
runtime/development/servers.json
runtime/development/owasys-rcp-secrets.json
```

Ne jamais versionner ces fichiers.

## Contrôles

```cmd
cd /d H:\OPUS
type sites\owasys-back\var\logs\owasys-back.log
type sites\owasys-front\var\logs\owasys-front.log
dir /s /b sites\owasys-back\var\profiler
dir /s /b sites\owasys-front\var\profiler
```

Tester :

```text
http://127.0.0.1:8080/fr-FR/
http://127.0.0.1:8080/fr-FR/applications
http://127.0.0.1:8000/api/v1/status
```

Vérifier la propagation du `trace_id` du front vers le back et jusqu'à Composer.

## Nettoyage

Ne supprimer aucun ancien chemin avant acceptation complète. Préserver :

```text
sites/owasys
sites/owasys_old
sites/owasys/var
sites/owasys/application/shared
sites/owasys/application/front
sites/owasys/application/back
```

Fournir les commandes CMD de nettoyage uniquement après démontrer le fonctionnement des deux applications, REST, Composer, Logger et Profiler.

## Validations hors Windows owner

```text
Analyser tous les fichiers PHP                     : OK
Analyser les 36 fichiers JSON                      : OK
Réouvrir et contrôler le ZIP                       : OK
Exécuter le smoke P117W                            : OK
Valider les Singletons et interfaces               : OK
Valider le registre de développement               : OK
Valider le client RCP V2 et endpoint_env            : OK
Détecter les chemins interdits dans le ZIP          : 0
```

## Continuer

1. installer le différentiel ;
2. exécuter la migration ;
3. lancer le smoke et l'audit ;
4. lancer le backend ;
5. lancer le frontend ;
6. tester REST vers Composer ;
7. contrôler les diagnostics ;
8. transmettre les sorties exactes ;
9. préparer ensuite le nettoyage des chemins devenus obsolètes.
