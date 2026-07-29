# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-29

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R34_FSM_RUNTIME_ASAP_COMPLIANCE_2026-07-29.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R34_FSM_RUNTIME_ASAP_COMPLIANCE_2026-07-29.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base relue : 47c5bb1d667a43a61ae35ec3465accc29d42f54c
Racine owner : H:\OPUS
Prérequis : R31 + R32 + R33
```

## R34

R34 restaure la FSM OPUS conforme au microprocesseur ASAP :

```text
state + memory + stack
peek + poke + push + pop
FIFO par défaut / LIFO explicite
exact -> __any__ état -> global déclaré -> __default__ déclaré
```

OWASYS Source transmet `open_source_file` et `change_locale` à la FSM. Le script courant et la locale sont mémorisés dans la FSM. L’URL et SCORE dérivent de cet état. Le navigateur n’utilise plus `history.pushState()` et ne possède plus un état parallèle.

## Lancement

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
TOUJOURS TRAITER LA CAUSE.
NO FALLBACK SILENCIEUX.
NO DELIVERY ROOT POLLUTION.
