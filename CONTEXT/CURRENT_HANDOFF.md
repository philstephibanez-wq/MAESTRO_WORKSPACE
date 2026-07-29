# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-29

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R34_FSM_RUNTIME_ASAP_COMPLIANCE_2026-07-29.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R35R2_IN_PROCESS_DISPATCH_AND_FRESH_DIAGNOSTICS_2026-07-29.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R36_FSM_SCORE_CORRELATED_PROFILER_URL_CONTRACT_2026-07-29.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R37_TWO_BASTIONS_DIAGNOSTICS_CORRELATION_AUDIT_2026-07-29.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R37_TWO_BASTIONS_DIAGNOSTICS_2026-07-29.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base R34 : 47c5bb1d667a43a61ae35ec3465accc29d42f54c
Prérequis : R34, R35-R2, R36
```

## Contrat actif

OWASYS contient exactement deux applications autonomes sur deux bastions possibles :

```text
sites/owasys-front
sites/owasys-back
```

Aucune couche `shared`, aucun runtime imbriqué et aucun partage de fichiers, configuration, secrets, état ou diagnostics.

## R37

L’audit complet de la session R36 impose :

- log frontend unique `owasys-front.log` ;
- contexte FSM Profiler complet ;
- `trace_id` corrélé de bout en bout ;
- suppression des 385 fichiers inactifs sous `application/front`, `application/shared` et `application/back` ;
- suppression des configurations backend obsolètes du frontend ;
- gate `opus:validate-site` empêchant le retour de ces couches.

## Validation suivante

Appliquer R37, exécuter le nettoyage owner explicite, relancer les deux applications, tester création invalide et Source avec `?profiler=1`, puis vérifier un même `trace_id` et `execution_mode: in_process`.

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
TOUJOURS TRAITER LA CAUSE.
NO FALLBACK SILENCIEUX.
NO SHARED LAYER.
