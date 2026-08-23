# P117W — Handoff : premier vertical slice Security + Navigation

State: NEXT IMPLEMENTATION SLICE

## Décision

La direction est verrouillée dans MAESTRO_WORKSPACE : une application OWASYS générée est un squelette/mock OPUS navigable composé d'un réseau de micro-EFSM spécialisées.

Le premier vertical slice n'est plus Security isolée : il comprend Security + une Navigation minimale, chacune avec son propre diagramme et sa propre définition canonique.

## Périmètre Security

Security inclut : login, identification, authentification, SSO/providers, session, utilisateurs, rôles, contexte d'autorisation, expiration, ré-authentification et événements de sécurité.

L'ACL reste un service pur deny-by-default sur identité/roles + ressource + opération. Security établit et maintient le contexte fiable consommé par ACL et les autres micro-EFSM.

Le SSO n'est pas une EFSM séparée par défaut : les providers d'identité/authentification sont des services consommés par les ACTION de la Security EFSM. Le provider authentifie ; la Security EFSM orchestre le cycle temporel.

## Vue Sécurité obligatoire

La section Sécurité de l'application sélectionnée doit fournir au minimum quatre sous-vues cohérentes :

- **EFSM Security** : diagramme éditable du workflow login/authentication/logout/reauthentication ;
- **Utilisateurs** : définition/administration des utilisateurs ou identités selon le provider ;
- **Rôles & autorisations** : définition des rôles et des droits par RESSOURCE/opération ;
- **SSO** : configuration/inspection des providers et de leurs capabilities, sans divulgation de secrets.

La vue Utilisateurs doit permettre selon capabilities : liste, création locale, modification, activation/désactivation ou suppression selon policy, affectation des rôles, changement de mot de passe imposé et distinction local/SSO, sans jamais exposer les secrets.

La vue Rôles doit matérialiser le contrat :

`ROLE = ensemble de droits sur des RESSOURCES`

avec CRUD `CREATE`, `READ`, `UPDATE`, `DELETE` et opérations métier explicites lorsque CRUD ne suffit pas.

La vue SSO doit utiliser les providers OPUS réels et exposer uniquement leur configuration administrable non secrète : provider par défaut, providers activés, capabilities, paramètres local-password et paramètres Auth0/proxy tels que proxy de confiance, noms des headers et référence au nom de variable d'environnement du secret. Une valeur secrète n'est jamais affichée, renvoyée dans SCORE, loggée ni profilée.

Les utilisateurs, rôles et providers ne sont pas des STATE de l'EFSM. Ce sont des données/services du domaine Security. Le diagramme Security reste l'orchestrateur temporel de l'authentification/session.

## Navigation minimale obligatoire

Pour qu'un squelette soit réellement navigable comme un mock, le même vertical slice doit fournir une Navigation micro-EFSM minimale dans une vue séparée.

Parcours attendu :

`login/navigation ou entrée SSO -> COMMAND login_requested -> Security -> EVENT security_authenticated -> Navigation/home`

et, selon policy :

`Security logout/session_expired -> EVENT -> Navigation/login ou reprise SSO`

La page login est une page SCORE projetée par Navigation lorsqu'un formulaire local est requis ; l'authentification appartient exclusivement à Security. Un provider SSO/proxy peut supprimer le formulaire local tout en conservant le même cycle Security.

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

Les vues Utilisateurs, Rôles et SSO sont des vues de gestion Security séparées du diagramme mais intégrées à la même section fonctionnelle Sécurité.

Il n'existe pas de destination utilisateur top-level « FSM ».

## Squelette/mock

Le squelette généré doit déjà être authentifiable et navigable avant métier. Le développeur complète ensuite principalement les ACTION PHP et ajoute les STATE/transitions/pages/guards métier nécessaires.

Le mock n'est pas jetable : c'est la future application réelle sans ses traitements métier spécifiques.

## Sources + Git

Le domaine actuel Sources + Git est conservé fonctionnellement et visuellement. Il recevra sa micro-EFSM propre dans un slice ultérieur, sans réécriture gratuite de ses services existants.

## Baseline technique à auditer avant ZIP

OPUS actuel possède déjà des briques à réutiliser : session/identity OWASYS, SSO providers/manager, configuration SSO, AclPolicy, sécurité front -> REST -> back, snapshot/mutation Security, Logger/Profiler.

Le prochain travail n'est pas de recréer la sécurité, le SSO ou la navigation mais d'auditer ces briques, séparer correctement les responsabilités puis faire de Security et Navigation les deux premières micro-EFSM coopérantes du squelette généré.

Le prochain audit doit notamment vérifier les modèles et mutations réelles des utilisateurs, rôles, permissions, providers SSO, sessions et ACL afin que la vue Sécurité repose sur les autorités existantes et non sur des données inventées.

Le premier ZIP doit partir du HEAD owner réel et traiter la cause architecturale. Il doit conserver le contrat front -> REST sécurisé -> back -> Composer pour toute mutation métier/administrative nécessitant le back et ne doit introduire aucun JavaScript dans `sites/owasys-back`.

Aucun ZIP OPUS/OWASYS n'est déclaré prêt par ce handoff avant audit complet et validation statique du différentiel Security + Navigation + SSO.
