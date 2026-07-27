# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R17_SINGLE_LOG_AND_PROFILER_FILE_PER_APPLICATION_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R17_SINGLE_LOG_AND_PROFILER_FILE_PER_APPLICATION_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 7f672643c345a2a7b9f665773fffe36f60dc5132
Racine owner : H:\OPUS
État observé : P117W R16 présent
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

## Décision P117W R17

Conserver exactement un fichier Logger et un fichier Profiler par application :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler/owasys-front.jsonl

sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler/owasys-back.jsonl
```

Ne créer aucun fichier Profiler par trace, lancement ou composant.

Ne fusionner ni Logger et Profiler, ni frontend et backend.

Logger respecte déjà cette décision. Modifier uniquement le stockage générique Profiler.

## Correction générique OPUS

Modifier :

```text
Opus/Profiler/Profiler.php
Opus/Profiler/ProfilerInterface.php
```

Faire rechercher la racine de l’application via `config/site.json`, lu avec `File` et `StructuredFileLoader`.

Faire converger tous les producteurs Profiler internes de l’application vers :

```text
<site-root>/var/profiler/<site_id>.jsonl
```

Ajouter chaque trace comme une ligne JSON compacte contenant `trace_id`, `record_id` et `recorded_at`.

Conserver l’accès par URL en ajoutant :

```text
readTrace(string $traceId): array
```

Cette méthode retourne tous les enregistrements portant le trace demandé.

## Livrable actif

```text
ZIP : opus_p117w_r17_single_log_and_profiler_file_per_application.zip
SHA-256 : adbd3d3a67d0d1af5bb6604f3892bb041251005a77b175fa293f8e18fc443385
Fichiers : 2
Octets ZIP : 3218
Octets non compressés : 9344
```

Contenu exclusif :

```text
Opus/Profiler/Profiler.php
Opus/Profiler/ProfilerInterface.php
```

Ne livrer aucun `tools`, aucun script, aucun fichier runtime, aucun journal, aucun secret et aucune racine partagée.

## Appliquer et valider

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r17_single_log_and_profiler_file_per_application.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r17_single_log_and_profiler_file_per_application.zip" -C H:\OPUS
php -l Opus\Profiler\Profiler.php
php -l Opus\Profiler\ProfilerInterface.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Nettoyer

Arrêter les serveurs puis supprimer uniquement les anciens sous-répertoires `dev-server`, `runtime`, `rcp` et les anciens fichiers `*.json` sous les deux racines `var/profiler`.

Ne supprimer aucun Logger et aucun autre chemin sous `var`.

## Statut

```text
P117W R6 à R16 : présents/appliqués
P117W R17 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
