# P112Q3E1A — ASAP RefBook FSM live symbol fix

## Objectif

Corriger P112Q3E1 sur la cible réelle `H:\ASAP` après audit runtime.

L'audit P112Q3E1 a révélé deux symboles FSM présents dans la source réelle mais absents de la baseline initiale :

- `ASAP\Fsm\Fsm`
- `ASAP\Fsm\SignalDefinition`

## Correction

- Ajout de `AsapRefBookClass` sur `ASAP\Fsm\Fsm`.
- Ajout de `AsapRefBookMethod` sur `ASAP\Fsm\Fsm::demoFlow`.
- Ajout de `RefBookInspectableInterface` et `refBookDomain()` sur `ASAP\Fsm\Fsm`.
- Ajout de `AsapRefBookClass` sur `ASAP\Fsm\SignalDefinition`.
- Ajout de `AsapRefBookMethod` sur `ASAP\Fsm\SignalDefinition::__construct`.
- Ajout de `AsapRefBookMethod` sur `ASAP\Fsm\SignalDefinition::id`.
- Ajout de `RefBookInspectableInterface` et `refBookDomain()` sur `ASAP\Fsm\SignalDefinition`.
- Mise à jour du test contractuel pour compter les 9 symboles FSM réels et 33 méthodes publiques.
- Mise à jour du smoke FSM pour vérifier les mêmes compteurs réels.

## Validation attendue

```cmd
cd /d H:\ASAP
tests\Contract\run_refbook_fsm_metadata_contract_test.cmd
tools\smoke\run_p112q3e1_refbook_fsm_metadata_smoke.cmd
tools\refbook\run_p112q3e1_refbook_fsm_metadata_strict.cmd
tools\recipes\run_asap_global_regression_recipe.cmd
tools\recipes\run_p112q3e1_delivery_recipe.cmd
```

Marqueurs attendus :

```text
P112Q3E1_REFBOOK_FSM_METADATA_CONTRACT_UNIT_OK
P112Q3E1_REFBOOK_FSM_METADATA_SMOKE_OK
P112Q3E1_REFBOOK_FSM_METADATA_STRICT_OK
ASAP_GLOBAL_REGRESSION_RECIPE_OK
P112Q3E1_DELIVERY_RECIPE_OK
```
