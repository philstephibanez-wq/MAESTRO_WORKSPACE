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
SHA-256 : e67034362a664b78c0b993f46c358c9dea5e9a7b4b8747fc14b6dc0a0e23da16
FILES   : 9
BASE    : 6be07a76e20dfeea09b51c7c016083da626bf974
STATUS  : application, validation, commit et push owner requis
```

Le ZIP contient uniquement les neuf fichiers OPUS complets à leurs chemins finaux. Conformément au contrat global, aucun smoke, audit, rapport, log, cache, vendor ou temporaire n'est inclus.

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45b4_profiler_environment_owner.php
SHA-256 : 65aaa0dfc8adf171db262383452f0fc1b3914568d9d4997ce73d899c061f50a9
OUTPUT  : OPUS_P117W_R45B4_SMOKE_OK
```

Le smoke n'est pas destiné à être committé dans OPUS.

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
```

## Cause traitée

Le Web Profiler n'est plus une fonctionnalité possédée par les sites générés. OPUS décide au bootstrap, depuis `config/environment.yaml`, de trois capacités séparées : collecte, Web Profiler et affichage des liens.

Le contrôleur ne lit plus `OPUS_ENV` et ne reçoit plus `accessGranted`. La route Web Profiler existe structurellement uniquement lorsque la politique `dev` l'autorise.

## Configuration générée

Le fichier réel est du YAML standard commenté :

```yaml
contract: OPUS_PROFILER_ENVIRONMENT_CONFIG_V1
environment: dev
profiler:
  collect: true
  web:
    enabled: true
    links: false
```

Les commentaires documentent l'environnement, la collecte, l'enregistrement Web, les liens et le refus du Web Profiler en production.

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
- pas de `WebProfilerView` ;
- pas de fournisseur de lien ;
- pas de route Profiler de site ;
- URL `/_opus/profiler/trace/{trace_id}` => HTTP 404.

## Prévalidation assistant

- `php -l` : neuf fichiers du ZIP OK ;
- harnais local : `R45B4_LOCAL_HARNESS_OK` ;
- audit `token_get_all()` du smoke validé sur arbre synthétique : `AUDIT_OK` ;
- ZIP contrôlé sans pollution contractuellement interdite.

Le dépôt OPUS complet n'est pas présent dans l'environnement de l'assistant : l'autoload optimisé et le smoke exhaustif restent des gates owner obligatoires avant conformité.

## Validation owner

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r45b4_profiler_environment_config.zip" SHA256
certutil -hashfile "%USERPROFILE%\Downloads\smoke_opus_p117w_r45b4_profiler_environment_owner.php" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b4_profiler_environment_config.zip"
composer dump-autoload -o
copy /Y "%USERPROFILE%\Downloads\smoke_opus_p117w_r45b4_profiler_environment_owner.php" "H:\OPUS\smoke_opus_p117w_r45b4_profiler_environment_owner.php"
php smoke_opus_p117w_r45b4_profiler_environment_owner.php
del /Q "H:\OPUS\smoke_opus_p117w_r45b4_profiler_environment_owner.php"
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
NO SMOKE IN OPUS ZIP.  
NO LOCAL SITE FIX.  
NO BACKEND JAVASCRIPT.  
NO PUSH OPUS PAR L’ASSISTANT.
