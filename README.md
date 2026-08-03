# MAESTRO WORKSPACE

Workspace global de coordination pour MAESTRO, OPUS, OWASYS, la documentation OPUS, LSTSAR, KB et LOGANDPLAY.

OPUS fait partie du workspace ; OPUS n'est ni le workspace ni une application.

## Reprise immédiate

Lire dans cet ordre :

1. `README-FIRST.md`
2. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
3. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
4. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md`
6. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
7. `CONTEXT/PROJECTS/PROJECT_INDEX.md`

La continuité vient des dépôts GitHub et du workspace versionné, jamais du seul contexte d'un chat.

## Source de vérité active

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
owner head      : 4a4193094f1ea33270909008a0a1a0c8eac61c3e
acquired        : R45B1 + R45A3 + R45A2 + R46B15
owner delivery  : R45B2
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE
```

R46B10 est annulé et interdit. Le workflow actif est la création d'un site par OWASYS. Les sites générés ne sont pas des cibles de correction locale.

## R45B2

```text
ZIP     : opus_p117w_r45b2_backend_rest_profile_runtime.zip
SHA-256 : 39bf3866f4a1c02f5b0a2bbb826223117a7bd8a5dbaf5b4accf5ca5fcf2c489f
FILES   : 2
BASE    : 4a4193094f1ea33270909008a0a1a0c8eac61c3e
```

R45B2 génère le runtime backend PHP/REST/Composer réellement distinct, conserve
le gate R45B1 et ajoute la corrélation fullstack sans `shared`. R45B3 ajoutera
le client REST frontend générique et les validateurs croisés.

## Architecture OWASYS

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer
             <- réponse       <-
```

- `owasys-front` : application OPUS autonome, Singleton, interface SCORE uniquement.
- `owasys-back` : application OPUS autonome, Singleton, REST sécurisé, logique métier et Composer allow-listé.
- Déploiement possible sur deux bastions distincts.
- Aucun JavaScript, TypeScript, Node ou gestionnaire JavaScript dans le backend.
- Logger et Profiler obligatoires dans les deux applications.

## Contrat global

- relire GitHub et les contrats avant tout changement ;
- traiter la cause ;
- toute classe concrète OPUS implémente son interface homonyme à quatre marqueurs ;
- livrer OPUS/OWASYS uniquement par ZIP différentiel direct de fichiers complets ;
- l'assistant n'écrit directement que dans `MAESTRO_WORKSPACE` ;
- applications Singleton, FSM, I18n, ACL deny-by-default, SSO/Auth0-proxy, bastion et SCORE ;
- configuration via `File`, puis `Json`, `Xml` ou `Yaml` ;
- aucun echo UI, aucun mélange HTML/PHP, aucun fallback silencieux ;
- secrets interdits dans Git, argv, logs, Profiler et artefacts.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO BRICOLAGE DELIVERY.  
NO FALLBACK SILENCIEUX.
