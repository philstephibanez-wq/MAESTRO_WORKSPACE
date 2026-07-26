# OPUS P117W R2 — DEUX APPLICATIONS, REST UNIQUEMENT, AUCUN TOOLS

Date : 2026-07-26  
État : ZIP différentiel produit ; application owner requise

## Lire

Lire `README-FIRST.md` et appliquer les contrats MAESTRO/OPUS actifs.

## Conserver

```text
sites/owasys-front
sites/owasys-back
```

Considérer les deux racines comme deux applications OPUS autonomes et déployables sur deux bastions distincts.

## Échanger

Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier, dossier, volume, secret, configuration, catalogue, manifeste ou état runtime entre les applications.

## Interdire

Interdire dans le livrable et dans l’architecture finale :

```text
tools/
sites/owasys-front/tools
sites/owasys-back/tools
sites/owasys-shared
```

Ne placer aucun script de migration, smoke, audit ou provisionnement dans un répertoire nommé `tools`.

## Placer les scripts

Placer les scripts opérationnels sous la racine canonique existante :

```text
scripts/owasys/p117w-r2
```

Conserver l’audit générique sous :

```text
scripts/audit_opus_component_interfaces.php
```

## Appliquer

Utiliser :

```text
scripts/owasys/p117w-r2/MIGRATE_OWASYS_FRONT_P117W_R2.cmd
scripts/owasys/p117w-r2/MIGRATE_OWASYS_BACK_P117W_R2.cmd
scripts/owasys/p117w-r2/smoke_p117w_r2_front.php
scripts/owasys/p117w-r2/smoke_p117w_r2_back.php
scripts/owasys/p117w-r2/PROVISION_OWASYS_DEVELOPMENT_EXCHANGE_P117W_R2.cmd
scripts/owasys/p117w-r2/CLEANUP_REJECTED_OWASYS_SHARED_P117W_R2.cmd
```

## Lancer

Backend :

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
```

Frontend :

```text
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables. Réserver cette commande au développement.

## Livrer

```text
ZIP : opus_p117w_r2_owasys_no_tools_two_applications_rest_only.zip
SHA-256 : e956043cbb799497fa51fa4ca40217f7fa9944063de297e0baa32d47a3d69ad4
Fichiers : 14
Octets : 22184
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial appliqué et migré
```

Ne contenir aucun chemin ni aucune référence vers un répertoire `tools`.

## Valider

```text
Analyser la syntaxe PHP                         : OK
Analyser les JSON                              : OK
Réouvrir et contrôler le ZIP                  : OK
Compter les fichiers complets                 : 14
Détecter un chemin tools                      : 0
Détecter une référence tools                  : 0
Détecter une entrée owasys-shared             : 0
Détecter payload/patch/staging/report/log      : 0
```

## Rejeter

Rejeter P117W R1 :

```text
opus_p117w_r1_owasys_two_autonomous_applications_rest_only.zip
```

Motif : contenir des répertoires `tools` dans les deux applications.
