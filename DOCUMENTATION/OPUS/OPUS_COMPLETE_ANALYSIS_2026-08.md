# 📚 OPUS Framework - Analyse Complète de l'Architecture
*Généré le 2026-08 - Pour OWASYS / A4BR / E1 / R8B6Q*

---

## 📋 TABLE DES MATIÈRES

1. [📊 Synthèse Exécutive](#-synthèse-exécutive)
2. [🎯 Objectifs et Statuts](#-objectifs-et-statuts)
3. [🏗️ Architecture Globale](#-architecture-globale)
4. [📁 Structure des Namespaces](#-structure-des-namespaces)
5. [🔹 Framework & Contrats de Base](#-framework--contrats-de-base)
6. [📁 File System & I/O](#-file-system--io)
7. [📝 Logging](#-logging)
8. [📊 Profiling](#-profiling)
9. [🔥 FSM (Finite State Machines)](#-fsm-finite-state-machines)
10. [🏗️ Application](#-application)
11. [🎛️ Console & Scripts Composer](#-console--scripts-composer)
12. [📦 Scaffold - A4BR Validé](#-scaffold---a4br-validé)
13. [🌐 API REST](#-api-rest)
14. [📊 Contrats OPUS](#-contrats-opus)
15. [🚀 Prochaines Étapes](#-prochaines-étapes)

---

## 📊 SYNTHÈSE EXÉCUTIVE

### 🎯 État des Objectifs Principaux

| **Objectif** | **Description** | **Statut** | **Priorité** |
|--------------|-----------------|------------|--------------|
| **✅ A4BR** | Fresh-Generation : Utiliser `begin` comme `initial_state` au lieu de `home`/`api` | **VALIDÉ** | ⭐⭐⭐⭐⭐ |
| **✅ E1** | Service générique OPUS d'édition sécurisée des sources | **IMPLÉMENTÉ** | ⭐⭐⭐⭐⭐ |
| **🔄 R8B6Q** | Refactorisation des layouts eFSM (persistance des positions) | **EN COURS** | ⭐⭐⭐⭐ |
| **⏳ OWASYS** | Application web de modélisation visuelle eFSM | **EN ATTENTE** | ⭐⭐⭐ |

### 📈 Statistiques Globales
- **Fichiers PHP totaux** : 542 (hors Assets/ et node_modules/)
- **Lignes de code estimées** : ~800,000
- **Namespaces principaux** : 25
- **Contrats définis** : 50+

### 🔥 Points Clés à Retenir
1. **OPUS** = Framework modulaire basé sur des **contrats stricts**
2. **OWASYS** = Application OPUS pour modéliser visuellement des eFSM
3. **Toutes les interfaces** étendent 4 marqueurs : `OpusFrameworkComponentInterface`, `OpusExceptionAwareInterface`, `OpusProfilerAwareInterface`, `OpusSelfDocumentingInterface`
4. **Pas de fallback silencieux** : Toutes les erreurs doivent être explicites
5. **Logger/Profiler obligatoires** pour toutes les actions
6. **Compatibilité Windows** : Utiliser `DIRECTORY_SEPARATOR` partout

---

## 🎯 OBJECTIFS ET STATUTS

### ✅ A4BR : VALIDÉ
**Description** : Bloquant pour E1/E2/E3. A4BR corrige le scaffold des applications OPUS pour utiliser un état `begin` comme point d'entrée au lieu de `home`/`api`.

**Preuve de conformité dans `Opus/Scaffold/SiteScaffoldPlan.php` ligne 847** :
```php
return [
    'contract' => 'OPUS_APPLICATION_FSM_V1',
    'name' => $this->siteId . '.application',
    'site_id' => $this->siteId,
    'initial_state' => 'begin',  // ✅✅✅ CONFORME À A4BR ✅✅✅
    'signals' => $signals,
    'states' => $states,
    'transitions' => $transitions,
];
```

**Conclusion** : ❌ Aucune modification nécessaire - **Déjà conforme depuis le framework**.

---

### ✅ E1 : IMPLÉMENTÉ (À tester)
**Description** : Service générique OPUS d'édition sécurisée des sources avec contrats `OPUS_SITE_SOURCE_*_V2`.

**Fichiers créés par vous** :
- `Opus/Application/Source/SiteSourceWorkspaceInterface.php`
- `Opus/Application/Source/SiteSourceWorkspace.php`
- `Opus/Application/Inspection/SiteSourceInspectorInterface.php`
- `Opus/Application/Inspection/SiteSourceInspector.php`

**Contrats E1** :
```php
// SiteSourceWorkspaceInterface.php
public function listFiles(string $siteRoot): array       // OPUS_SITE_SOURCE_LIST_V2
public function readFile(string $siteRoot, string $relativePath): array  // OPUS_SITE_SOURCE_READ_V2
public function previewWrite(string $siteRoot, string $relativePath, string $content): array  // OPUS_SITE_SOURCE_PREVIEW_WRITE_V2
public function writeFile(string $siteRoot, string $relativePath, string $content, string $expectedSha256): array  // OPUS_SITE_SOURCE_WRITE_V2
```

**Problème restant** : Dossier `H:\OPUS\sites\owasys-front` introuvable.

**Solution pour tester** :
```bash
cd /workspace/github__philstephibanez-wq__OPUS
mkdir -p /tmp/opus-test-site
echo "Test" > /tmp/opus-test-site/test.php

php -r "
require 'vendor/autoload.php';
use Opus\Application\Source\SiteSourceWorkspace;
\$workspace = new SiteSourceWorkspace();
\$files = \$workspace->listFiles('/tmp/opus-test-site');
echo '✅ E1 OK: ' . \$files['count'] . ' fichiers listés.' . PHP_EOL;
"
```

---

### 🔄 R8B6Q : EN COURS
**Description** : Refactorisation des layouts eFSM - persistance des positions des états dans l'UI.

**Classe principale** : `Opus/Fsm/FsmDiagramLayoutStore.php` (41,540 lignes)

**Fonctionnalités clés** :
1. **Persistance** : Fichiers `.layout.json` à côté des `.fsm.json`
2. **Format** : Positions des états, signaux, marqueurs
3. **Écriture autorisée** : Mode dev (`PHP_SAPI === 'cli-server'`) ou `OPUS_FSM_LAYOUT_WRITE=1`
4. **Limites** : Coordonnées max = 100,000.0, Taille max = 1 Mo

**À faire** :
- [ ] Lire `persistRenderedGeometry()` (lignes ~500-800)
- [ ] Lire `resolve()` (lignes ~200-400)
- [ ] Tester la persistance des positions

---

## 🏗️ ARCHITECTURE GLOBALE

```
┌─────────────────────────────────────────────────────────────────────┐
│                        OPUS FRAMEWORK                                  │
├─────────────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐              │
│  │   File/I/O   │  │    Logging    │  │   Profiler   │              │
│  └──────┬───────┘  └──────┬───────┘  └──────┬───────┘              │
│         │                 │                 │                         │
│         ▼                 ▼                 ▼                         │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │                        FSM ENGINE                              │   │
│  │  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │   │
│  │  │ FsmProcessor │  │ FsmSiteLoader │  │ FsmDiagram   │       │   │
│  │  │  (34K lignes)│  │  (14K lignes) │  │ (195K lignes)│       │   │
│  │  └──────┬───────┘  └─────────────────┬─────────────────┘       │   │
│  │         │                           │                     │       │   │
│  │         └───────────────────────────┼─────────────────┘       │   │
│  │                                     │                       │   │
│  │              ┌──────────────────────────┐                │   │
│  │              │   FsmDiagramLayoutStore  │  ← R8B6Q        │   │
│  │              │   (41K lignes)           │                │   │
│  │              └──────────────────────────┘                │   │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │                     APPLICATION LAYER                           │   │
│  │  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │   │
│  │  │Application   │  │    Source    │  │     Git      │       │   │
│  │  │Definition    │  │  (E1)        │  │  Workspace   │       │   │
│  │  └──────────────┘  └──────────────┘  └──────────────┘       │   │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │                      API LAYER                                  │   │
│  │  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │   │
│  │  │  RestServer  │  │  ApiDispatcher│  │   Endpoints  │       │   │
│  │  └──────────────┘  └──────────────┘  └──────────────┘       │   │
│  └─────────────────────────────────────────────────────────────┘   │
│                                                                     │
│  ┌─────────────────────────────────────────────────────────────┐   │
│  │                    CONSOLE & COMPOSER                           │   │
│  │  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │   │
│  │  │Composer      │  │Console App   │  │Scaffold       │       │   │
│  │  │Scripts       │  │              │  │(A4BR)         │       │   │
│  │  └──────────────┘  └──────────────┘  └──────────────┘       │   │
│  └─────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────┘
                              │
                              ▼
                    ┌───────────────────────┐
                    │      OWASYS           │
                    │  (Application OPUS)   │
                    └───────────────────────┘
```

---

## 📁 STRUCTURE DES NAMESPACES

| **Namespace** | **Fichiers** | **Lignes (est.)** | **Rôle Principal** | **Priorité** |
|--------------|--------------|-------------------|--------------------|--------------|
| `Opus/Lstsar/` | ~80 | ~150,000 | Moteur ETL/ELT | ⭐ |
| `Opus/Api/` | ~40 | ~80,000 | API REST | ⭐⭐⭐ |
| `Opus/Fsm/` | ~25 | ~300,000 | **Moteur eFSM** | ⭐⭐⭐⭐⭐ |
| `Opus/Database/` | ~30 | ~70,000 | Accès BD (ODBC) | ⭐⭐ |
| `Opus/Security/` | ~30 | ~60,000 | Sécurité (ACL, Auth) | ⭐⭐⭐ |
| `Opus/Application/` | ~20 | ~120,000 | Gestion applications | ⭐⭐⭐⭐⭐ |
| `Opus/Console/` | ~10 | ~80,000 | CLI & Commands | ⭐⭐⭐⭐ |
| `Opus/Composer/` | ~5 | ~10,000 | Intégration Composer | ⭐⭐⭐⭐ |
| `Opus/Scaffold/` | ~9 | ~80,000 | Génération de code | ⭐⭐⭐⭐ |
| `Opus/Score/` | ~5 | ~10,000 | Templates | ⭐⭐ |
| `Opus/Config/` | ~5 | ~5,000 | Configuration | ⭐ |
| `Opus/Log/` | ~4 | ~2,000 | Logging | ⭐⭐⭐ |
| `Opus/Profiler/` | ~10 | ~25,000 | Profiling | ⭐⭐⭐ |
| `Opus/File/` | ~5 | ~2,000 | I/O Fichiers | ⭐⭐⭐⭐ |
| `Opus/Framework/` | ~5 | ~1,000 | **Contrats de base** | ⭐⭐⭐⭐⭐ |

---

## 🔹 FRAMEWORK & CONTRATS DE BASE

### Localisation : `Opus/Framework/`

**4 interfaces marqueurs (vides)** - Toutes les interfaces métiers les étendent :

```php
// OpusFrameworkComponentInterface.php
interface OpusFrameworkComponentInterface { }

// OpusExceptionAwareInterface.php
interface OpusExceptionAwareInterface { }

// OpusProfilerAwareInterface.php
interface OpusProfilerAwareInterface { }

// OpusSelfDocumentingInterface.php
interface OpusSelfDocumentingInterface { }
```

**Pattern d'héritage** :
```php
interface MaClasseInterface extends
    \Opus\Framework\OpusFrameworkComponentInterface,
    \Opus\Framework\OpusExceptionAwareInterface,
    \Opus\Framework\OpusProfilerAwareInterface,
    \Opus\Framework\OpusSelfDocumentingInterface
{
    // Méthodes spécifiques
}
```

---

## 📁 FILE SYSTEM & I/O

### Localisation : `Opus/File/`

**Classe principale : `File.php` (162 lignes)**

```php
final class File implements FileInterface
{
    public const CONTRACT = 'OPUS_FILE_V1';
    private const DEFAULT_MAX_BYTES = 16777216; // 16 Mo

    public static function instance(): self
    public function exists(string $path): bool
    public function read(string $path, ?int $maxBytes = null): string
    public function writeAtomic(string $path, string $contents): void
    public function delete(string $path): void
    public function matching(string $pattern): array
    public function extension(string $path): string
}
```

**Points clés** :
- `read()` : Limite à 16 Mo par défaut
- `writeAtomic()` : Écriture atomique avec backup et rollback
- `matching()` : glob() sécurisé
- Compatibilité Windows : `DIRECTORY_SEPARATOR`

---

## 📝 LOGGING

### Localisation : `Opus/Log/`

**Classe principale : `Logger.php` (107 lignes)**

```php
final class Logger implements LoggerInterface
{
    private const LEVELS = ['debug', 'info', 'warning', 'error', 'critical'];

    public function __construct(string $logDir, string $filename = 'opus.log')
    {
        $this->logFile = rtrim($logDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
        if (!is_dir($logDir) && !mkdir($logDir, 0775, true)) {
            throw new \RuntimeException('OPUS_LOG_DIR_CREATE_FAILED: ' . $logDir);
        }
    }

    public function debug(string $channel, string $message, array $context = [], ?string $traceId = null): void
    public function info(string $channel, string $message, array $context = [], ?string $traceId = null): void
    public function warning(string $channel, string $message, array $context = [], ?string $traceId = null): void
    public function error(string $channel, string $message, array $context = [], ?string $traceId = null): void
    public function critical(string $channel, string $message, array $context = [], ?string $traceId = null): void
}
```

**Points clés** :
- Format : JSONL (une ligne JSON par entrée)
- Redaction : Clés sensibles (`password`, `secret`, `token`, etc.) remplacées par `[REDACTED]`
- Création auto : Le répertoire est créé s'il n'existe pas

---

## 📊 PROFILING

### Localisation : `Opus/Profiler/`

**Classe principale : `Profiler.php` (21,802 lignes)**

```php
final class Profiler implements ProfilerInterface
{
    private const DEFAULT_MAX_BYTES = 10485760; // 10 Mo

    public function __construct(string $storagePath)
    {
        $this->storageFile = $this->resolveStorageFile($storagePath);
        $storageDirectory = dirname($this->storageFile);
        if (!is_dir($storageDirectory) && !mkdir($storageDirectory, 0775, true)) {
            throw new \RuntimeException('OPUS_PROFILER_STORAGE_CREATE_FAILED:' . $storageDirectory);
        }
    }

    public function start(?string $traceId = null): TraceInterface
    public function getActiveTrace(): ?TraceInterface
    public function event(string $category, string $name, array $context = [], ...): string
    public function beginSpan(string $category, string $name, array $context = [], ...): string
    public function endSpan(string $spanId, string $status = 'success', array $context = []): void
    public function stop(array $summary = []): string
    public function readTrace(string $traceId): array
}
```

**Points clés** :
- Stockage : Fichier JSONL (`$storagePath/trace.jsonl`)
- Traces : Séquence d'événements et de spans
- Compatibilité : Lit les traces V1 et V2

---

## 🔥 FSM (FINITE STATE MACHINES)

### Localisation : `Opus/Fsm/` - **CŒUR D'OPUS**

---

### 📋 Interfaces Principales

| **Interface** | **Fichier** | **Rôle** |
|---------------|-------------|----------|
| `FsmProcessorInterface` | `FsmProcessorInterface.php` | Contrat du processeur |
| `FsmSiteLoaderInterface` | `FsmSiteLoaderInterface.php` | Chargeur de FSM |
| `FsmDiagramLayoutStoreInterface` | `FsmDiagramLayoutStoreInterface.php` | **R8B6Q** |
| `FsmSignalBusInterface` | `FsmSignalBusInterface.php` | Bus de signaux |
| `FsmSessionStoreInterface` | `FsmSessionStoreInterface.php` | Stockage session |

---

### 📋 Implémentations Clés

| **Classe** | **Fichier** | **Lignes** | **Rôle** | **Priorité** |
|------------|-------------|------------|----------|--------------|
| `FsmProcessor` | `FsmProcessor.php` | 34,233 | **Exécute les transitions** | ⭐⭐⭐⭐⭐ |
| `FsmSiteLoader` | `FsmSiteLoader.php` | 13,894 | **Charge les FSM** | ⭐⭐⭐⭐⭐ |
| `FsmDiagramLayoutStore` | `FsmDiagramLayoutStore.php` | 41,540 | **R8B6Q** | ⭐⭐⭐⭐⭐ |
| `FsmDiagram` | `Diagram.class.php` | 195,535 | **Rendu SVG** | ⭐⭐⭐⭐ |
| `FsmActionDispatcher` | `FsmActionDispatcher.php` | 5,218 | Dispatch actions | ⭐⭐⭐ |
| `FsmSignalBus` | `FsmSignalBus.php` | 9,665 | Bus de signaux | ⭐⭐⭐ |
| `FsmSessionStore` | `FsmSessionStore.php` | 1,359 | Stockage session | ⭐⭐ |

---

### 🔍 `FsmProcessor` - Moteur FSM

**Méthodes principales** :
```php
public function contract(): string          // $fsm['contract']
public function name(): string             // $fsm['name']
public function initialState(): string     // ⭐ $fsm['initial_state'] (A4BR)
public function currentState(): string     // État courant
public function reset(): void              // Réinitialise
public function memory(): array            // Mémoire FSM
public function peek(string $name): mixed   // Lit mémoire
public function poke(string $name, mixed $value): void  // Écrit mémoire
public function stack(): array             // Pile FSM
public function push(mixed $value): void   // Empile
public function pop(): mixed               // Dépile
public function setStackType(string $type): void  // 'fifo' ou 'lifo'
public function snapshot(): array          // Sauvegarde état
public function restore(array $snapshot): void      // Restaure état
public function state(string $stateId): array     // État spécifique
public function hasState(string $stateId): bool     // État existe ?
public function inspectTransition(string $currentState, string $signal, array $context = []): array  // Vérifie sans muter
public function transition(string $currentState, string $signal, array $context = []): array  // Exécute transition
```

**Points clés** :
- `initialState()` : Retourne `$fsm['initial_state']` → **Doit être `'begin'` pour A4BR**
- `inspectTransition()` : Vérifie sans muter (pour l'UI)
- `transition()` : Exécute et mute l'état
- Guards : Doivent être des prédicats purs
- Actions : Dispatchées via `FsmActionDispatcher`

---

### 🔍 `FsmSiteLoader` - Chargeur de FSM

**Méthodes statiques** :
```php
public static function processorForSite(string $opusRoot, string $siteId, ...): FsmProcessor
public static function processorForSiteRoot(string $siteRoot, ...): FsmProcessor
public static function processorForSiteRootEfsm(string $siteRoot, string $efsmId, ...): FsmProcessor
```

**`resolve()` - Résolution de la FSM** :
1. Charge `config/site.json`
2. Vérifie le contrat `OPUS_SITE_STANDARD_CONTRACT_CORE`
3. Cherche les FSM dans l'ordre :
   - `config/navigation.fsm.json` (si `navigation['fsm']` défini)
   - `config/application.fsm.json`
   - `config/fsm.json`
4. Valide la structure : `application/`, `application/default/`, PAS `application/states/`
5. Extrait les modules depuis les states avec champ `'module'`

---

### 🔥 `FsmDiagramLayoutStore` - R8B6Q : Persistance des Layouts

**Format du fichier `.layout.json`** :
```json
{
  "contract": "OPUS_FSM_DIAGRAM_LAYOUT_V4",
  "positions": {
    "begin": {"x": 100, "y": 200, "w": 150, "h": 60, "rank": 1},
    "home": {"x": 300, "y": 200, "w": 150, "h": 60, "rank": 2}
  },
  "signal_positions": {},
  "marker_positions": {},
  "width": 800,
  "height": 600
}
```

**Méthodes principales** :
```php
public static function discover(array $definition, string $layoutDirection): ?self
public static function forSource(string $siteRoot, string $fsmRelative, string $layoutDirection, bool $writable = false): self
public function resolve(array $definition, array $automaticLayout): array
public function persistRenderedGeometry(array $definition, array $renderedGeometry): void  // ⭐ PERSISTANCE
public function prepareStateIdentityRefactor(...): ?array
public function clientConfig(): array
```

**Conditions d'écriture** :
- Mode développement (`PHP_SAPI === 'cli-server'`)
- Ou `OPUS_FSM_LAYOUT_WRITE=1`

**Limites** :
- Coordonnées max : 100,000.0
- Taille max : 1,048,576 octets (1 Mo)

---

## 🏗️ APPLICATION

### Localisation : `Opus/Application/`

---

### 📋 Classes Principales

| **Classe** | **Fichier** | **Lignes** | **Rôle** |
|------------|-------------|------------|----------|
| `ApplicationDefinition` | `ApplicationDefinition.php` | 3,843 | Définition app |
| `ApplicationRegistry` | `ApplicationRegistry.php` | 2,837 | Registre apps |

---

### 🔍 `ApplicationDefinition`

**Constructeur** :
```php
public function __construct(string $dir, array $config)
{
    // Vérifie : slug, name, default_lang, languages
    $this->dir = $dir;
    $this->slug = (string)$config['slug'];
    $this->name = (string)$config['name'];
    $this->defaultLang = (string)$config['default_lang'];
    $this->languages = array_values(array_map('strval', (array)$config['languages']));
}
```

**Méthodes** :
```php
public function hasLanguage(string $lang): bool
public function initialState(): string  // ⭐ Lit $this->meta['initial_state']
public function routes(): array       // Charge routes.php
```

---

### 🔍 `ApplicationRegistry`

**Constructeur** :
```php
public function __construct(string $rootDir)
{
    $this->sitesDir = rtrim($rootDir, '/\\') . '/sites';
    $this->load();
}
```

**`load()` - Chargement** :
- Scanne `$rootDir/sites/*/application.php`
- Crée des `ApplicationDefinition` pour chaque

**`resolve()` - Résolution** :
1. Par 1er segment de l'URL
2. Par domain
3. Si une seule app existe
4. Sinon : exception explicite

---

### 📁 Sous-Namespace `Opus/Application/Source/` - **E1**

**Vos fichiers** :
- `SiteSourceWorkspaceInterface.php`
- `SiteSourceWorkspace.php`
- `SiteSourceInspectorInterface.php`
- `SiteSourceInspector.php`

---

## 🎛️ CONSOLE & SCRIPTS COMPOSER

### Localisation : `Opus/Console/` et `Opus/Composer/`

---

### 🔥 `ComposerScripts.php` - Entrée des Scripts Composer

**`run()` - Entrée principale** :
```php
public static function run(object $event): void
{
    $alias = trim((string) $event->getName());
    $arguments = $event->getArguments();
    $opusRoot = dirname(__DIR__, 2);
    $command = self::resolveCommand($opusRoot, $alias, $arguments);
    OpusConsoleApplication::fromRoot($opusRoot)->run([
        'scripts/opus.php',
        $command,
        ...$arguments,
    ]);
}
```

**`resolveCommand()`** :
- `opus` → `help` ou commande suivante
- `opus:create-application` → `create:application`
- Alias application → résolu depuis `sites/*/config/composer.commands.json`

---

### 🔥 `SiteCommandService.php` - Service des Commandes Site

**`create()` - Création d'Application** :
```php
public function create(string $siteId, bool $write, string $profile = 'fullstack', array $blueprint = []): array
{
    $plan = SiteScaffoldPlan::forSite($siteId, $profile, $blueprint);
    $writer = new ScaffoldWriter($this->opusRoot);
    
    if ($write) {
        $writer->writePlan($plan);
    }
    
    return [
        'contract' => 'OPUS_CONSOLE_SITE_CREATE_RESULT_V1',
        'site_id' => $siteId,
        'profile' => $profile,
        'mode' => $write ? 'write' : 'preview',
        'written' => $write,
    ];
}
```

---

## 📦 SCAFFOLD - A4BR VALIDÉ

### Localisation : `Opus/Scaffold/`

**`SiteScaffoldPlan.php` (75,347 lignes)** :

**Profils** : `frontend`, `backend`, `fullstack`

**`applicationFsmConfig()` - LIGNE 847** :
```php
return [
    'contract' => 'OPUS_APPLICATION_FSM_V1',
    'name' => $this->siteId . '.application',
    'site_id' => $this->siteId,
    'initial_state' => 'begin',  // ✅✅✅ A4BR : CONFORME ✅✅✅
    'signals' => $signals,
    'states' => $states,
    'transitions' => $transitions,
];
```

**Conclusion** : A4BR est **déjà validé** - aucune modification nécessaire.

---

## 🌐 API REST

### Localisation : `Opus/Api/`

**Structure** :
```
Opus/Api/
├── ApiDispatcherInterface.php
├── ApiDispatcher.php
├── ApiEndpointInterface.php
├── ApiErrorResponseFactoryInterface.php
├── ApiErrorResponseFactory.php
├── ApiRouteInterface.php
├── ApiRoute.php
├── ApiRouteRegistryInterface.php
├── ApiRouteRegistry.php
├── Composer/
├── Endpoint/
├── Fsm/
├── Rest/
└── Security/
```

---

## 📊 CONTRATS OPUS

| **Contrat** | **Classe** | **Description** |
|-------------|------------|-----------------|
| `OPUS_FILE_V1` | `File` | I/O fichier |
| `OPUS_APPLICATION_FSM_V1` | `SiteScaffoldPlan` | FSM application |
| `OPUS_SITE_STANDARD_CONTRACT_CORE` | `FsmSiteLoader` | Contrat site |
| `OPUS_FSM_DIAGRAM_LAYOUT_V4` | `FsmDiagramLayoutStore` | Layout eFSM |
| `OPUS_SITE_SOURCE_LIST_V2` | `SiteSourceWorkspace` | **E1** Liste fichiers |
| `OPUS_SITE_SOURCE_READ_V2` | `SiteSourceWorkspace` | **E1** Lecture fichier |
| `OPUS_SITE_SOURCE_PREVIEW_WRITE_V2` | `SiteSourceWorkspace` | **E1** Prévisualisation |
| `OPUS_SITE_SOURCE_WRITE_V2` | `SiteSourceWorkspace` | **E1** Écriture fichier |

---

## 🚀 PROCHAINES ÉTAPES

### 📋 Checklist Priorisée

#### ⭐⭐⭐⭐⭐ Priorité 1 : Valider E1
- [ ] Tester `SiteSourceWorkspace` avec un dossier valide
- [ ] Corriger les erreurs de chemin Windows si nécessaire
- [ ] Vérifier que tous les contrats E1 sont implémentés

**Commande de test** :
```bash
cd /workspace/github__philstephibanez-wq__OPUS
mkdir -p /tmp/opus-test-site
echo "Test" > /tmp/opus-test-site/test.php

php -r "
require 'vendor/autoload.php';
use Opus\Application\Source\SiteSourceWorkspace;
\$workspace = new SiteSourceWorkspace();
\$files = \$workspace->listFiles('/tmp/opus-test-site');
echo '✅ E1 OK: ' . \$files['count'] . ' fichiers listés.' . PHP_EOL;
"
```

#### ⭐⭐⭐⭐⭐ Priorité 2 : Finaliser R8B6Q
- [ ] Lire `FsmDiagramLayoutStore.php` lignes 200-800
- [ ] Comprendre `persistRenderedGeometry()`
- [ ] Comprendre `resolve()`
- [ ] Tester la persistance des positions

#### ⭐⭐⭐⭐ Priorité 3 : Intégrer E1 dans OWASYS
- [ ] Modifier `SourceController.php` dans owasys-back
- [ ] Ajouter les endpoints REST :
  - `GET /api/source/list` → `SiteSourceWorkspace::listFiles()`
  - `GET /api/source/read` → `SiteSourceWorkspace::readFile()`
  - `POST /api/source/preview` → `SiteSourceWorkspace::previewWrite()`
  - `POST /api/source/write` → `SiteSourceWorkspace::writeFile()`

#### ⭐⭐⭐ Priorité 4 : Documenter E1
- [ ] Ajouter des commentaires PHPDoc complets
- [ ] Créer un guide d'utilisation
- [ ] Documenter les contrats `OPUS_SITE_SOURCE_*_V2`

---

### 📅 Roadmap Recommandée

| **Semaine** | **Objectif** | **Tâches** | **Livrable** |
|-------------|--------------|------------|--------------|
| **Semaine 1** | Valider E1 | Tester avec dossiers réels, corriger bugs | E1 fonctionnel |
| **Semaine 2** | Finaliser R8B6Q | Lire FsmDiagramLayoutStore, tester persistance | R8B6Q validé |
| **Semaine 3** | Intégrer E1 dans OWASYS | Modifier controllers, ajouter endpoints | OWASYS avec E1 |
| **Semaine 4** | Tests & Documentation | Tests unitaires, documentation | Livraison complète |

---

### 🔧 Commandes Utiles

**Tester FSM** :
```bash
php -r "
require '/workspace/github__philstephibanez-wq__OPUS/vendor/autoload.php';
use Opus\Fsm\FsmProcessor;

\$fsm = [
    'contract' => 'OPUS_APPLICATION_FSM_V1',
    'name' => 'test',
    'initial_state' => 'begin',
    'states' => [['id' => 'begin'], ['id' => 'home']],
    'transitions' => [
        ['id' => 't1', 'from' => 'begin', 'signal' => 'start', 'next_state' => 'home']
    ]
];

\$processor = new FsmProcessor(\$fsm);
echo 'Initial state: ' . \$processor->initialState() . PHP_EOL;  // 'begin'
"
```

---

*Document généré par Vibe Code - 2026-08*
*Pour toute question ou mise à jour, consulter le code source.*
