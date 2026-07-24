# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-24

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_CONTINUITY_REBUILD_SPEC_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_RUNTIME_CHECKPOINT_SPEC_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_P117U_HF8_GENERATED_SITE_I18N_EU_UK_DIAGNOSTICS_SPEC_2026-07-24.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF7R1_RUNTIME_CHECKPOINT_2026-07-24.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117U_HF8_GENERATED_SITE_I18N_EU_UK_DIAGNOSTICS_2026-07-24.md
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
local owner     : HF7R1 appliqué, actif, non encore committé sur OPUS/master
base fichier HF8: Opus/Scaffold/SiteScaffoldPlan.php post-HF7R1
base SHA256     : a68f57c7de7f934363cd76ba8c726f732bf83c9a8575fcf88cdb2d8f68877a74
```

OWASYS est l’application `sites/owasys/` du dépôt OPUS. Il s’agit de l’UI web SCORE ; ses mutations métier passent par REST sécurisé puis Composer.

## Ordre actif

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7R1 -> HF8
```

HF5 reste remplacé par HF6.

## Différentiels courants

### HF7R1 déjà appliqué localement

```text
ZIP    : opus_owasys_p117u_hf7r1_application_creation_profiles.zip
SHA256 : 16b8006dae07b88555c7149fa14bb4f9a1230e47f5d32f973933e0597dcb7858
PATHS  : 45
```

### HF8 à installer

```text
ZIP    : opus_p117u_hf8_generated_site_i18n_eu_uk_diagnostics.zip
SHA256 : 6f5d68f23d94d048a0fc43b696397dfe643dd8dc1510cfc33147152ceda7a9f6
PATHS  : 1
```

Contenu HF8 :

```text
Opus/Scaffold/SiteScaffoldPlan.php
```

## Checkpoint runtime HF7R1 validé

Les trois captures et le journal backend reçus valident :

- backend et frontend OWASYS démarrés ;
- surface Applications accessible ;
- bouton `Créer une nouvelle application` visible ;
- `Candidats: 1` ;
- `Applications canoniques: 1` ;
- `Identifiants dupliqués: 0` ;
- `Racines ignorées: 0` ;
- `Conformes Singleton: 1` ;
- `Non conformes Singleton: 0` ;
- OWASYS découvert comme `fullstack`, `standard-opus-application`, racine `sites/owasys` ;
- cinq synchronisations Registry par REST sécurisé puis Composer ;
- chaque commande `owasys:registry-sync` termine avec `exit_code=0` et `stderr_bytes=0` ;
- chaque FSM backend termine dans `succeeded` ;
- les opérations sont corrélables par `trace_id`.

Le contexte courant reste vide avant l’action `Travailler sur cette application`, ce qui est conforme tant que `registry.select` n’a pas été exécuté.

## Évolution HF8 approuvée et produite

Le propriétaire a approuvé l’évolution générique OPUS.

Le scaffold profile-aware génère désormais exactement :

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

pour :

```text
application/default/local/<locale>.json
application/<module>/local/<locale>.json
```

La locale primaire est négociée par `Accept-Language`. Une locale explicite valide dans la route reste prioritaire. `fr` est uniquement le fallback explicite et diagnostiqué.

La classe Singleton générée utilise :

```text
Opus\Log\Logger
Opus\Profiler\Profiler
```

Événements corrélés :

```text
request.received
request.completed
request.failed
```

## Contrat des classes OPUS

HF8 n’ajoute aucune classe concrète sous `Opus/`.

`SiteScaffoldPlan` conserve `SiteScaffoldPlanInterface`, interface homonyme étendant directement :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

L’audit tokenizer P117M exhaustif du dépôt owner complet reste obligatoire avant commit.

## Workflow résultant

```text
Registry
-> Creation
-> frontend | backend | fullstack
-> REST site.create
-> Composer opus:create-site
-> SiteScaffoldPlan profile-aware et I18n 25 locales
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
- locale initiale depuis le navigateur, fallback explicite ;
- configuration via `File` puis `Json`, `Xml` ou `Yaml` ;
- besoin générique proposé comme évolution OPUS avant toute solution locale ;
- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- Logger et Profiler obligatoires ;
- aucun secret dans Git, argv, logs, profiler ou ZIP.

## Validations de livraison HF8

```text
SiteScaffoldPlan PHP lint        : OK
Application.php généré PHP lint  : OK
Trois profils                    : OK
Locales                          : 25
Catalogues default               : 25
Catalogues modules fullstack     : 200
Parsing JSON                     : OK
Accept-Language contract         : OK
Fallback explicite               : OK
Logger/Profiler générés          : OK
Nouvelle classe concrète OPUS    : aucune
Echo UI ajouté                   : aucun
Parser local ajouté              : aucun
Contenu parasite ZIP             : aucun
```

## Installation owner HF8

Avant extraction, vérifier que le SHA-256 local de :

```text
Opus\Scaffold\SiteScaffoldPlan.php
```

est :

```text
a68f57c7de7f934363cd76ba8c726f732bf83c9a8575fcf88cdb2d8f68877a74
```

Si le SHA diffère, ne pas écraser le fichier et fournir la version locale réelle.

Après extraction :

1. Composer autoload optimisé ;
2. PHP lint ;
3. audit tokenizer P117M exhaustif ;
4. création frontend ;
5. création backend ;
6. création fullstack ;
7. contrôle des 25 catalogues ;
8. tests `fr-FR`, `de-DE`, `uk-UA` et fallback ;
9. contrôle Logger et Profiler ;
10. Registry select puis Build ;
11. SCORE, FSM, ACL, SSO, Auth0, HTTPS, bastion, no-JavaScript et Windows/Linux ;
12. commit et push OPUS après acceptation owner.

## Diagnostics

OWASYS :

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/<trace_id>.json
```

Application générée :

```text
sites/<application>/var/logs/application.log
sites/<application>/var/profiler/<trace_id>.json
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

## Politique GitHub

La gouvernance est écrite directement dans `MAESTRO_WORKSPACE`. Le code OPUS/OWASYS n’est pas poussé directement par l’assistant ; il est livré par ZIP différentiel.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
