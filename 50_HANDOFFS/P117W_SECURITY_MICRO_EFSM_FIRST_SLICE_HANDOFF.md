# P117W — Handoff : Security micro-EFSM en premier

State: NEXT IMPLEMENTATION SLICE

## Décision

La nouvelle direction est désormais verrouillée dans MAESTRO_WORKSPACE : une application OWASYS générée est un squelette/mock OPUS navigable composé d'un réseau de micro-EFSM spécialisées.

Le premier domaine à implémenter est Security.

## Périmètre Security

Security inclut : login, identification, authentification, session, rôles, contexte d'autorisation, expiration, ré-authentification et événements de sécurité.

L'ACL reste un service pur deny-by-default sur identité/roles + ressource + opération. Security établit et maintient le contexte fiable consommé par ACL et les autres micro-EFSM.

## Règle de coopération

- aucune EFSM ne modifie directement le STATE d'une autre ;
- coopération par SIGNAL/COMMAND/EVENT ;
- état courant privé par EFSM ;
- SecurityContext partageable en lecture par injection ;
- piles locales par défaut ;
- mémoire/pile partagée uniquement explicitement ;
- corrélation et Profiler de bout en bout.

## Designer

Dans la section Sécurité de l'application sélectionnée, le diagramme de la Security EFSM de cette application est l'unique graphe édité.

Le designer doit permettre STATE, SIGNAL, transitions, GUARD, ACTION PHP réelle et primitives runtime, avec source canonique/hashes explicites et persistence réelle.

Il n'existe pas de destination utilisateur top-level « FSM ».

## Squelette/mock

Le squelette généré doit déjà être navigable avant métier. Le développeur complète ensuite principalement les ACTION PHP, et ajoute les STATE/transitions/pages/guards métier nécessaires.

Le mock n'est pas jetable : c'est la future application réelle sans ses traitements métier spécifiques.

## Sources + Git

Le domaine actuel Sources + Git est conservé fonctionnellement et visuellement. Il recevra sa micro-EFSM propre dans un slice ultérieur, sans réécriture gratuite de ses services existants.

## Baseline technique à auditer avant le ZIP Security

OPUS actuel possède déjà des briques à réutiliser : session/identity OWASYS, SSO providers/manager, AclPolicy, sécurité front -> REST -> back, snapshot/mutation Security, Logger/Profiler.

Le prochain travail n'est donc pas de recréer la sécurité mais d'auditer ces briques puis de faire de Security EFSM l'orchestrateur temporel générique du squelette généré.

Aucun ZIP OPUS/OWASYS n'est déclaré prêt par ce handoff. Le prochain livrable doit être produit seulement après audit du HEAD owner réel et définition exacte du différentiel Security.
