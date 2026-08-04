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
OPUS owner head : edf17d28d32b1c2f293ba7993252b6e1748c906c
acquired        : R45B2A1
owner delivery  : R45B2A1R2
```

R45B2A1R2 remplace le ZIP R45B2A1R1 non acquis. Il cumule `everyone` et la correction des validations standard/générées. La cible reste OWASYS et le générateur OPUS ; aucun site généré n'est corrigé localement.

## Architecture OWASYS

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer
```

Deux applications autonomes, deux Singletons, aucun `shared`. Front SCORE uniquement ; back REST sécurisé et Composer allow-listé. Logger et Profiler obligatoires.

NO ACL BYPASS.
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
