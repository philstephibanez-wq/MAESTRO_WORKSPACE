# HANDOFF — OPUS P117W R45B4 PROFILER ENVIRONMENT CONFIG

Date : 2026-08-07  
Statut : livré, validation et acquisition owner requises

## Base exacte

```text
OPUS master : 6be07a76e20dfeea09b51c7c016083da626bf974
Commit       : opus_p117w_r45b3_rest_client_contract
```

R45B3 est acquis. R45B4 ne modifie aucun site généré existant.

## Livrable actif

```text
ZIP     : opus_p117w_r45b4_profiler_environment_config.zip
SHA-256 : dba3294a4dca74749e78bfb183985e1b501a6cb09b9805aa77537bd66931de98
FILES   : 10
BASE    : 6be07a76e20dfeea09b51c7c016083da626bf974
STATUS  : application, validation, commit et push owner requis
```

Smoke inclus :

```text
FILE    : tools/smoke_p117w_r45b4_profiler_environment.php
SHA-256 : baf59d199eeea2e2528fdcb6d5cfe265a07ac4098df2cc5352fed9dba3a20b7b
OUTPUT  : OPUS_P117W_R45B4_SMOKE_OK
```

## Fichiers du ZIP

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Profiler/ProfilerConfiguration.php
Opus/Profiler/ProfilerConfigurationInterface.php
Opus/Profiler/ProfilerLinkProvider.php
Opus/Profiler/ProfilerLinkProviderInterface.php
Opus/Profiler/WebProfilerController.php
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicyInterface.php
Opus/Scaffold/ScaffoldEntry.php
tools/smoke_p117w_r45b4_profiler_environment.php
```

## Cause traitée

Le Web Profiler n'est plus une fonctionnalité possédée par les sites générés. OPUS décide au bootstrap, depuis `config/environment.yaml`, de trois capacités séparées : collecte, Web Profiler et affichage des liens.

Le contrôleur ne lit plus `OPUS_ENV` et ne reçoit plus `accessGranted`. La route Web Profiler existe structurellement uniquement lorsque la politique `dev` l'autorise.

## Configuration générée

```yaml
environment: dev
profiler:
  collect: true
  web:
    enabled: true
    links: false
```

Le fichier réel comporte les commentaires explicatifs YAML demandés et le contrat `OPUS_PROFILER_ENVIRONMENT_CONFIG_V1`.

## Résultat scaffold

Un nouveau site généré ne possède plus :

- route `profiler.trace` de site ;
- état/transition FSM Profiler ;
- ACL `profiler:view` ;
- message I18n Profiler ;
- `profiler-link.score` ;
- footer/CSS Profiler spécifiques ;
- instanciation du Profiler dans son `Application.php`.

Le layout SCORE ne consomme que :

```text
[[ if: diagnostics.profiler_available ]]
<a href="{{ diagnostics.profiler_url }}">{{ diagnostics.profiler_label }}</a>
[[ endif ]]
```

## Production

Hors environnement exact `dev`, toute tentative d'activer `profiler.web.enabled` ou `profiler.web.links` est refusée au bootstrap.

Lorsque le Web Profiler n'est pas enregistré :

- pas de contrôleur Web Profiler ;
- pas de fournisseur de lien ;
- pas de `WebProfilerView` ;
- pas de route Profiler de site ;
- URL `/_opus/profiler/trace/{trace_id}` => HTTP 404.

## Validation owner

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r45b4_profiler_environment_config.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b4_profiler_environment_config.zip"
composer dump-autoload -o
php tools\smoke_p117w_r45b4_profiler_environment.php
```

Attendu :

```text
OPUS_P117W_R45B4_SMOKE_OK
```

Ensuite générer un nouveau site via OWASYS et vérifier `links=false`, `links=true`, accès direct en `dev`, refus Web Profiler en production et vraie 404 lorsque le Web Profiler est absent.

## Suite

Après acquisition :

```text
R45C — wizard OWASYS structuré
```

Puis :

```text
R45D — administration Sécurité
```

NO PROFILER WEB OUTSIDE DEV.  
NO SITE-OWNED PROFILER ROUTE/FSM/ACL/TEMPLATE.  
NO OPUS_ENV GATE IN WEB CONTROLLER.  
NO LOCAL SITE FIX.  
NO BACKEND JAVASCRIPT.  
NO PUSH OPUS PAR L’ASSISTANT.
