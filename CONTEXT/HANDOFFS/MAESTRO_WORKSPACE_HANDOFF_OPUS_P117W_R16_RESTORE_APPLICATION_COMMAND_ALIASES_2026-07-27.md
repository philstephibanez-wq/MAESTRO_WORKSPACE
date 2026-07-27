# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R16

Date : 2026-07-27  
État : livrable actif à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git de base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R15 appliqués
```

## Cause active

Le trace `296ba2a1e87ba3e0` montre :

```text
owasys-front -> REST -> owasys-back
script Composer = owasys:registry-sync
exit_code = 1
stdout = OPUS_CONSOLE_COMMAND_FAILED
```

Le registre backend déclare l’alias :

```text
owasys:registry-sync -> owasys:registry:sync
```

R14 a conservé les commandes canoniques mais a omis les alias. `ApplicationCommandDispatcher::supports()` rejette donc le nom réellement invoqué par Composer avant charger le provider backend.

## Corriger

Remplacer uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
```

Lire les alias, les valider, cibler l’application, résoudre la commande canonique et charger uniquement le provider propriétaire.

## Livrable actif

```text
ZIP : opus_p117w_r16_restore_application_command_aliases.zip
SHA-256 : 31448c0030d19ab7e0d0dd921ce5df20e9bb94ffa3d8c199048fc99b106cb3dd
Fichiers : 1
Octets ZIP : 2827
Octets non compressés : 11588
```

Inclure uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime, aucun secret et aucune racine partagée.

## Appliquer

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r16_restore_application_command_aliases.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r16_restore_application_command_aliases.zip" -C H:\OPUS
php -l Opus\Console\Application\ApplicationCommandDispatcher.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git status --short
```

## Lancer

Frontend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front
```

Backend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back
```

## Tester

```text
curl -i http://127.0.0.1:8080/api/v1/status
curl -i http://127.0.0.1:8000/fr-FR/
curl -i http://127.0.0.1:8000/fr-FR/applications
```

## Validation effectuée

```text
Alias reconnu                               : OK
Ciblage owasys-back                         : OK
Commande canonique transmise                : OK
Provider historique non chargé              : OK
Ambiguïté directe non ciblée refusée         : OK
PHP lint                                     : OK
Chemins interdits                            : 0
ZIP                                          : OK
```

Validation runtime Windows owner : requise.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
