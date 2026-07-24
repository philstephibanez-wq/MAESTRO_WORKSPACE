# MAESTRO WORKSPACE

Workspace global de coordination pour MAESTRO, OPUS, OWASYS, la documentation OPUS, LSTSAR, KB et LOGANDPLAY.

OPUS fait partie du workspace ; OPUS n’est pas le workspace et n’est pas une application.

## Reprise immédiate

Lire dans cet ordre :

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md`
4. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_GOVERNANCE_EXECUTION_2026-07-24.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_SPEC.md`
6. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
7. `CONTEXT/PROJECTS/PROJECT_INDEX.md`

## Priorité active

```text
OPUS = framework générique
OWASYS = application construite avec OPUS
pages OWASYS = frontend SCORE
REST + Composer = backend OWASYS
sites créés = applications OPUS indépendantes
```

## Source de vérité

- OPUS : `philstephibanez-wq/OPUS`, branche `master`
- head distant relu : `79f261854ee06a9f828fec389adca77d57323d00`
- état du head : HF6 committé ; HF7 encore différentiel non committé
- workspace : `philstephibanez-wq/MAESTRO_WORKSPACE`

OWASYS appartient à `sites/owasys/` dans OPUS. Il n’existe pas de dépôt OWASYS autonome servant de source canonique.

## Racine OPUS verrouillée

Répertoires admis : `.git`, `.github`, `application`, `Config`, `DOC`, `Opus`, `packages`, `runtime`, `scripts`, `sites`, `tools`, `vendor`.

Fichiers racine admis : `.gitignore`, `AGENTS.md`, `composer.json`, `composer.lock`, `composer.phar`, `LICENSE`, `README.md`.

Interdictions : root `bin/`, root `config/` minuscule, root `public/`, toute nouvelle racine.

## Livrables applicables

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7
```

HF5 reste remplacé par HF6.

HF7 :

- ZIP : `opus_owasys_p117u_hf7_application_creation_profiles.zip`
- SHA-256 : `16e06b55f3cf2ffcc5118fe0e5c4f17cbc7b51fa437fd06f17bf3dc16ab48141`
- fichiers : 45
- taille ZIP : 54 906 octets
- payload : 176 634 octets
- état : artefact exact retrouvé, empreinte et intégrité vérifiées, non appliqué sur `OPUS/master`

Aucun ZIP OPUS/OWASYS ne doit être reconstruit sans l’artefact réel ou les fichiers source exacts.

## Écart distant courant

Le `composer.json` du head HF6 expose encore :

```text
owasys:registry-creation-start
```

HF7 supprime cet alias obsolète avec l’ancien chemin direct Registry vers Build.

## Contrat global de développement

Le contrat actif est :

`CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`

Il impose notamment :

- relecture des sources de vérité et contrats avant tout patch ;
- interface homonyme à quatre marqueurs pour toute classe concrète OPUS ;
- applications Singleton, FSM, I18n, ACL, SSO/Auth0, SCORE et backend-first ;
- locale par défaut issue du navigateur ;
- configuration via `File` puis `Json`, `Xml` ou `Yaml` ;
- OWASYS UI uniquement, toute mutation via REST sécurisé puis Composer ;
- Logger et Profiler obligatoires ;
- code OPUS/OWASYS livré uniquement par ZIP différentiel ;
- commandes de nettoyage et lancement fournies en CMD lorsque nécessaires.

## Création d’applications

Le chemin canonique reste :

```text
Registry
-> Creation
-> choix frontend / backend / fullstack
-> REST sécurisé
-> Composer
-> scaffold générique OPUS
-> sélection Registry
-> Build
```

Le raccourci historique `Registry -> Build` hérité de `owasys_old` est rejeté.

## OWASYS canonique

- contrat : `OPUS_SITE_STANDARD_CONTRACT_CORE`
- rôle : `standard-opus-application`
- point d’entrée unique : `sites/owasys/www/index.php`
- frontend : pages SCORE actuelles
- backend : API REST sécurisée puis Composer
- client REST : `http://127.0.0.1:8792/api/v1/executions`
- création : module applicatif `sites/owasys/application/creation/`
- log backend : `sites/owasys/var/logs/rcp-backend.log`
- log frontend : `sites/owasys/var/logs/owasys-frontend.log`
- profiler : `sites/owasys/var/profiler/<trace_id>.json`

## Commandes validées

```text
composer dump-autoload -o
composer opus:validate-site -- owasys
composer opus:list-routes -- owasys
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8792
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8000
```

`OPUS_OWASYS_BACKEND_TOKEN` et `OPUS_OWASYS_BACKEND_HMAC` proviennent exclusivement de l’environnement local sécurisé.

## Règles permanentes

- NO CONTRACT, NO PATCH.
- NO SOURCE OF TRUTH, NO PATCH.
- NO BRICOLAGE DELIVERY.
- NO FALLBACK SILENCIEUX.
- ONLY THE OWNER-CONFIRMED OPUS ROOT IS ADMITTED.
- COMPOSER EXPOSES USER COMMANDS ONLY.
- OPUS IS A FRAMEWORK, NOT AN APPLICATION.
- OWASYS IS AN APPLICATION BUILT WITH OPUS.
- NO OWASYS BUSINESS IMPLEMENTATION UNDER `Opus/`.
- ALL OWASYS BUSINESS WRITES CROSS SECURED REST THEN COMPOSER.
- EVERY CONCRETE OPUS CLASS IMPLEMENTS ITS HOMONYMOUS FOUR-MARKER INTERFACE.
- OPUS APPLICATIONS ARE SINGLETON, FSM/I18N/ACL/SSO DRIVEN AND SCORE-ONLY.
- CONFIGURATION CROSSES FILE AND EXPLICIT JSON/XML/YAML PARSERS.
- LOGGER AND PROFILER ARE MANDATORY.
- SCORE AND BACKEND-FIRST ARE MANDATORY.
- WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
- SECRETS NEVER ENTER GIT, ARGV, LOGS, PROFILER PAYLOADS OR DELIVERY ARTIFACTS.

## Feuille de route

1. vérifier que `H:\OPUS` est propre et basé sur le head HF6 attendu ;
2. appliquer HF7 ;
3. régénérer l’autoload Composer optimisé ;
4. exécuter le gate tokenizer P117M et le lint complet ;
5. valider OWASYS et ses routes ;
6. démarrer backend puis frontend ;
7. valider les profils frontend/backend/fullstack et la transition Registry vers Build ;
8. valider mot de passe, navigateur sans JavaScript, Auth0, HTTPS et bastion ;
9. committer OPUS après acceptation owner ;
10. décider séparément de `sites/owasys_old`.
