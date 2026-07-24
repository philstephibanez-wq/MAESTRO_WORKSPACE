# MAESTRO WORKSPACE

Workspace global de coordination pour MAESTRO, OPUS, OWASYS, la documentation OPUS, LSTSAR, KB et LOGANDPLAY.

OPUS fait partie du workspace ; OPUS n’est pas le workspace et n’est pas une application.

## Reprise immédiate

Lire dans cet ordre :

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117U_HF8_GENERATED_SITE_I18N_EU_UK_DIAGNOSTICS_SPEC_2026-07-24.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF9_CREATION_FORM_LAYOUT_SPEC_2026-07-24.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF9_CREATION_FORM_LAYOUT_2026-07-24.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
8. `CONTEXT/PROJECTS/PROJECT_INDEX.md`

La continuité vient des dépôts GitHub et du workspace versionné, pas du contexte d’un chat.

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
current head    : f9d01dca6644f41c10b85fd6da47eb8c21bf15b6
milestone       : P117U + HF1 + HF2 + HF3 + HF4 + HF6 + HF7 + HF8
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE
```

OWASYS appartient à `sites/owasys/` dans OPUS. Aucun dépôt OWASYS autonome n’est canonique.

## Priorité active

```text
OPUS = framework générique
OWASYS = application construite avec OPUS
pages OWASYS = frontend SCORE
REST sécurisé + Composer = backend OWASYS
sites créés = applications OPUS indépendantes
```

## État runtime

Les preuves owner valident :

```text
Applications active
Creation accessible
Candidats : 1
Applications canoniques : 1
Identifiants dupliqués : 0
Racines ignorées : 0
Singleton conformes : 1
Singleton non conformes : 0
OWASYS découvert comme fullstack standard-opus-application
```

Le journal backend contient sept `registry.sync` réussis par REST sécurisé puis Composer. Chaque commande `owasys:registry-sync` termine avec `exit_code=0`, `stderr_bytes=0` et FSM `succeeded`. Aucune opération `site.create` n’a encore été soumise.

## HF8 committé

Les applications générées reçoivent :

- les 24 langues officielles de l’Union européenne plus l’ukrainien ;
- la locale initiale négociée depuis `Accept-Language` ;
- un fallback français explicite et diagnostiqué ;
- Logger et Profiler obligatoires.

## HF9 à installer

La route `/fr-FR/applications/new` fonctionne, mais le sélecteur frontend/backend/fullstack se chevauche faute de CSS dédié.

```text
ZIP     : opus_owasys_p117u_hf9_creation_form_layout.zip
SHA-256 : 1db0628b87961e098df9500924a496548ea2029702628eb8012c9313636505f0
PATHS   : 3
BASE    : f9d01dca6644f41c10b85fd6da47eb8c21bf15b6
```

Contenu :

```text
sites/owasys/application/creation/controllers/CreationController.php
sites/owasys/application/default/layouts/layout.score
sites/owasys/www/asset/css/creation.css
```

HF9 est une correction de présentation OWASYS. Il ne modifie ni REST, ni Composer, ni Registry, ni les transitions FSM, ni les classes du framework sous `Opus/`.

## Création d’applications

```text
Registry
-> Creation
-> frontend | backend | fullstack
-> REST site.create
-> Composer opus:create-site
-> scaffold OPUS 25 locales + diagnostics
-> Registry synchronize/select
-> Build
```

Le raccourci historique `Registry -> Build` hérité de `owasys_old` est rejeté.

## Contrat global

- relecture GitHub et contrats avant tout patch ;
- interface homonyme à quatre marqueurs pour toute classe concrète OPUS ;
- applications Singleton, FSM, I18n, ACL deny-by-default, SSO/Auth0-proxy, bastion, SCORE et backend-first ;
- locale par défaut issue du navigateur ;
- aucun echo UI et aucun mélange HTML/PHP ;
- configuration via `File`, puis `Json`, `Xml` ou `Yaml` ;
- besoin générique proposé comme évolution OPUS avant toute solution locale ;
- OWASYS UI uniquement, toute mutation via REST sécurisé puis Composer ;
- Logger et Profiler obligatoires ;
- code OPUS/OWASYS livré uniquement par ZIP différentiel ;
- secrets interdits dans Git, argv, logs, profiler et artefacts.

## OWASYS canonique

- contrat : `OPUS_SITE_STANDARD_CONTRACT_CORE` ;
- rôle : `standard-opus-application` ;
- point d’entrée : `sites/owasys/www/index.php` ;
- frontend : pages SCORE ;
- backend : API REST sécurisée puis Composer ;
- client REST : `http://127.0.0.1:8792/api/v1/executions` ;
- module Creation : `sites/owasys/application/creation/` ;
- log backend : `sites/owasys/var/logs/rcp-backend.log` ;
- log frontend : `sites/owasys/var/logs/owasys-frontend.log` ;
- profiler : `sites/owasys/var/profiler/<trace_id>.json`.

## Lancement

```text
START_OWASYS_BACKEND.cmd
START_OWASYS_FRONTEND.cmd
```

`OPUS_OWASYS_BACKEND_TOKEN` et `OPUS_OWASYS_BACKEND_HMAC` proviennent uniquement de l’environnement sécurisé.

## Nettoyage

Aucun nettoyage n’est requis. Ne pas supprimer `sites/owasys_old`, les logs, le profiler ou le Registry. Le sort de `sites/owasys_old` reste une décision owner séparée.

## Règles permanentes

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO BRICOLAGE DELIVERY.  
NO FALLBACK SILENCIEUX.  
OPUS IS A FRAMEWORK, NOT AN APPLICATION.  
OWASYS IS THE SCORE WEB UI.  
ALL OWASYS BUSINESS WRITES CROSS SECURED REST THEN COMPOSER.  
EVERY CONCRETE OPUS CLASS IMPLEMENTS ITS HOMONYMOUS FOUR-MARKER INTERFACE.  
LOGGER AND PROFILER ARE MANDATORY.  
SCORE AND BACKEND-FIRST ARE MANDATORY.
