# R8B7G — Handoff EFSM I18n front + back

Date: 2026-09-01

## État

- R8B7F est le HEAD OPUS GitHub courant: `6f4ed3c5e1dbd8cda3c9da2c7a459b367963227e`.
- R8B7F runtime exact-locale est annoncé fonctionnel par l’owner.
- `navigation.fsm.layout.json` est une géométrie utilisateur à préserver et ne doit être ni écrasée ni réinitialisée.
- L’inventaire EFSM et la mise à jour de MAESTRO_WORKSPACE sont à la charge exclusive du chat MAESTRO; aucune action workspace n’est demandée à l’owner.

## Inventaire source GitHub

Le chat relit directement les `sites/owasys-front/config/*.fsm.json` et `sites/owasys-back/config/*.fsm.json` du HEAD GitHub courant et construit la matrice exacte states/transitions/label_key.

La tranche de traduction doit couvrir toutes les EFSM canoniques front + back, toutes les locales sélectionnables exactes et aligner `en-EN` côté back.

## Prochaine action owner

Uniquement un gate OPUS local avant application du ZIP de traduction:

- confirmer le HEAD OPUS attendu;
- confirmer le worktree propre.

Aucune commande MAESTRO_WORKSPACE n’est demandée à l’owner.

## Interdictions

- aucun fallback;
- aucun héritage de catalogue;
- aucune substitution langue nue -> région;
- aucun écrasement des layouts EFSM locaux;
- aucun commit/push OPUS par l’assistant;
- aucun transfert de responsabilité de maintenance MAESTRO_WORKSPACE vers l’owner.
