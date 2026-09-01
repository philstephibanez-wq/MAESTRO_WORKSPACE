# R8B7G — Inventaire I18n complet des EFSM OWASYS front + back

Date: 2026-09-01

## Autorités

Appliquer intégralement `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` et `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md`.

## Décision owner

Les traductions visibles de **tous les états et de toutes les transitions EFSM** de `owasys-front` et `owasys-back` sont à la charge du chat MAESTRO.

## Contrat

- couvrir toutes les EFSM canoniques présentes dans `sites/owasys-front/config/*.fsm.json` et `sites/owasys-back/config/*.fsm.json`;
- couvrir tous les `states[].id` et `transitions[].id`;
- utiliser `label_key` lorsqu’il est explicitement déclaré;
- sinon utiliser les clés canoniques `fsm.<efsm_id>.state.<state_id>.label` et `fsm.<efsm_id>.transition.<transition_id>.label`;
- fournir une traduction exacte pour chaque locale sélectionnable, sans `inherits`, sans locale parente, sans langue de base et sans substitution régionale;
- conserver les IDs techniques non traduits;
- lorsqu’une traduction est réellement absente avant livraison, l’UI conserve `⚠ <id>`; après la livraison complète EFSM, aucun state/transition OWASYS couvert ne doit rester en `⚠` pour une locale livrée;
- `en-EN` doit être présent de façon cohérente côté front et back;
- ne jamais traduire par copie aveugle d’une autre locale;
- les traductions doivent être sémantiquement cohérentes avec la fonction de l’état ou de la transition dans la FSM source.

## Méthode

Avant génération des catalogues, exécuter l’inventaire reproductible `60_TOOLS/r8b7g_efsm_i18n_inventory.py` sur le worktree OPUS courant. Le runner est en lecture seule et produit l’ensemble exact des clés EFSM, les locales déclarées front/back et l’état de couverture des catalogues régionaux.

## Gate

Aucun ZIP de traduction massive n’est fabriqué avant réception de la sortie complète de l’inventaire sur le worktree owner courant, afin de préserver les changements locaux R8B7E/R8B7F et les géométries EFSM validées.
