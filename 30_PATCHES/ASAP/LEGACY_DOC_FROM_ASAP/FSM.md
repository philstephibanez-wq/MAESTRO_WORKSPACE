# ASAP FSM

## Rôle

La FSM ASAP est le moteur d’état générique du framework.

Elle peut servir :

- à l’état global d’un site
- au workflow d’une requête
- au lockdown sécurité
- aux transitions backoffice
- aux états d’un module applicatif

## Contrat

FSM ne gère pas les droits.
FSM ne rend pas l’UI.
FSM ne route pas.
FSM ne fallback pas.

## Concepts racines

- signal
- state
- nextState
- action
- memory
- stack
- fifo
- lifo
- timeout
- saveState
- loadState
