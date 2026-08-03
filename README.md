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
owner head      : bd0c5d20f2e510b3666df8ed758b7a906c9f46ea
acquired        : R46B11
owner delivery  : R46B12
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE
```

R46B10 est annulé et interdit. R46B11 est acquis mais contient une collision PHP confirmée qui bloque `owasys-front`. R46B12 est le correctif owner actif.

## R46B12

```text
ZIP     : opus_p117w_r46b12_runtime_signal_resolver_collision_fix.zip
SHA-256 : 013f8347a4c52c4fcf15ef28eeddfd71e4acc484e15503660968f9252622f76e
FILES   : 1
BASE    : bd0c5d20f2e510b3666df8ed758b7a906c9f46ea
```

La résolution complète de requête devient `resolveRequestSignal(...)`. La résolution de route reste `resolveSignal(string $routeKey)`. Le contrat FSM V2 n'est pas modifié.

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
