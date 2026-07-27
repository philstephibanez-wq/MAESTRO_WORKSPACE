# OPUS P117W R17 — UN FICHIER LOGGER ET UN FICHIER PROFILER PAR APPLICATION

Date : 2026-07-27  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Architecture

Conserver uniquement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier entre les applications.

## Décision contractuelle

Conserver exactement un fichier Logger et un fichier Profiler par application :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler/owasys-front.jsonl

sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler/owasys-back.jsonl
```

Ne créer :

```text
aucun fichier Profiler par trace
aucun fichier Profiler par lancement
aucun fichier Profiler par composant
aucun fichier Profiler séparé pour runtime, RCP ou dev-server
```

Ne fusionner ni Logger et Profiler, ni frontend et backend.

## Cause

`Opus\Profiler\Profiler` écrit actuellement :

```text
<storage>/<trace_id>.json
```

Les producteurs utilisent plusieurs répertoires :

```text
var/profiler/runtime
var/profiler/rcp
var/profiler/dev-server
```

Une même application produit donc de nombreux fichiers et plusieurs arborescences Profiler.

Logger respecte déjà le fichier unique par application. Ne pas modifier Logger.

## Évolution générique OPUS

Modifier :

```text
Opus/Profiler/Profiler.php
Opus/Profiler/ProfilerInterface.php
```

Faire résoudre par `Profiler` la racine de l’application OPUS en recherchant `config/site.json` depuis le chemin reçu.

Lire cette configuration via :

```text
File
StructuredFileLoader
```

Valider :

```text
contract = OPUS_SITE_STANDARD_CONTRACT_CORE
site_id
```

Écrire ensuite toute trace dans :

```text
<site-root>/var/profiler/<site_id>.jsonl
```

Ajouter chaque trace sous forme d’une ligne JSON compacte avec :

```text
schema
trace_id
record_id
recorded_at
started_at
duration_ms
memory
summary
event_count
events
```

Autoriser plusieurs enregistrements portant le même `trace_id`, afin de conserver les contributions runtime, REST, Composer et application dans le même fichier.

## Accès Profiler par URL

Conserver le `trace_id` au premier niveau de chaque ligne.

Ajouter au contrat Profiler :

```text
readTrace(string $traceId): array
```

Cette méthode doit parcourir l’unique fichier JSONL de l’application et retourner tous les enregistrements portant ce `trace_id`.

Ne modifier aucune route ni aucun rendu SCORE dans R17. Le lecteur appelé par URL dispose ainsi d’un accès stable par `trace_id` sans dépendre d’un fichier `<trace_id>.json`.

## Comportement hors application

Lorsqu’aucune racine OPUS contenant `config/site.json` n’est trouvée :

```text
chemin *.jsonl explicite -> utiliser ce fichier
répertoire explicite     -> utiliser <répertoire>/opus-profiler.jsonl
```

Ce comportement concerne les usages framework isolés et les tests. Il ne change pas la règle d’un fichier par application.

## Livrable

```text
ZIP : opus_p117w_r17_single_log_and_profiler_file_per_application.zip
SHA-256 : adbd3d3a67d0d1af5bb6604f3892bb041251005a77b175fa293f8e18fc443385
Fichiers : 2
Octets ZIP : 3218
Octets non compressés : 9344
```

Inclure uniquement :

```text
Opus/Profiler/Profiler.php
Opus/Profiler/ProfilerInterface.php
```

Ne livrer aucun `tools`, aucun script, aucun fichier runtime, aucun journal, aucun secret et aucune racine partagée.

## Validation effectuée

```text
PHP lint Profiler.php                         : OK
PHP lint ProfilerInterface.php                : OK
Trois producteurs simulés                     : runtime, RCP, dev-server
Fichier Profiler obtenu                       : test-app.jsonl
Nombre total de fichiers Profiler             : 1
Nombre de lignes                               : 3
Deux enregistrements avec le même trace_id     : retrouvés par readTrace()
Chaque ligne JSON                              : valide
Chemins interdits dans le ZIP                  : 0
```

Marqueur :

```text
P117W_R17_SINGLE_LOG_PROFILER_OK
```

## Nettoyage owner confirmé

Les anciens répertoires et fichiers `*.json` sous les seules racines suivantes deviennent obsolètes après application et arrêt des serveurs :

```text
sites/owasys-front/var/profiler
sites/owasys-back/var/profiler
```

Ne supprimer aucun Logger et aucun autre chemin sous `var`.

Ne pas présenter la validation isolée comme une validation runtime Windows owner.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
