# MAESTRO WORKSPACE

Workspace global de coordination pour MAESTRO, OPUS, OWASYS, la documentation OPUS, LSTSAR, KB et LOGANDPLAY.

OPUS fait partie du workspace ; OPUS n'est pas le workspace et n'est pas une application.

## Reprise immédiate

Lire dans cet ordre :

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_SPEC.md`
3. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_2026-07-24.md`
4. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
5. `CONTEXT/PROJECTS/PROJECT_INDEX.md`

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
- head distant relu : `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- workspace : `philstephibanez-wq/MAESTRO_WORKSPACE`

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
- taille ZIP : 54,906 octets

## Création d’applications

Le chemin canonique est désormais :

```text
Registry
-> Creation
-> choix frontend / backend / fullstack
-> REST sécurisé
-> Composer
-> scaffold générique OPUS
-> sélection Registry
-> Construction et validation
```

Le raccourci historique `Registry -> Build` hérité de `owasys_old` est rejeté.

## OWASYS canonique

- contrat : `OPUS_SITE_STANDARD_CONTRACT_CORE`
- rôle : `standard-opus-application`
- point d'entrée unique : `sites/owasys/www/index.php`
- frontend : pages SCORE actuelles
- backend : API REST sécurisée puis Composer
- création : module applicatif `sites/owasys/application/creation/`
- Registry et mot de passe : commandes applicatives backend
- log backend : `sites/owasys/var/logs/rcp-backend.log`
- log frontend : `sites/owasys/var/logs/owasys-frontend.log`
- profiler : `sites/owasys/var/profiler/<trace_id>.json`

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
- LOGGER AND PROFILER ARE MANDATORY.
- SCORE AND BACKEND-FIRST ARE MANDATORY.
- WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.

## Feuille de route

1. appliquer HF7 après HF6 ;
2. régénérer l'autoload Composer ;
3. valider OWASYS et ses routes ;
4. démarrer backend puis frontend ;
5. valider les profils frontend/backend/fullstack et la transition Registry vers Build ;
6. valider mot de passe, navigateur sans JavaScript, Auth0, HTTPS et bastion ;
7. committer OPUS après acceptation owner ;
8. décider séparément de `sites/owasys_old`.
