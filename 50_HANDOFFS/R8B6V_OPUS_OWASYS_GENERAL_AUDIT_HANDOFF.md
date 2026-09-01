# HANDOFF — R8B6V OPUS + OWASYS general audit

## Baseline OPUS

`7dfb6206986cf1b7a738065df235fd04ab19fb3b` (`R8B6U`)

## Livrable chat

`R8B6V.zip`

Contenu différentiel :

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `tools/audit_opus_owasys.py`

## Évolution fonctionnelle

Un label I18n manquant dans un diagramme EFSM n'est plus affiché comme `⚠` seul mais comme `⚠ <id>` pour les states et transitions. Les IDs restent techniques et non traduits.

## Audit

Le runner couvre : syntaxe PHP, interfaces framework, configuration, SCORE-only front, interdiction JS backend, séparation front/back, Singleton, FSM, ACL/SSO, I18n et hygiène du dépôt.

La sortie réelle du runner est la gate obligatoire avant tout correctif d'audit suivant. Ne pas déduire le résultat complet depuis le pré-audit GitHub.

## Workflow

L'assistant ne committe/pousse pas OPUS/OWASYS. L'owner applique `R8B6V.zip`, exécute le runner, puis transmet toute la sortie. Le chat analyse et prépare le lot correctif suivant selon la cause et la criticité.
