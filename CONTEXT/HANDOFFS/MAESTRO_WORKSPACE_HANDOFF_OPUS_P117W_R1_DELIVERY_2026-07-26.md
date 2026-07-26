# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R1

Date : 2026-07-26  
État : livrable produit ; application et validation owner requises

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial appliqué, migration et smoke réussis
```

Lire `README-FIRST.md` avant appliquer ce handoff.

## Architecture finale

Conserver exactement :

```text
sites/owasys-front
sites/owasys-back
```

Supprimer toute notion de `owasys-shared`.

Ne partager aucun fichier ou état runtime. Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Livrable actif

```text
ZIP : opus_p117w_r1_owasys_two_autonomous_applications_rest_only.zip
SHA-256 : 922009ecc3632cf70e0dca6d4f79d81916391aebdf8f7409f8a6103ed6cd9e5e
Fichiers : 14
Octets : 23211
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial extrait et migré
```

Considérer comme rejeté :

```text
opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
```

## Modifications principales

- retirer les références `shared_contract` des deux applications ;
- déclarer uniquement un échange REST local à chaque application ;
- remplacer le registre commun de développement par un environnement local sous chaque `var` ;
- conserver les paramètres de serveur comme arguments `application-id`, `--host` et `--port` ;
- fournir deux migrations indépendantes ;
- fournir deux smokes indépendants ;
- fournir un audit réel des interfaces OPUS sous `scripts/` ;
- fournir un CMD pour supprimer la troisième racine rejetée ;
- conserver la propagation RCP V2 du `trace_id` jusqu'à Composer.

## Application

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

## Supprimer la racine rejetée

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

Le CMD supprime également le registre commun de développement initial et ses deux classes devenues inutilisées.

## Provisionner le développement local

Fournir l'adresse et le port du backend comme arguments variables :

```cmd
cd /d H:\OPUS
call sites\owasys-back\tools\cmd\PROVISION_OWASYS_DEVELOPMENT_EXCHANGE_P117W_R1.cmd 127.0.0.1 8000
```

Écrire séparément :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

Ne faire lire à aucune application le fichier de l'autre application.

## Lancer

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

## Contrôler

```cmd
cd /d H:\OPUS
type sites\owasys-back\var\logs\owasys-back.log
type sites\owasys-front\var\logs\owasys-front.log
dir /s /b sites\owasys-back\var\profiler
dir /s /b sites\owasys-front\var\profiler
dir /s /b sites\owasys-shared
```

La dernière commande doit retourner `Fichier introuvable` ou ne retourner aucune entrée.

Tester :

```text
http://127.0.0.1:8000/api/v1/status
http://127.0.0.1:8080/fr-FR/
http://127.0.0.1:8080/fr-FR/applications
```

Vérifier le même `trace_id` dans le frontend, le backend, la FSM REST et Composer.

## Ne pas supprimer

Conserver jusqu'à validation complète :

```text
sites/owasys
sites/owasys_old
sites/owasys/var
```

Ne fournir le nettoyage de ces anciens chemins qu'après acceptation runtime de P117W R1.
