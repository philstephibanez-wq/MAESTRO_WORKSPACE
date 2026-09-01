# R8B7G — Handoff EFSM I18n front + back

Date: 2026-09-01

## État

- R8B7F runtime exact-locale annoncé fonctionnel par l’owner.
- `navigation.fsm.layout.json` contient une géométrie utilisateur à préserver.
- Prochaine tranche: inventaire exhaustif des labels d’états/transitions EFSM front + back, puis traduction exacte par locale.

## Prochaine action owner

Après `git pull --ff-only` dans `H:\MAESTRO_WORKSPACE`, exécuter:

`python 60_TOOLS\r8b7g_efsm_i18n_inventory.py H:\OPUS`

Retourner toute la sortie de `R8B7G_EFSM_I18N_INVENTORY_V1` à `END`.

## Interdictions

- aucun fallback;
- aucun héritage de catalogue;
- aucune substitution langue nue -> région;
- aucun écrasement des layouts EFSM locaux;
- aucun commit/push OPUS par l’assistant.
