# OPUS P117W R45B2A1R4 — CHAMPS CANONIQUES DES TRANSITIONS FSM GÉNÉRÉES

Date : 2026-08-04
Statut : livrable owner actif
Base OPUS : `61c83d8a56bdbbb792fdf4d5c1a39e79b249cf30`

## Acquisition et preuve

R45B2A1R3 est acquis au HEAD owner. Une application générée puis lancée avec `composer opus:dev-server -- <site> --port=8800` échoue sur `OPUS_FSM_TRANSITION_FIELDS_INVALID`.

`FsmProcessor` exige les champs canoniques `from`, `signal` et `next_state`. `SiteScaffoldPlan` génère encore `event` et `to` pour les FSM frontend/fullstack et backend. La cause est donc dans le générateur OPUS, jamais dans le site produit.

## Correction générique

- produire `signal` à la place de `event` ;
- produire `next_state` à la place de `to` ;
- appliquer ce contrat aux transitions de navigation et au dispatch REST backend ;
- conserver les wildcards, gardes, actions et le validateur strict ;
- ne fournir aucun fallback de compatibilité silencieux ;
- ne modifier aucun site généré.

## Livrable

```text
ZIP     : opus_p117w_r45b2a1r4_canonical_fsm_transition_fields.zip
SHA-256 : dca1517533e6d4dab61e96e0ee335df7993252e35e5112951005a9e0ba8cef0e
FILES   : 1
BASE    : 61c83d8a56bdbbb792fdf4d5c1a39e79b249cf30
```

Chemin : `Opus/Scaffold/SiteScaffoldPlan.php`.

NO LOCAL SITE FIX.
NO FSM FIELD FALLBACK.
NO ACL BYPASS.

