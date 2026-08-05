# MAESTRO WORKSPACE

Workspace global de coordination pour MAESTRO, OPUS, OWASYS, la documentation OPUS, LSTSAR, KB et LOGANDPLAY.

## Reprise immédiate

Lire dans cet ordre :

1. `README-FIRST.md`
2. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
3. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
4. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
5. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Source active

```text
OPUS owner head : 381de7d4a6ca145c7a572630cb84d97a0741da6c
acquired        : R45B2A1R6
owner delivery  : R45B2A1R7
```

R45B2A1R7 branche la surface Web Profiler existante dans les applications générées : route déclarée, FSM, ACL deny-by-default et lien SCORE limité aux environnements de développement. Aucun site généré n'est corrigé localement.

La suite immédiate, après acquisition fonctionnelle, est la rétention bornée et la rotation JSONL du Profiler. L'éditeur Sources/Git est spécifié séparément selon E1/E2/E3.

## Architecture OWASYS

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer
```

Deux applications autonomes, deux Singletons, aucun `shared`. Front SCORE uniquement ; back REST sécurisé et Composer allow-listé. Logger et Profiler obligatoires.

NO ACL BYPASS.
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
