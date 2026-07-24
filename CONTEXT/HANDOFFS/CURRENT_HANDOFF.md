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

## Différentiel installable courant

```text
ZIP    : opus_owasys_p117u_hf7r1_application_creation_profiles.zip
SHA256 : 16b8006dae07b88555c7149fa14bb4f9a1230e47f5d32f973933e0597dcb7858
PATHS  : 45
```

Contenu :

```text
INSTALL_HF7R1.cmd
START_OWASYS_BACKEND.cmd
START_OWASYS_FRONTEND.cmd
payload/opus_owasys_p117u_hf7r1_application_creation_profiles.patch
```

Le ZIP précédent contenant uniquement le patch est remplacé et ne doit pas être utilisé.

Le propriétaire n’exécute aucune commande `git apply`. Il extrait le ZIP dans un dossier temporaire et lance uniquement `INSTALL_HF7R1.cmd`.

## Installation automatique

`INSTALL_HF7R1.cmd` vérifie puis exécute :

1. présence de `H:\OPUS` ;
2. head exact HF6 ;
3. dépôt Git propre ;
4. contrôle du différentiel ;
5. application ;
6. autoload Composer optimisé ;
7. validation OWASYS ;
8. liste des routes.

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
START_OWASYS_BACKEND.cmd
START_OWASYS_FRONTEND.cmd
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

1. exécuter `INSTALL_HF7R1.cmd` ;
2. audit tokenizer P117M et lint/parsing complets ;
3. démarrage backend puis frontend par les lanceurs fournis ;
4. test des trois profils ;
5. Registry select puis Build ;
6. corrélation Logger/Profiler ;
7. no-JavaScript, mot de passe, Auth0, HTTPS, bastion et Windows/Linux ;
8. commit et push OPUS après acceptation owner.

## Politique GitHub

La gouvernance est écrite directement dans `MAESTRO_WORKSPACE`. Le code OPUS/OWASYS n’est pas poussé directement par l’assistant ; il est livré par ZIP différentiel installable.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.