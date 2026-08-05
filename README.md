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
OPUS owner head : 00ba1221de99b838e211adb1cb4f5925a11f3193
acquired        : R45B2A1R7
owner delivery  : R45B2A2
```

R45B2A2 borne le stockage JSONL du Profiler, effectue une rotation configurable et conserve la lecture des traces archivées. Aucun site généré n'est corrigé localement.

La suite immédiate, après acquisition fonctionnelle, est E1 : service générique OPUS d'édition sécurisée des sources, puis E2 et E3.

## Architecture OWASYS

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer
```

Deux applications autonomes, deux Singletons, aucun `shared`. Front SCORE uniquement ; back REST sécurisé et Composer allow-listé. Logger et Profiler obligatoires.

NO ACL BYPASS.
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
