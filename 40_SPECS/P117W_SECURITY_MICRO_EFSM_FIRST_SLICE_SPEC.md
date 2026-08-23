# P117W — Premier vertical slice : Security + Navigation minimale

State: ARCHITECTURE/IMPLEMENTATION TARGET — NEXT SLICE

## Position

Security est la première micro-EFSM à mettre en œuvre dans le squelette d'application généré par OWASYS, mais le premier vertical slice doit également fournir une Navigation micro-EFSM minimale afin que le squelette soit réellement authentifiable et navigable.

Security et Navigation restent deux micro-EFSM distinctes, avec deux définitions canoniques, deux diagrammes contextuels et deux STATE courants indépendants.

Security couvre le domaine complet :

- login / logout ;
- identification de l'utilisateur ;
- authentification via provider configuré ;
- établissement et renouvellement de l'identité/session ;
- utilisateurs ;
- rôles ;
- contexte d'autorisation ;
- expiration ;
- ré-authentification ;
- verrouillage/échec selon besoin ;
- publication des événements de sécurité aux autres micro-EFSM.

Navigation couvre uniquement le parcours fonctionnel/page courant et les conséquences de routage des SIGNALS de navigation.

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

### Navigation EFSM possède

- le STATE fonctionnel/page courant ;
- les SIGNALS utilisateur/automate de navigation ;
- les transitions entre pages/surfaces ;
- les GUARD ACL nécessaires avant accès ;
- la conséquence de routage après transition.

Navigation ne possède ni identité, ni rôles, ni session, ni logique d'authentification.

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

## Navigation minimale du premier slice

Le squelette généré doit au minimum permettre le parcours réel :

- page/login ou point d'entrée SSO ;
- page/home ;
- retour vers login après logout/expiration lorsque la configuration le requiert.

Exemple de coopération :

`Navigation(login) -> COMMAND login_requested -> Security`

`Security(authentication_succeeded) -> EVENT security_authenticated -> Navigation(home)`

`Security(session_expired|logout) -> EVENT security_session_expired|security_logged_out -> Navigation(login)`

La page login est une vue SCORE servie dans le domaine Navigation ; l'authentification elle-même appartient exclusivement à Security.

## Vue Sécurité : EFSM + utilisateurs + rôles

La section `Sécurité` de l'application n'est pas limitée au diagramme EFSM. Elle doit fournir au développeur une vue complète du domaine Security, sans mélanger les responsabilités.

Au minimum, la section comporte trois vues/sous-vues cohérentes :

1. **EFSM Security** : diagramme éditable du workflow login/authentication/logout/reauthentication ;
2. **Utilisateurs** : définition et administration des identités/utilisateurs de l'application ;
3. **Rôles & autorisations** : définition des rôles et des droits sur les RESSOURCES.

Ces vues utilisent les mêmes services Security/ACL réels ; elles ne dupliquent pas la logique de sécurité dans SCORE.

### Définition des utilisateurs

La vue Utilisateurs doit permettre, selon le provider et les capabilities disponibles :

- lister les utilisateurs/identités connus de l'application ;
- créer un utilisateur local lorsque le provider local l'autorise ;
- modifier les attributs administrables ;
- activer/désactiver ou supprimer selon policy ;
- affecter un ou plusieurs rôles ;
- imposer un changement de mot de passe lorsque supporté ;
- distinguer clairement identité locale et identité déléguée SSO/Auth0 ;
- ne jamais exposer ni journaliser de secret/mot de passe/hash sensible.

Le contrat d'identité courant doit rester compatible avec au minimum : `subject`, `label`, `provider`, `roles`, `must_change_password`, état d'activation si supporté et métadonnées strictement nécessaires.

### Définition des rôles

La vue Rôles & autorisations doit permettre :

- créer/renommer/supprimer un rôle selon contraintes de sécurité ;
- afficher les utilisateurs affectés au rôle ;
- associer des droits à des RESSOURCES ;
- définir les opérations CRUD `CREATE`, `READ`, `UPDATE`, `DELETE` ;
- ajouter des opérations métier explicites lorsque CRUD ne suffit pas ;
- visualiser le résultat deny-by-default ;
- prévisualiser puis confirmer les mutations sensibles avec les mécanismes de ré-authentification/confirmation existants.

Le modèle architectural reste :

`ROLE = ensemble de droits (operations) sur des RESSOURCES`

Les rôles ne deviennent jamais des STATE de la Security EFSM.

### Relation avec l'EFSM

Les mutations Utilisateurs/Rôles peuvent déclencher des SIGNALS/EVENTS Security pertinents, par exemple :

- `security_roles_changed` ;
- `security_identity_disabled` ;
- `security_authorization_changed`.

Mais l'édition d'un utilisateur ou d'un rôle n'est pas elle-même un STATE de l'EFSM. L'EFSM orchestre les changements temporels de sécurité ; les utilisateurs/rôles sont des données/ressources administrées par les services Security/ACL.

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
- la surface Security affiche au minimum le diagramme Security, les utilisateurs et les rôles/autorisations selon capabilities ;
- les transitions réelles Security pilotent le parcours ;
- la Navigation EFSM minimale rend le login/home réellement parcourables ;
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

Le front possède sa Security EFSM de présentation/session utilisateur et sa Navigation EFSM. Le back possède sa propre Security EFSM/API de validation des requêtes et du contexte délégué ; il n'a pas de Navigation UI.

La coopération inter-bastions passe exclusivement par REST sécurisé et identité déléguée/contrats signés existants ; aucune lecture directe de session front par le back.

## Designer contextuel

Quand le développeur se trouve dans la section Sécurité de l'application courante, le diagramme affiché doit être la Security EFSM de cette application.

Quand il se trouve dans la section Navigation, le diagramme affiché doit être la Navigation EFSM de cette application.

Le bandeau de conception doit rendre explicites :

- application ;
- EFSM courante ;
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

Les vues Utilisateurs et Rôles restent des vues de gestion Security distinctes du diagramme, mais intégrées dans la même section fonctionnelle Sécurité.

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

Le refactoring doit déplacer l'orchestration temporelle vers Security EFSM et Navigation EFSM sans réécrire les services éprouvés.

## Critères du premier livrable d'implémentation

Le premier livrable devra démontrer sur une application générée fraîche :

1. présence d'une Security EFSM canonique propre à l'application ;
2. présence d'une Navigation EFSM canonique minimale propre au front ;
3. diagramme Security correct et éditable dans la vue Sécurité ;
4. diagramme Navigation correct et éditable dans une vue Navigation séparée ;
5. mock login -> authentification -> home réellement navigable ;
6. logout/expiration -> retour login selon policy ;
7. vue Sécurité avec gestion réelle des utilisateurs selon provider/capabilities ;
8. vue Sécurité avec gestion réelle des rôles et droits CRUD par RESSOURCE ;
9. identité et rôles matérialisés dans un SecurityContext injecté ;
10. ACL deny-by-default consultable par GUARD ;
11. ACTION PHP techniques réelles derrière le workflow ;
12. événements Security/Navigation corrélés et observables par Profiler ;
13. aucune dépendance JavaScript dans `owasys-back` ;
14. aucune régression de Sources + Git, qui sera traité ensuite avec sa propre micro-EFSM ;
15. application générée toujours exploitable comme squelette/mock avant ajout du métier.
