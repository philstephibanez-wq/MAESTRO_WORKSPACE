# HANDOFF — OPUS P117W R45B2A1R4

Date : 2026-08-04
Base : `61c83d8a56bdbbb792fdf4d5c1a39e79b249cf30`

R45B2A1R3 est acquis. Le test owner suivant prouve que la création aboutit, puis que le runtime refuse la FSM générée avec `OPUS_FSM_TRANSITION_FIELDS_INVALID`.

La cause est le format de transition écrit par `SiteScaffoldPlan` : `event`/`to` au lieu du contrat `signal`/`next_state` exigé par `FsmProcessor` et les consommateurs du runtime principal.

R45B2A1R4 corrige les deux producteurs génériques dans un seul fichier framework. Aucun fichier du site créé n'est inclus ou corrigé.

```text
ZIP     : opus_p117w_r45b2a1r4_canonical_fsm_transition_fields.zip
SHA-256 : dca1517533e6d4dab61e96e0ee335df7993252e35e5112951005a9e0ba8cef0e
FILES   : 1
```

Gate owner : lint, autoload, validation des deux bastions, suppression du site de test uniquement via la commande OPUS prévue, nouvelle génération OWASYS, puis lancement du nouveau site. Aucun correctif manuel du site généré.

