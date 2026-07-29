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
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R36_FSM_SCORE_CORRELATED_PROFILER_2026-07-29.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base R34 : 47c5bb1d667a43a61ae35ec3465accc29d42f54c
R35 : invalidé
R35-R1 : remplacé avant application
```

## État courant

R34 conserve la FSM ASAP comme propriétaire de l'état et de la navigation.

R35-R2 restaure les huit fichiers formant le dispatch Composer in-process complet et la remise à zéro générique des diagnostics lors de chaque `opus:dev-server`. Chaque application ne conserve que les traces de sa session courante.

Le sélecteur contient déjà les 24 langues officielles UE plus l'ukrainien ; sa barre de défilement expliquait l'impression de locales manquantes. Aucun correctif I18n n'est requis.

R36 introduit le constructeur d'URL OPUS canonique et raccorde l'affichage du
Profiler à la FSM ASAP, à l'ACL administrateur et à SCORE. `profiler=1` est un
paramètre de query string et ne peut jamais devenir un segment Source.

## Validation suivante

Appliquer R36 après R34 et R35-R2. Ouvrir un script avec `?profiler=1`, vérifier
le panneau SCORE, le retour FSM, la conservation locale/script, la corrélation
du `trace_id` et `execution_mode: in_process`.

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
TOUJOURS TRAITER LA CAUSE.
NO FALLBACK SILENCIEUX.
NO DELIVERY ROOT POLLUTION.
