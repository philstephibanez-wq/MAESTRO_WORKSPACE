# MAESTRO WORKSPACE

Workspace global de coordination pour MAESTRO, OPUS, OWASYS, la documentation OPUS, LSTSAR, KB et LOGANDPLAY.

OPUS fait partie du workspace ; OPUS n’est pas le workspace et n’est pas une application.

## Reprise immédiate

Lire dans cet ordre :

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7R1_CONTINUITY_REBUILD_SPEC_2026-07-24.md`
5. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF7R1_CONTINUITY_REBUILD_2026-07-24.md`
6. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
7. `CONTEXT/PROJECTS/PROJECT_INDEX.md`

La continuité vient des dépôts GitHub et du workspace versionné, pas du contexte d’un chat.

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
head HF6 relu   : 79f261854ee06a9f828fec389adca77d57323d00
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

## Ordre applicable

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7R1
```

HF5 reste remplacé par HF6.

## Différentiel HF7R1

```text
ZIP    : opus_owasys_p117u_hf7r1_application_creation_profiles.zip
SHA256 : 2317f0f3a76de22f4c51e5c568b8176d2cebb4169d50fc62b75d22458d6a959d
PATCH  : opus_owasys_p117u_hf7r1_application_creation_profiles.patch
SHA256 : 4e90d025a26474d0c19eaecae92048d1bf6b7ab403f4bfea2db796b9b05e53c8
PATHS  : 45
```

HF7R1 est reconstruit depuis le head GitHub HF6 et les contrats versionnés. Il constitue le différentiel courant traçable ; il n’est pas présenté comme octet-identique à l’ancien ZIP HF7.

## Création d’applications

```text
Registry
-> Creation
-> frontend | backend | fullstack
-> REST site.create
-> Composer opus:create-site
-> scaffold générique OPUS
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

## Racine OPUS verrouillée

Répertoires admis : `.git`, `.github`, `application`, `Config`, `DOC`, `Opus`, `packages`, `runtime`, `scripts`, `sites`, `tools`, `vendor`.

Fichiers racine admis : `.gitignore`, `AGENTS.md`, `composer.json`, `composer.lock`, `composer.phar`, `LICENSE`, `README.md`.

Interdictions : root `bin/`, root `config` minuscule, root `public`, toute nouvelle racine.

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

## Commandes de lancement

```text
composer dump-autoload -o
composer opus:validate-site -- owasys
composer opus:list-routes -- owasys
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8792
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8000
```

`OPUS_OWASYS_BACKEND_TOKEN` et `OPUS_OWASYS_BACKEND_HMAC` proviennent uniquement de l’environnement sécurisé.

## Nettoyage

Ne pas supprimer `sites/owasys_old`, les logs, le profiler ou le Registry dans ce jalon. Le sort de `sites/owasys_old` reste une décision owner séparée.

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