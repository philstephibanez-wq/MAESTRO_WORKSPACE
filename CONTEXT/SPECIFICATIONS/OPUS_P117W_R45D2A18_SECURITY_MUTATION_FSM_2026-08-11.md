# OPUS P117W R45D2A18 — Security Mutation FSM

Date : 2026-08-11
Statut : livrable owner à appliquer/valider

## Cause

Le workspace Sécurité OWASYS est accessible et le flux `owasys-front -> REST -> owasys-back -> Composer` est sain. Cependant, la FSM de navigation ne connaît que `open_security` et les mutations Sécurité restent procédurales dans `SecurityController`. Cela viole le contrat de pilotage intégral par FSM.

## Solution

Ajouter une FSM dédiée `sites/owasys-front/config/security.mutation.fsm.json` sans perturber la FSM de navigation.

Workflow :

`idle -> requested -> authenticated -> authorized -> validated -> previewed -> confirmed -> committed`

Branches :

- `* -> rejected`
- `confirmed -> rolled_back`

La FSM est persistée dans la session front entre preview et commit via `FsmSessionStore`.

Le binding de session couvre :

- `site_id`
- hash canonique de la mutation + reason
- vue Sécurité courante

Le commit est refusé si l'état restauré n'est pas `previewed` ou si le binding diffère.

## Invariants

- backend reste l'autorité sur ACL, fresh-auth, state hash, confirmation token, transaction et rollback ;
- aucune mutation viewer ;
- aucun mot de passe dans mémoire FSM, logs ou Profiler ;
- aucune preuve fresh-auth complète dans mémoire FSM ;
- aucun replay store REST ;
- aucun patch site-specific ;
- SCORE reste l'unique rendu UI ;
- la FSM dédiée alimente le Profiler OPUS par les événements réellement exécutés de `FsmProcessor`.

## Livrable

```text
ZIP     : opus_p117w_r45d2a18_security_mutation_fsm.zip
SHA-256 : 4b54105a5836dfe4fb0136eee1a74b8c7bd6a71a2afc1b4ee1bf44ff59be4afd
BASE    : R45D2A17 local + R45D2A16B local validé
FILES   : 3
```

## Gate owner

1. appliquer applicateur ;
2. smoke FSM ;
3. lint SecurityController ;
4. dump-autoload ;
5. démarrer back/front ;
6. admin : preview puis commit avec nouvelle réauthentification ;
7. vérifier transitions FSM dans Profiler ;
8. developer : même workflow ;
9. viewer : lecture seule et aucune action de mutation.
