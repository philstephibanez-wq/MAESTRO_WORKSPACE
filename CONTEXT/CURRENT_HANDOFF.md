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
CONTEXT/SPECIFICATIONS/OPUS_P117W_R38_REMOVE_LAYERED_CREATION_AND_REGISTRY_SPLIT_BRAIN_2026-07-29.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R38_REMOVE_LAYERED_CREATION_2026-07-29.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Prérequis : R34, R35-R2, R36, R37
```

## Contrat actif

OWASYS contient exactement deux applications autonomes sur deux bastions possibles :

```text
sites/owasys-front
sites/owasys-back
```

Aucune couche `shared`, aucun runtime imbriqué et aucun partage de fichiers, configuration, secrets, état ou diagnostics.

## R38

La session R37 prouve un split-brain de création :

- `OpusConsoleApplication` sélectionne encore `LayeredSiteCommandService` ;
- `opus:create-site` génère `OPUS_SITE_LAYERED_CONTRACT_V2` avec `shared/front/back` ;
- le Registry ignore ce contrat ;
- le frontend termine par `OWASYS_CREATION_REGISTRY_ENTRY_MISSING`.

R38 impose `SiteCommandService`, interdit `application_layers` et refuse explicitement tout site layered dans le Registry. Les classes exclusivement layered doivent être supprimées.

## Validation suivante

Appliquer R38, supprimer les classes layered obsolètes, identifier puis supprimer explicitement le site layered créé pendant la session, relancer les deux applications et valider une création autonome présente immédiatement dans le Registry.

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
TOUJOURS TRAITER LA CAUSE.
NO FALLBACK SILENCIEUX.
NO SHARED LAYER.
