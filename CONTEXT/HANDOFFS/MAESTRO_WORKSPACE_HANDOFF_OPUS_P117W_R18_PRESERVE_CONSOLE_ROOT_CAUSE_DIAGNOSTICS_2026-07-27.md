# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R18

Date : 2026-07-27  
État : livrable actif à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 7f672643c345a2a7b9f665773fffe36f60dc5132
Racine owner : H:\OPUS
État observé : P117W R17 appliqué ; trace actif 96902adf1f9fd87c
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

## Cause active

Le backend exécute bien `owasys:registry-sync`, mais la console remplace l’exception interne par :

```text
OPUS_CONSOLE_COMMAND_FAILED
```

Le Logger backend ne reçoit donc plus le code réel, le fichier ni la ligne de la cause interne.

## Corriger

Remplacer uniquement :

```text
Opus/Console/OpusConsoleApplication.php
```

Conserver le préfixe stable d’un code OPUS/OWASYS contenant un contexte dynamique.

Ajouter aux réponses JSON internes un diagnostic caviardé contenant le message, la classe, le fichier relatif, la ligne et une empreinte.

Conserver la sortie texte limitée au code d’erreur.

## Livrable actif

```text
ZIP : opus_p117w_r18_preserve_console_root_cause_diagnostics.zip
SHA-256 : 597137c99d95cb89bfcd262e0f6a465062432f43ce60826027cf72e31f731962
Fichiers : 1
Octets ZIP : 4014
Octets non compressés : 19261
```

Contenu exclusif :

```text
Opus/Console/OpusConsoleApplication.php
```

## Appliquer

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r18_preserve_console_root_cause_diagnostics.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r18_preserve_console_root_cause_diagnostics.zip" -C H:\OPUS
php -l Opus\Console\OpusConsoleApplication.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back
```

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front
```

## Reproduire

```text
http://127.0.0.1:8000/fr-FR/applications
```

## Lire la cause réelle

Chercher le nouveau trace dans :

```text
sites/owasys-back/var/logs/owasys-back.log
```

Le champ `stdout_excerpt` doit désormais contenir :

```text
error_code
diagnostic.exception_class
diagnostic.exception_file
diagnostic.exception_line
diagnostic.exception_message
diagnostic.fingerprint
```

Ne pas utiliser la copie d’arborescence transmise par erreur.

## Validation effectuée

```text
PHP lint                               : OK
Préfixe d’erreur stable               : OK
Diagnostic JSON interne               : OK
Caviardage des secrets                : OK
Chemins absolus extérieurs masqués    : OK
Chemins interdits dans le ZIP         : 0
ZIP                                    : OK
```

Validation runtime Windows owner : requise.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
