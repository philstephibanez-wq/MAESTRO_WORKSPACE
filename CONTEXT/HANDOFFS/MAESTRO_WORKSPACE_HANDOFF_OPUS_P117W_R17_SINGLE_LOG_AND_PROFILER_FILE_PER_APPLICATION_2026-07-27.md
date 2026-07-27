# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R17

Date : 2026-07-27  
État : livrable actif à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 7f672643c345a2a7b9f665773fffe36f60dc5132
Racine owner : H:\OPUS
État local/remote observé : P117W R16 présent
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

## Décision active

Conserver exactement :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler/owasys-front.jsonl

sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler/owasys-back.jsonl
```

Ne créer aucun fichier Profiler par trace, lancement ou composant.

Ne fusionner ni Logger et Profiler, ni frontend et backend.

Logger respecte déjà le fichier unique par application. Ne pas le modifier.

## Correction générique OPUS

Modifier uniquement :

```text
Opus/Profiler/Profiler.php
Opus/Profiler/ProfilerInterface.php
```

Faire converger tous les chemins Profiler internes d’une même application vers :

```text
<site-root>/var/profiler/<site_id>.jsonl
```

Résoudre la racine via `config/site.json`, lu avec `File` et `StructuredFileLoader`.

Ajouter chaque trace comme une ligne JSON compacte. Conserver `trace_id` au premier niveau.

Ajouter :

```text
readTrace(string $traceId): array
```

pour permettre au lecteur Profiler appelé par URL de retrouver tous les enregistrements du trace dans l’unique fichier de l’application.

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

## Appliquer

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

## Nettoyer les anciens fichiers Profiler

Arrêter les deux serveurs avant nettoyage.

Supprimer uniquement les anciens sous-répertoires et fichiers JSON Profiler :

```text
sites/owasys-front/var/profiler/dev-server
sites/owasys-front/var/profiler/runtime
sites/owasys-front/var/profiler/*.json
sites/owasys-back/var/profiler/dev-server
sites/owasys-back/var/profiler/runtime
sites/owasys-back/var/profiler/rcp
sites/owasys-back/var/profiler/*.json
```

Ne supprimer aucun Logger et aucun autre chemin sous `var`.

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

## Contrôler

Après plusieurs requêtes, obtenir exactement :

```text
sites/owasys-front/var/profiler/owasys-front.jsonl
sites/owasys-back/var/profiler/owasys-back.jsonl
```

Les fichiers doivent contenir plusieurs lignes JSON et rester interrogeables par `trace_id`.

## Validation effectuée

```text
PHP lint                               : OK
Trois producteurs simulés             : OK
Un seul fichier Profiler              : OK
JSONL                                  : OK
Lecture de plusieurs records par trace: OK
Chemins interdits                      : 0
ZIP                                    : OK
```

Validation runtime Windows owner : requise.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
