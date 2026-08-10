# OPUS P117W R45D2A4 — GENERATED PROFILER LINK DEV POLICY

Date : 2026-08-10  
Statut : LIVRABLE OWNER À VALIDER

## Base OPUS

```text
dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
opus_p117w_r45d2a3_generated_login_observability
```

## Constat source

Le site généré `essai2` collecte bien le Profiler et enregistre le Web Profiler, mais sa page `/fr/login` n'affiche aucun lien Profiler.

La cause est contractuelle et générique, pas un défaut du template login :

```yaml
environment: dev
profiler:
  collect: true
  web:
    enabled: true
    links: false
```

Cette configuration est produite par `Opus\Scaffold\ProfilerEnvironmentScaffoldPolicy::environmentYaml()` ; `GeneratedSiteRuntime` ne crée un `ProfilerLinkProvider` que lorsque `ProfilerConfiguration::linksEnabled()` vaut true.

## Décision

En développement OPUS, le Profiler doit être immédiatement accessible depuis les pages générées, y compris login et erreurs SCORE rendues avec une trace courante.

La production reste strictement protégée : le Web Profiler et ses liens restent interdits lorsque `environment != dev`.

Aucun patch spécifique `sites/essai2` n'est autorisé.

## Correctif R45D2A4

Fichiers :

```text
Opus/Profiler/ProfilerConfiguration.php
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php
```

Comportement :

1. les futurs sites générés reçoivent `profiler.web.links: true` en environnement `dev` ;
2. compatibilité des sites générés existants : lorsqu'ils sont lancés par le serveur de développement OPUS, qui publie déjà `OPUS_ENV=dev`, `ProfilerConfiguration` active les liens si la configuration du site est elle-même `environment: dev` ;
3. cette compatibilité ne s'applique jamais à un environnement non `dev` ;
4. `web.enabled` et `collect` restent des prérequis ;
5. aucun ACL, SSO, FSM ou fichier de site cible n'est modifié ;
6. aucun secret ni donnée de formulaire n'entre dans le lien ou dans le Profiler.

## Livrable

```text
ZIP     : opus_p117w_r45d2a4_generated_profiler_link_dev_policy.zip
SHA-256 : f503525aff801b664a3e3441fb250b202c0839cc1bb4da9a1eb0dc6107b00acb
BASE    : dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
FILES   : 2
```

## Validation assistant

```text
PHP lint ProfilerConfiguration.php                 OK
PHP lint ProfilerEnvironmentScaffoldPolicy.php     OK
interfaces homonymes existantes                    inchangées
production guard                                   inchangé
generated site-specific files                      aucun
```

## Gate owner

1. appliquer le ZIP sur HEAD exact `dfab7d0...` ;
2. `composer dump-autoload -o` ;
3. relancer `essai2` avec `composer opus:dev-server` / preview OWASYS ;
4. vérifier la présence du lien `OPUS Profiler` sur `/fr/login` ;
5. vérifier que le lien ouvre la trace courante ;
6. la connexion `essai2/steve` reste un sujet séparé : si elle échoue, utiliser l'`error_code` `security.sso/authentication.failed` ajouté par R45D2A3.

NO SITE-SPECIFIC PATCH.  
NO PROFILER LOCK PURGE.  
NO ACL RELAXATION.  
NO PRODUCTION WEB PROFILER.  
NO PUSH OPUS BY ASSISTANT.
