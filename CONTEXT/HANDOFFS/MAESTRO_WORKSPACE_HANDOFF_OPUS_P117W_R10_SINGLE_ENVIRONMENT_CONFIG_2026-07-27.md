# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R10

Date : 2026-07-27  
État : livrable actif à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
Base locale : P117W initial et R3 à R9 appliqués
```

## Architecture

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier et ne créer aucune racine commune.

## Décision R10

Remplacer les fichiers :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

par une section `environments` dans le `config/site.json` de chaque application.

Déclarer les sections :

```text
dev
test
prod
```

Utiliser `OPUS_APPLICATION_ENVIRONMENTS_V1` et sélectionner l’environnement par `OPUS_ENV`.

Faire sélectionner `dev` automatiquement par `opus:dev-server`.

Conserver l’adresse et le port locaux comme arguments variables de la commande. Déclarer l’adresse, le port et l’endpoint du peer dans la section de l’environnement correspondant.

Conserver les secrets hors du fichier de configuration. Référencer les variables d’environnement bearer et HMAC et refuser leur absence avant démarrer le serveur.

## Livrable actif

```text
ZIP : opus_p117w_r10_single_environment_config_sections.zip
SHA-256 : 590f204c6ea2cb36816499443e735174b51d557813731b54efbe8e93878e3c59
Fichiers : 3
Octets : 12938
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier sous `var`, aucune migration, aucun smoke, aucun audit, aucun rapport, aucun secret et aucune racine partagée.

## Appliquer

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r10_single_environment_config_sections.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r10_single_environment_config_sections.zip" -C H:\OPUS
composer dump-autoload -o
php -l Opus\Console\Service\SiteCommandService.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Nettoyer

Après appliquer R10, supprimer uniquement :

```text
sites/owasys-front/var/development
sites/owasys-back/var/development
```

Conserver tous les autres répertoires runtime.

## Préparer les secrets de développement

Définir les mêmes valeurs dans les deux terminaux de développement :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Ne placer aucune valeur secrète dans Git, le ZIP, les logs ou le profiler.

## Lancer

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

## Tester

```text
http://127.0.0.1:8000/api/v1/status
http://127.0.0.1:8080/fr-FR/
http://127.0.0.1:8080/fr-FR/applications
```

## Validation effectuée

```text
PHP lint                                       : OK
JSON                                           : OK
Résolution section dev                         : OK
Injection host/port locaux                     : OK
Validation du peer                             : OK
Refus des secrets absents                      : OK
Chemins interdits                              : 0
ZIP                                            : OK
```

Validation runtime Windows owner : requise.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
