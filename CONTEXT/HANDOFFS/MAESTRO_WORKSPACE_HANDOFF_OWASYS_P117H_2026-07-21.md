# MAESTRO_WORKSPACE — Handoff OWASYS P117H

**Date :** 2026-07-21  
**Dépôt code relu :** `philstephibanez-wq/OPUS`  
**Branche :** `master`  
**Commit :** `e43955ff2a3db1056fdf2d6887432d11bae50bf1` (`p117f`)

## Incident bloquant

Après suppression locale correcte de `Opus/Owasys`, OWASYS échoue au chargement du Registry :

```text
Class "Opus\Owasys\RegistryRepository" not found
```

La cause est `sites/owasys/application/registry/models/RegistryModel.php`, qui dépend encore explicitement de `Opus\Owasys\RegistryRepository`.

Cette dépendance est contraire au sens autorisé :

```text
OWASYS -> OPUS Framework
```

Le framework ne doit contenir aucune classe propre à OWASYS.

## Correction P117H

Le Repository SQLite devient une classe applicative :

```text
sites/owasys/application/registry/repositories/RegistryRepository.php
OwasysRegistryRepository
```

Le front controller le charge avant `RegistryModel.php`.

La base existante est conservée :

```text
sites/owasys/var/registry/owasys.sqlite
```

Le correctif ne recrée aucun fichier sous `Opus/Owasys` et ne dépend plus du namespace `Opus\Owasys`.

## Mermaid P117G intégré dans P117H

P117H finalise également le travail P117G interrompu :

- couleur explicite des lignes d’action ;
- pointe de flèche SVG visible ;
- nœuds cliquables ;
- activation clavier Entrée/Espace ;
- vérification stricte que chaque route ACL autorisée est liée à un nœud ;
- cache-busting `p117h` pour CSS et JavaScript.

La FSM fonctionnelle, ACL et SSO ne sont pas modifiés.

## ODBCExplorer

L’audit distingue :

```text
Opus/OdbcExplorer
  moteur générique ODBC réutilisable

sites/odbcexplorer
  future application autonome OPUS
```

Le moteur framework peut rester sous `Opus/` uniquement s’il ne contient aucune route, page, template, menu ou logique applicative.

L’ancien `packages/opus-odbc-manager` est une référence historique à migrer. Il ne constitue pas la cible runtime conforme.

## ZIP

Nom :

```text
owasys_p117h_registry_boundary_mermaid.zip
```

Contenu :

```text
sites/owasys/application/default/services/FsmMermaidBuilder.php
sites/owasys/application/default/services/ScorePageRenderer.php
sites/owasys/application/registry/models/RegistryModel.php
sites/owasys/application/registry/repositories/RegistryRepository.php
sites/owasys/www/asset/css/fsm-mermaid.css
sites/owasys/www/asset/js/fsm-mermaid.js
sites/owasys/www/index.php
```

Aucun Markdown, smoke, manifeste, script racine ou fichier sous `Opus/Owasys`.

## Nettoyage obligatoire

Après extraction, supprimer localement le répertoire interdit s’il existe encore :

```text
Opus/Owasys
```

Ne pas supprimer `Opus/OdbcExplorer` dans ce jalon.

## Validation attendue

1. OWASYS démarre sans chercher `Opus/Owasys/RegistryRepository.php`.
2. Le Registry affiche ses applications et conserve la base SQLite existante.
3. La sélection d’application produit la transition FSM `select_app`.
4. Le schéma Mermaid affiche des pointes de flèches visibles.
5. Chaque nœud autorisé navigue au clic, avec Entrée et avec Espace.
6. Login SSO et décisions ACL restent inchangés.
7. Aucun répertoire `Opus/Owasys` n’est restauré.
