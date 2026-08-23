# P117W — Première micro-EFSM : Security

State: ARCHITECTURE/IMPLEMENTATION TARGET — NEXT SLICE

## Position

Security est la première micro-EFSM à mettre en œuvre dans le squelette d'application généré par OWASYS.

Elle couvre le domaine complet :

- login / logout ;
- identification de l'utilisateur ;
- authentification via provider configuré ;
- établissement et renouvellement de l'identité/session ;
- rôles ;
- contexte d'autorisation ;
- expiration ;
- ré-authentification ;
- verrouillage/échec selon besoin ;
- publication des événements de sécurité aux autres micro-EFSM.

La décision ACL reste un service pur deny-by-default basé sur identité/roles + ressource + opération. Security fournit le contexte fiable ; l'ACL décide.

## Contrat de responsabilité

### Security EFSM possède

- le STATE du workflow de sécurité ;
- les SIGNALS de sécurité ;
- le cycle login/authentication/logout/reauthentication/expiration ;
- la mise à jour autoritative du `SecurityContext` ;
- l'émission d'EVENTS de sécurité vers le réseau EFSM.

### SecurityContext possède les données courantes

Au minimum :

- subject/identity ;
- provider ;
- authenticated bool ;
- roles ;
- permissions/claims nécessaires ;
- auth level ;
- authenticated_at ;
- expires_at si applicable ;
- must_change_password si applicable ;
- version/hash de contexte.

Les autres micro-EFSM consomment une vue read-only injectée de ce contexte.

### ACL possède

La décision pure :

`identity + roles + resource + operation -> allow | deny`

Une GUARD de type `acl:<resource>:<operation>` consulte ce service sans muter la Security EFSM.

## Squelette minimal Security EFSM

Le squelette doit être simple, navigable et extensible par le développeur.

STATE de base proposés :

- `anonymous` ;
- `authenticating` ;
- `authenticated` ;
- `reauthenticating` ;
- `locked` seulement si le provider/policy le nécessite.

Le squelette ne doit pas créer une combinaison d'états par rôle. Les rôles sont des données du SecurityContext, pas des STATE.

SIGNALS de base :

- `login_requested` ;
- `authentication_succeeded` ;
- `authentication_failed` ;
- `logout_requested` ;
- `session_expired` ;
- `reauth_required` ;
- `reauthentication_succeeded` ;
- `reauthentication_failed` ;
- éventuellement `account_locked` / `account_unlocked` selon policy.

Transitions minimales :

- anonymous + login_requested -> authenticating ;
- authenticating + authentication_succeeded -> authenticated ;
- authenticating + authentication_failed -> anonymous ;
- authenticated + logout_requested -> anonymous ;
- authenticated + session_expired -> anonymous ;
- authenticated + reauth_required -> reauthenticating ;
- reauthenticating + reauthentication_succeeded -> authenticated ;
- reauthenticating + reauthentication_failed -> authenticated ou anonymous selon policy explicite.

## ACTION PHP

Le développeur doit pouvoir ouvrir les ACTION depuis le diagramme et éditer leur vrai code PHP.

Le squelette/framework peut fournir des ACTION techniques standards telles que :

- démarrer/renouveler/détruire la session ;
- matérialiser l'identité depuis un provider ;
- mettre à jour le SecurityContext ;
- publier un EVENT de sécurité.

Le code métier ou provider spécifique reste extensible via ACTION PHP réelles.

Créer, Modifier et Affecter une ACTION sont trois opérations distinctes dans le designer.

## Pages/mock Security

Le squelette généré doit être utilisable immédiatement comme mock fonctionnel.

Selon la configuration de génération :

- une page SCORE login est générée si login local/UI est requis ;
- le mode SSO/Auth0 proxy peut ne pas nécessiter de formulaire local ;
- une surface Security peut afficher identité, rôles et état d'autorisation courant ;
- les transitions réelles Security pilotent le parcours ;
- le mock reste navigable avant toute ACTION métier spécifique.

Une application publique peut conserver Security EFSM avec contexte anonymous/public et ACL correspondante ; l'absence de login obligatoire ne supprime pas le domaine Security.

## Coopération avec Navigation

Navigation ne manipule jamais directement le STATE Security.

Pour un accès ordinaire :

- Navigation reçoit un SIGNAL utilisateur ;
- une GUARD ACL consulte le SecurityContext/ACL ;
- si autorisé, Navigation effectue sa transition ;
- la route reste une conséquence de la navigation.

Pour un changement réel de sécurité, Navigation envoie une COMMAND à Security, par exemple `login_requested` ou `reauth_required`.

Security publie ensuite des EVENTS :

- `security_authenticated` ;
- `security_logged_out` ;
- `security_roles_changed` ;
- `security_session_expired` ;
- `security_reauthenticated`.

Les autres micro-EFSM décident elles-mêmes comment réagir à ces événements.

## Coopération fullstack

Dans un fullstack, front et back restent deux applications OPUS autonomes.

Le front possède sa Security EFSM de présentation/session utilisateur. Le back possède sa propre Security EFSM/API de validation des requêtes et du contexte délégué.

La coopération inter-bastions passe exclusivement par REST sécurisé et identité déléguée/contrats signés existants ; aucune lecture directe de session front par le back.

## Designer contextuel

Quand le développeur se trouve dans la section Sécurité de l'application courante, le diagramme affiché doit être la Security EFSM de cette application.

Le bandeau de conception doit rendre explicites :

- application ;
- EFSM = security ;
- source canonique ;
- hash ;
- mode conception.

Le développeur doit pouvoir :

- créer/renommer/supprimer un STATE valide ;
- créer/éditer les transitions/signals ;
- affecter des GUARD ;
- créer/éditer/affecter des ACTION PHP ;
- éditer les primitives runtime autorisées ;
- sauvegarder de façon persistante ;
- recharger sans perdre les changements.

## Réutilisation de l'existant OPUS/OWASYS

La cible doit réutiliser plutôt que dupliquer :

- SSO manager/providers existants ;
- session/identity existante ;
- `AclPolicy`/décision ACL existante ;
- REST sécurisé front/back ;
- Security snapshot/mutation existants ;
- Logger/Profiler ;
- services File/StructuredFileLoader ;
- mécanismes de source workspace/écriture atomique lorsqu'un fichier de définition doit être modifié.

Le refactoring doit déplacer l'orchestration temporelle vers Security EFSM sans réécrire les services éprouvés.

## Critères du premier livrable d'implémentation

Le premier livrable Security devra démontrer sur une application générée fraîche :

1. présence d'une Security EFSM canonique propre à l'application ;
2. diagramme Security correct et éditable dans le contexte Sécurité ;
3. mock login/identification/autorisation navigable selon la configuration ;
4. identité et rôles matérialisés dans un SecurityContext injecté ;
5. ACL deny-by-default consultable par GUARD ;
6. ACTION PHP techniques réelles derrière le workflow ;
7. événements Security observables par Profiler ;
8. aucune dépendance JavaScript dans `owasys-back` ;
9. aucune régression de Sources + Git, qui sera traité ensuite avec sa propre micro-EFSM ;
10. application générée toujours exploitable comme squelette/mock avant ajout du métier.
