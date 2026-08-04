# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-04.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 61c83d8a56bdbbb792fdf4d5c1a39e79b249cf30
Dernier acquis : R45B2A1R3
```

## Livrable owner actif — R45B2A1R4

```text
ZIP     : opus_p117w_r45b2a1r4_canonical_fsm_transition_fields.zip
SHA-256 : dca1517533e6d4dab61e96e0ee335df7993252e35e5112951005a9e0ba8cef0e
FILES   : 1
BASE    : 61c83d8a56bdbbb792fdf4d5c1a39e79b249cf30
STATUS  : livré, validation et push owner requis
```

R45B2A1R3 est acquis. La création atteint désormais le runtime, qui révèle `OPUS_FSM_TRANSITION_FIELDS_INVALID` : le scaffold écrit `event`/`to` alors que le contrat principal exige `signal`/`next_state`.

R45B2A1R4 corrige uniquement les producteurs frontend/fullstack et backend dans `SiteScaffoldPlan`. Aucun site généré n'est modifié.

## Suite gouvernée

- R45B2A2 : rétention bornée et rotation JSONL configurable ;
- R45B3 : client REST frontend générique et validateurs croisés ;
- R45C : wizard OWASYS structuré ;
- R45D : administration Sécurité.

NO ACL BYPASS.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
