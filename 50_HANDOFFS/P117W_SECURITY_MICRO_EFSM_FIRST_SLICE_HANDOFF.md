# P117W — Handoff : premier vertical slice Security + Navigation

State: NEXT IMPLEMENTATION SLICE

## Décision

La direction est verrouillée dans MAESTRO_WORKSPACE : une application OWASYS générée est un squelette/mock OPUS navigable composé d'un réseau de micro-EFSM spécialisées.

Le premier vertical slice n'est plus Security isolée : il comprend Security + une Navigation minimale, chacune avec son propre diagramme et sa propre définition canonique.

## Périmètre Security

Security inclut : login, identification, authentification, session, utilisateurs, rôles, contexte d'autorisation, expiration, ré-authentification et événements de sécurité.

L'ACL reste un service pur deny-by-default sur identité/roles + ressource + opération. Security établit et maintient le contexte fiable consommé par ACL et les autres micro-EFSM.

## Vue Sécurité obligatoire

La section Sécurité de l'application sélectionnée doit fournir au minimum trois sous-vues cohérentes :

- **EFSM Security** : diagramme éditable du workflow login/authentication/logout/reauthentication ;
- **Utilisateurs** : définition/administration des utilisateurs ou identités selon le provider ;
- **Rôles & autorisations** : définition des rôles et des droits par RESSOURCE/opération.

La vue Utilisateurs doit permettre selon capabilities : liste, création locale, modification, activation/désactivation ou suppression selon policy, affectation des rôles, changement de mot de passe imposé et distinction local/SSO, sans jamais exposer les secrets.

La vue Rôles doit matérialiser le contrat :

`ROLE = ensemble de droits sur des RESSOURCES`

avec CRUD `CREATE`, `READ`, `UPDATE`, `DELETE` et opérations métier explicites lorsque CRUD ne suffit pas.

Les utilisateurs et rôles ne sont pas des STATE de l'EFSM. Ce sont des données/ressources Security administrées par les services existants. Le diagramme Security reste l'orchestrateur temporel de l'authentification/session.

## Navigation minimale obligatoire

Pour qu'un squelette soit réellement navigable comme un mock, le même vertical slice doit fournir une Navigation micro-EFSM minimale dans une vue séparée.

Parcours attendu :

`login/navigation -> COMMAND login_requested -> Security -> EVENT security_authenticated -> Navigation/home`

et, selon policy :

`Security logout/session_expired -> EVENT -> Navigation/login`

La page login est une page SCORE projetée par Navigation ; l'authentification appartient exclusivement à Security.

## Règle de coopération

- aucune EFSM ne modifie directement le STATE d'une autre ;
- coopération par SIGNAL/COMMAND/EVENT ;
- état courant privé par EFSM ;
- SecurityContext partageable en lecture par injection ;
- piles locales par défaut ;
- mémoire/pile partagée uniquement explicitement ;
- corrélation et Profiler de bout en bout.

## Designer

Dans la section Sécurité de l'application sélectionnée, le diagramme Security de cette application est l'unique graphe édité.

Dans la section Navigation, le diagramme Navigation de cette application est l'unique graphe édité.

Le designer doit permettre STATE, SIGNAL, transitions, GUARD, ACTION PHP réelle et primitives runtime, avec application/efsm/source canonique/hash explicites et persistence réelle.

Les vues Utilisateurs et Rôles sont des vues de gestion Security séparées du diagramme mais intégrées à la même section fonctionnelle Sécurité.

Il n'existe pas de destination utilisateur top-level « FSM ».

## Squelette/mock

Le squelette généré doit déjà être authentifiable et navigable avant métier. Le développeur complète ensuite principalement les ACTION PHP et ajoute les STATE/transitions/pages/guards métier nécessaires.

Le mock n'est pas jetable : c'est la future application réelle sans ses traitements métier spécifiques.

## Sources + Git

Le domaine actuel Sources + Git est conservé fonctionnellement et visuellement. Il recevra sa micro-EFSM propre dans un slice ultérieur, sans réécriture gratuite de ses services existants.

## Baseline technique à auditer avant ZIP

OPUS actuel possède déjà des briques à réutiliser : session/identity OWASYS, SSO providers/manager, AclPolicy, sécurité front -> REST -> back, snapshot/mutation Security, Logger/Profiler.

Le prochain travail n'est pas de recréer la sécurité ou la navigation mais d'auditer ces briques, séparer correctement les responsabilités puis faire de Security et Navigation les deux premières micro-EFSM coopérantes du squelette généré.

Le prochain audit doit notamment vérifier les modèles et mutations réelles des utilisateurs, rôles, permissions, providers, sessions et ACL afin que la vue Sécurité repose sur les autorités existantes et non sur des données inventées.

Aucun ZIP OPUS/OWASYS n'est déclaré prêt par ce handoff. Le prochain livrable doit être produit seulement après audit du HEAD owner réel et définition exacte du différentiel Security + Navigation.
