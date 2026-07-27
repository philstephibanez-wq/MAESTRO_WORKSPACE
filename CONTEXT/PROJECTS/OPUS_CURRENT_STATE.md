# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-27.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 7f672643c345a2a7b9f665773fffe36f60dc5132
Racine owner : H:/OPUS
```

## Architecture

Conserver uniquement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Ne partager aucun fichier, dossier, volume, configuration, secret, manifeste ou état runtime.

Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Résultats acquis

```text
P117W R6  : supprimer le chargement croisé
P117W R7  : valider les sites propres
P117W R8  : aligner le contrat d’environnement
P117W R9  : restaurer I18n et les bindings réseau
P117W R10 : centraliser dev, test et prod dans config/site.json
P117W R11 : supprimer l’accès Registry local du frontend
P117W R12 : lancer sans préparation manuelle de secrets en dev
P117W R13 : lire host et port depuis la configuration
P117W R14 : cibler le provider Composer backend
P117W R15 : restaurer la FSM frontend canonique
P117W R16 : restaurer les alias de commandes applicatives
```

## Développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Utiliser :

```text
composer opus:dev-server -- owasys-front
composer opus:dev-server -- owasys-back
```

## Cause P117W R17

Le Profiler écrit actuellement un fichier JSON par trace :

```text
<storage>/<trace_id>.json
```

Les producteurs utilisent plusieurs répertoires :

```text
var/profiler/runtime
var/profiler/rcp
var/profiler/dev-server
```

Une même application produit donc de nombreux fichiers Profiler.

Logger écrit déjà dans un fichier unique par application :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-back/var/logs/owasys-back.log
```

Ne pas modifier Logger.

## Correction P117W R17

Modifier uniquement :

```text
Opus/Profiler/Profiler.php
Opus/Profiler/ProfilerInterface.php
```

Résoudre la racine de l’application via `config/site.json`, lu avec `File` et `StructuredFileLoader`.

Faire converger tous les producteurs vers :

```text
sites/owasys-front/var/profiler/owasys-front.jsonl
sites/owasys-back/var/profiler/owasys-back.jsonl
```

Ajouter une ligne JSON compacte par enregistrement Profiler.

Conserver au premier niveau :

```text
trace_id
record_id
recorded_at
```

Autoriser plusieurs enregistrements portant le même `trace_id` pour conserver les contributions application, REST, Composer et dev-server.

Ajouter au contrat :

```text
readTrace(string $traceId): array
```

Cette méthode permet au lecteur Profiler appelé par URL de retrouver tous les enregistrements du trace sans dépendre d’un fichier `<trace_id>.json`.

## Livrable actif

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
PHP lint                               : OK
Trois producteurs simulés             : runtime, RCP, dev-server
Nombre de fichiers Profiler obtenu    : 1
Format                                 : JSONL
Plusieurs records pour un trace_id    : OK
Lecture readTrace()                    : OK
Chemins interdits                      : 0
ZIP                                    : OK
```

## Appliquer et valider côté owner

```text
php -l Opus/Profiler/Profiler.php
php -l Opus/Profiler/ProfilerInterface.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Statut

```text
P117W R6 à R16 : présents/appliqués
P117W R17 : actif à appliquer
```

## Contrats framework

Faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php`.

Faire étendre directement chaque interface homonyme par :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Lire toute configuration via `File` et `StructuredFileLoader`. Imposer Logger et Profiler. Interdire tout fallback silencieux.
