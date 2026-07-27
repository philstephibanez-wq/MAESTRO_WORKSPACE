# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R18_PRESERVE_CONSOLE_ROOT_CAUSE_DIAGNOSTICS_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R18_PRESERVE_CONSOLE_ROOT_CAUSE_DIAGNOSTICS_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 7f672643c345a2a7b9f665773fffe36f60dc5132
Racine owner : H:\OPUS
État observé : P117W R17 appliqué
Trace actif : 96902adf1f9fd87c
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

Ne partager aucun fichier entre les applications.

## Développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

```text
composer opus:dev-server -- owasys-front
composer opus:dev-server -- owasys-back
```

## Stockage Logger et Profiler

Conserver exactement :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler/owasys-front.jsonl
sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler/owasys-back.jsonl
```

Ne créer aucun fichier Logger ou Profiler supplémentaire.

## Cause traitée par R18

Le trace actif prouve que le frontend atteint REST, que le backend lance `owasys:registry-sync`, puis que le callback Composer retourne le code `20`.

`OpusConsoleApplication::safeErrorCode()` remplace actuellement l’exception interne par `OPUS_CONSOLE_COMMAND_FAILED` dès que son message contient une valeur dynamique ou un message PHP. La cause réelle est donc détruite avant journalisation.

## Correction générique OPUS

Modifier uniquement :

```text
Opus/Console/OpusConsoleApplication.php
```

Conserver le code stable OPUS/OWASYS.

Ajouter au JSON interne un diagnostic caviardé contenant la classe, le fichier relatif, la ligne, le message nettoyé et une empreinte.

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

Ne livrer aucun `tools`, aucun script, aucun fichier runtime, aucun journal, aucun secret et aucune racine partagée.

## Appliquer et valider

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r18_preserve_console_root_cause_diagnostics.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r18_preserve_console_root_cause_diagnostics.zip" -C H:\OPUS
php -l Opus\Console\OpusConsoleApplication.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Reproduire et lire

Relancer les deux serveurs, ouvrir `/fr-FR/applications`, puis lire le nouveau `stdout_excerpt` dans :

```text
sites/owasys-back/var/logs/owasys-back.log
```

Ne pas utiliser la copie d’arborescence transmise par erreur.

## Statut

```text
P117W R6 à R17 : présents/appliqués
P117W R18 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
