# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-24

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_CONTINUITY_REBUILD_SPEC_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_RUNTIME_CHECKPOINT_SPEC_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_P117U_HF7R2_GENERATED_SITE_I18N_DECISION_SPEC_R1_2026-07-24.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF7R1_RUNTIME_CHECKPOINT_2026-07-24.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117U_HF7R2_GENERATED_SITE_I18N_DECISION_2026-07-24.md
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
```

OWASYS est l’application `sites/owasys/` du dépôt OPUS. Il s’agit de l’UI web SCORE ; ses mutations métier passent par REST sécurisé puis Composer.

## Ordre actif

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7R1 -> décision HF7R2
```

HF5 reste remplacé par HF6.

## Différentiel installable courant

```text
ZIP    : opus_owasys_p117u_hf7r1_application_creation_profiles.zip
SHA256 : 16b8006dae07b88555c7149fa14bb4f9a1230e47f5d32f973933e0597dcb7858
PATHS  : 45
```

Le ZIP précédent contenant uniquement le patch est remplacé et ne doit pas être utilisé.

## Checkpoint runtime validé

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

## Écart générique OPUS identifié

Le fichier réel `Opus/Scaffold/SiteScaffoldPlan.php` du différentiel HF7R1 génère encore :

```text
default_locale : fr
locales        : fr, en, es
```

Il ne génère que les catalogues `fr`, `en` et `es` dans les nouvelles applications.

Le module OWASYS Creation contient bien les 25 catalogues attendus, mais cette couverture n’est pas propagée aux sites générés.

Ce besoin est générique. Il relève du framework OPUS et ne doit pas être corrigé localement dans OWASYS.

## Décision owner obligatoire

```text
OUI : faire évoluer OPUS pour générer les 24 langues officielles de l’Union européenne + l’ukrainien, avec locale initiale Accept-Language et fallback explicite diagnostiqué.
NON : conserver le scaffold fr/en/es ; aucune solution locale OWASYS ne sera ajoutée.
```

Aucun ZIP HF8 n’est produit avant cette décision.

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

## Gates owner encore ouverts

1. décision `OUI` ou `NON` sur l’évolution I18n générique du scaffold ;
2. audit tokenizer P117M et lint/parsing complets ;
3. affichage du formulaire Creation ;
4. annulation Creation vers Registry ;
5. erreurs contrôlées avec trace corrélée ;
6. création frontend ;
7. création backend ;
8. création fullstack ;
9. Registry select puis Build ;
10. conformité des trois applications ;
11. navigation sans JavaScript ;
12. mot de passe, Auth0, HTTPS, bastion et Windows/Linux ;
13. commit et push OPUS après acceptation owner.

## Politique GitHub

La gouvernance est écrite directement dans `MAESTRO_WORKSPACE`. Le code OPUS/OWASYS n’est pas poussé directement par l’assistant ; il est livré par ZIP différentiel installable.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
