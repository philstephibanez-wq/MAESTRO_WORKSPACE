# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-24

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_CONTINUITY_REBUILD_SPEC_2026-07-24.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF7R1_CONTINUITY_REBUILD_2026-07-24.md
```

## Continuité GitHub

La continuité du projet vient des dépôts et du workspace, pas du contexte d’un chat.

Dépôts relus :

```text
philstephibanez-wq/MAESTRO_WORKSPACE
philstephibanez-wq/OPUS
philstephibanez-wq/Maestro
philstephibanez-wq/Maestro_KB_Engine
philstephibanez-wq/Maestro_KB_Extranet
```

## Source de vérité active

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
base HF6        : 79f261854ee06a9f828fec389adca77d57323d00
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
```

OWASYS est l’application `sites/owasys/` du dépôt OPUS. Il s’agit de l’UI web SCORE ; ses mutations métier passent par REST sécurisé puis Composer.

## Ordre actif

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7R1
```

HF5 reste remplacé par HF6.

## Écarts confirmés sur OPUS/master

- Registry passe encore directement à Build pour `create_new_app` ;
- `start_creation_flow` est encore actif ;
- `registry.creation.start`, `owasys:registry-creation-start` et `owasys:registry:creation:start` existent encore ;
- `site.create` ne transporte pas de profil ;
- le scaffold ne différencie pas frontend/backend/fullstack ;
- la découverte Registry ne projette pas encore `OPUS_SITE_STANDARD_CONTRACT_CORE`.

## Différentiel courant

```text
ZIP    : opus_owasys_p117u_hf7r1_application_creation_profiles.zip
SHA256 : 2317f0f3a76de22f4c51e5c568b8176d2cebb4169d50fc62b75d22458d6a959d
PATCH  : opus_owasys_p117u_hf7r1_application_creation_profiles.patch
SHA256 : 4e90d025a26474d0c19eaecae92048d1bf6b7ab403f4bfea2db796b9b05e53c8
PATHS  : 45
```

HF7R1 a été reconstruit depuis le head GitHub HF6 et les contrats versionnés. Il n’est pas présenté comme octet-identique à l’ancien ZIP HF7 ; il constitue le différentiel courant traçable de continuité.

## Workflow résultant

```text
Registry
-> Creation
-> frontend | backend | fullstack
-> REST site.create
-> Composer opus:create-site
-> SiteScaffoldPlan profile-aware
-> Registry synchronize/select
-> application_created
-> Build
```

Failure reste dans Creation. Cancellation retourne dans Registry.

## Contrats obligatoires

- toute classe concrète OPUS implémente directement son interface homonyme ;
- l’interface homonyme étend `OpusFrameworkComponentInterface`, `OpusExceptionAwareInterface`, `OpusProfilerAwareInterface` et `OpusSelfDocumentingInterface` ;
- applications Singleton, FSM, I18n, ACL deny-by-default, SSO/Auth0-proxy et bastion ;
- rendu SCORE uniquement ;
- aucun echo UI, aucun mélange HTML/PHP ;
- locale par défaut depuis le navigateur ;
- configuration via `File` puis `Json`, `Xml` ou `Yaml` ;
- besoin générique proposé comme évolution OPUS avant toute solution locale ;
- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- Logger et Profiler obligatoires ;
- aucun secret dans Git, argv, logs, profiler ou ZIP.

## Diagnostics

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/<trace_id>.json
```

## Lancement

```text
backend  : composer opus:serve-site -- owasys --host=127.0.0.1 --port=8792
frontend : composer opus:serve-site -- owasys --host=127.0.0.1 --port=8000
```

Les variables `OPUS_OWASYS_BACKEND_TOKEN` et `OPUS_OWASYS_BACKEND_HMAC` sont injectées par l’environnement sécurisé et ne sont jamais committées.

## Nettoyage

Aucune suppression préalable n’est requise. Préserver :

```text
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
sites/owasys_old
```

La suppression de `sites/owasys_old` reste une décision owner séparée.

## Gates owner

1. clone `H:\OPUS` propre sur `79f261854ee06a9f828fec389adca77d57323d00` ;
2. `git apply --check` puis application de HF7R1 ;
3. `composer dump-autoload -o` ;
4. audit tokenizer P117M et lint/parsing complets ;
5. validation site et routes ;
6. démarrage backend puis frontend ;
7. test des trois profils ;
8. Registry select puis Build ;
9. corrélation Logger/Profiler ;
10. no-JavaScript, mot de passe, Auth0, HTTPS, bastion et Windows/Linux ;
11. commit et push OPUS après acceptation owner.

## Politique GitHub

La gouvernance est écrite directement dans `MAESTRO_WORKSPACE`. Le code OPUS/OWASYS n’est pas poussé directement par l’assistant ; il est livré par ZIP différentiel.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.