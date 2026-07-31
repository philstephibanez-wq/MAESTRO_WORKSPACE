# MAESTRO_WORKSPACE — Handoff OPUS P117W R46C3

Date : 2026-07-31

## Base exacte

- OPUS GitHub : `9572f4fa264e21205cd3e4a81f2d19db5a4cc0c6` — `opus_p117w_r46c1_profiler_score_iframe`.
- R46C1 est poussé : iframe et route same-origin présentes.
- R46C2 a été appliqué localement puis rejeté par la recette : `OPUS_ACL_DENIED` inchangé.
- R46C2 ne doit pas être committé/poussé.

## Preuve de cause

La page principale et la route iframe sont deux requêtes distinctes. Les trois contrôleurs OWASYS ouvrent la session configurée par `auth.session_name`, tandis que `OwasysFrontApplication::serveProfilerTrace()` appelait directement `session_start()`. La route Profiler pouvait donc ouvrir la session PHP par défaut et présenter une identité absente à l'ACL.

Le même code d'ouverture de session était dupliqué dans trois contrôleurs. La correction de cause consiste à centraliser ce contrat et à injecter la même instance depuis le Singleton.

## Livraison R46C3

Archive : `opus_p117w_r46c3_centralized_session_runtime.zip`

SHA-256 : `18cf5d05f1f46347e7506ff809216a3f81af8d4fdb0a981a20ff360d46b89c67`

L'archive contient sept fichiers complets :

```text
sites/owasys-front/application/default/services/SessionRuntimeInterface.php
sites/owasys-front/application/default/services/SessionRuntime.php
sites/owasys-front/application/default/bootstrap.php
sites/owasys-front/application/default/Application.php
sites/owasys-front/application/default/controllers/RuntimeController.php
sites/owasys-front/application/creation/controllers/CreationController.php
sites/owasys-front/application/source/controllers/SourceController.php
```

## Effet contractuel

- une seule implémentation de `session_name()` / `session_start()` dans owasys-front ;
- nom lu depuis `config/site.json` via le `StructuredFileLoader` déjà utilisé par le Singleton ;
- même `OwasysSessionRuntime` injecté dans la route Profiler et les trois contrôleurs ;
- refus explicite d'un nom invalide, d'un état PHP invalide, d'un démarrage échoué ou d'une session active portant un autre nom ;
- aucune modification ACL ;
- aucune modification d'identité ;
- aucun contournement admin/developer.

## Validation acquise

- construction sur arbre propre au HEAD OPUS `9572f4f` ;
- `git diff --check` propre ;
- archive vérifiée : sept chemins finaux, aucun log, cache, vendor, smoke ou rapport ;
- recherche structurelle : une seule occurrence applicative de `session_name()` et `session_start()`.

PHP n'est pas disponible dans l'environnement de construction. Le lint et la recette HTTP restent owner.

## Recette owner

Avant extraction, retirer la modification locale R46C2 de `AuthSession.php` afin de revenir exactement au HEAD R46C1. Appliquer R46C3, lancer les lints des sept fichiers, `composer dump-autoload -o`, `git diff --check`, puis recharger `?profiler=1` sans supprimer la session.

Critère d'acceptation : la requête `/_opus/profiler/trace/<trace_id>` répond 200 et affiche le SCORE Profiler dans l'iframe pour admin/developer autorisé. Viewer ou session absente restent refusés.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : retrait local R46C2, application R46C3, validation, commit et push OPUS/OWASYS
```

NO ACL BYPASS.  
NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
