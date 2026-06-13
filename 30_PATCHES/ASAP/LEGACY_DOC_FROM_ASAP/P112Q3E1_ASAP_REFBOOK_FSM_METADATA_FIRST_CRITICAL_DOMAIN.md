# P112Q3E1 — ASAP RefBook FSM Metadata First Critical Domain

## Objectif

P112Q3E1 applique le contrat RefBook Reflection + Attributes au premier domaine critique ASAP : `FSM`.

Le palier prouve le modèle avant extension progressive au reste du framework :

- Reflection reste la vérité technique : classes, méthodes, arguments, retours, lignes source ;
- Attributes `AsapRefBookClass` / `AsapRefBookMethod` portent la vérité fonctionnelle ;
- le domaine FSM fournit des métadonnées complètes classe + méthode ;
- une recette de livraison relance le test ciblé, le smoke, l'audit strict et la recette globale anti-régression.

## Domaine couvert

Fichiers FSM annotés :

- `framework/Asap/Fsm/StateMachine.php`
- `framework/Asap/Fsm/StateDefinition.php`
- `framework/Asap/Fsm/TransitionDefinition.php`
- `framework/Asap/Fsm/TransitionResult.php`
- `framework/Asap/Fsm/StateMemory.php`
- `framework/Asap/Fsm/StateMachineException.php`
- `framework/Asap/Fsm/StateActionInterface.php`

## Contrat validé

Le test ciblé vérifie :

- `ClassMetadataMissing = 0` pour le domaine FSM ;
- `MethodMetadataMissing = 0` pour le domaine FSM ;
- `Violations = 0` pour le domaine FSM ;
- les rôles, comportements, effets de bord, erreurs, tests et diagrammes sont présents ;
- `StateMachine::apply()` conserve son contrat runtime explicite ;
- la transition absente échoue avec `FSM_TRANSITION_NOT_ALLOWED`.

## Commandes

```cmd
cd /d H:\ASAP
tests\Contract\run_refbook_fsm_metadata_contract_test.cmd
tools\smoke\run_p112q3e1_refbook_fsm_metadata_smoke.cmd
tools\refbook\run_p112q3e1_refbook_fsm_metadata_strict.cmd
tools\recipes\run_asap_global_regression_recipe.cmd
tools\recipes\run_p112q3e1_delivery_recipe.cmd
```

## Résultats attendus

```text
P112Q3E1_REFBOOK_FSM_METADATA_CONTRACT_UNIT_OK
P112Q3E1_REFBOOK_FSM_METADATA_SMOKE_OK
P112Q3E1_REFBOOK_FSM_METADATA_STRICT_OK
ASAP_GLOBAL_REGRESSION_RECIPE_OK
P112Q3E1_DELIVERY_RECIPE_OK
ExitCode=0
```

## Notes

Le strict global P112Q3E reste attendu en échec tant que les autres domaines ASAP ne sont pas annotés. P112Q3E1 fournit un strict ciblé FSM qui doit passer.
