# P112C3 — ASAP FSM + ACL — Squelette PHP

## Statut

Squelette PHP 8+ documenté avant implémentation complète.

## Objectif

Créer les objets contractuels minimum pour porter proprement FSM + ACL.

## Contrat

```text
NO DOC CONTRACT, NO PATCH
NO FALLBACK SILENCIEUX
NO GRAPHVIZ RUNTIME
NO PHP5 BRUTE COPY
NO HTML GENERATED MIXED WITH SOURCE
```

## FSM

Objets créés :

- StateMachine
- StateDefinition
- SignalDefinition
- TransitionDefinition
- TransitionResult
- StateMemory
- StateActionInterface
- StateMachineException

## ACL

Objets créés :

- AccessControl
- RoleDefinition
- ResourceDefinition
- PrivilegeDefinition
- AccessRule
- AccessDecision
- AccessContext
- AccessConditionInterface
- AccessDeniedException
- AccessControlException

## Reference Book

Toutes les APIs publiques ajoutées sont documentées avec des blocs PHPDoc structurés.

Sortie cible future :

```text
DOC/reference/generated/html/
```

## Prochain palier

P112C4 doit ajouter des smoke checks PHP pour valider :

- instanciation FSM
- transition autorisée
- transition refusée
- décision ACL autorisée
- décision ACL refusée
