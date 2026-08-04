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
owner head      : dac97628f182b62ee7d2759583441f5bdf179c36
acquired        : R45B2 + R45B1 + R45A3 + R45A2 + R46B15
owner delivery  : R45B2A1
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE
```

R46B10 est annulé et interdit. La cible est OWASYS et le générateur OPUS ; les sites générés ne sont pas des cibles de correction locale.

## R45B2A1

```text
ZIP     : opus_p117w_r45b2a1_fsm_everyone_timeline.zip
SHA-256 : 4d4b1ee5b8585f8d1529578e08b4cbb6575ef1414c8c6c4ca86b3752776399fd
FILES   : 4
BASE    : dac97628f182b62ee7d2759583441f5bdf179c36
```

R45B2A1 génère et valide un nom canonique de FSM, réserve `anonymous` à l'état d'authentification, utilise `everyone` comme sujet collectif et synthétise la timeline principale. R45B2A2 ajoutera la rétention/rotation JSONL configurable.

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

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO BRICOLAGE DELIVERY.  
NO FALLBACK SILENCIEUX.
