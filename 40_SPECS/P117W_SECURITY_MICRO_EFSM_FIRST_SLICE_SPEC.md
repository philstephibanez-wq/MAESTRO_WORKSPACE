# P117W — Premier vertical slice : Security + Navigation minimale

State: ARCHITECTURE/IMPLEMENTATION TARGET — NEXT SLICE

## Position

Security est la première micro-EFSM à mettre en œuvre dans le squelette d'application généré par OWASYS, mais le premier vertical slice doit également fournir une Navigation micro-EFSM minimale afin que le squelette soit réellement authentifiable et navigable.

Security et Navigation restent deux micro-EFSM distinctes, avec deux définitions canoniques, deux diagrammes contextuels et deux STATE courants indépendants.

Security couvre le domaine complet :

- login / logout ;
- identification de l'utilisateur ;
- authentification via provider configuré ;
- SSO et providers d'identité ;
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

### SSO possède l'authentification déléguée/provider

Le SSO n'est pas une EFSM séparée par défaut. Il est un ensemble de providers/services d'identité consommés par les ACTION de la Security EFSM.

Le contrat SSO doit au minimum couvrir :

- provider par défaut ;
- providers activés ;
- capabilities de chaque provider ;
- authentification locale lorsqu'elle est activée ;
- Auth0/proxy/bastion conformément au contrat OPUS ;
- mapping du subject, label et des rôles/claims ;
- paramètres de confiance du proxy ;
- politique de changement/réinitialisation de mot de passe uniquement lorsque le provider le permet ;
- aucun secret affiché, journalisé ou renvoyé dans SCORE/Profiler.

Le provider authentifie et produit une identité normalisée. La Security EFSM orchestre quand cette authentification est demandée, réussit, échoue, expire ou doit être renouvelée.

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

Le squelette ne doit pas créer une combinaison d'états par rôle ou provider. Les rôles et le provider sont des données du SecurityContext, pas des STATE.

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

La page login est une vue SCORE servie dans le domaine Navigation lorsqu'un formulaire local est requis ; l'authentification elle-même appartient exclusivement à Security. Avec un provider SSO/proxy, le point d'entrée peut être une redirection/identité déléguée sans formulaire local.

## Vue Sécurité : EFSM + utilisateurs + rôles + SSO

La section `Sécurité` de l'application n'est pas limitée au diagramme EFSM. Elle doit fournir au développeur une vue complète du domaine Security, sans mélanger les responsabilités.

Au minimum, la section comporte quatre vues/sous-vues cohérentes :

1. **EFSM Security** : diagramme éditable du workflow login/authentication/logout/reauthentication ;
2. **Utilisateurs** : définition et administration des identités/utilisateurs de l'application ;
3. **Rôles & autorisations** : définition des rôles et des droits sur les RESSOURCES ;
4. **SSO** : configuration, inspection et capabilities des providers d'identité/authentification.

Ces vues utilisent les mêmes services Security/SSO/ACL réels ; elles ne dupliquent pas la logique de sécurité dans SCORE.

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

### Définition du SSO

La vue SSO doit être une vue de configuration/inspection des providers réels de l'application. Elle doit permettre, uniquement selon les capabilities exposées par OPUS :

- voir le provider par défaut ;
- voir les providers activés/désactivés ;
- choisir le provider par défaut lorsque la configuration le permet ;
- inspecter le type/capabilities d'un provider sans exposer de secret ;
- configurer les paramètres non secrets du provider local ;
- configurer pour Auth0/proxy les adresses de proxy de confiance, noms de headers subject/roles/label/secret et la référence au nom de variable d'environnement contenant le secret ;
- visualiser le mapping des claims/roles vers l'identité OPUS normalisée ;
- indiquer clairement si un formulaire login local est requis ou si l'identité est déléguée ;
- tester/valider la configuration par les services OPUS appropriés sans jamais afficher la valeur d'un secret.

Les secrets restent hors SCORE, hors Git, hors logs et hors Profiler. La vue peut afficher qu'un secret est configuré/absent uniquement si cette information est disponible sans divulgation.

SSO n'est pas un STATE et un provider n'est pas une EFSM : les providers sont des services d'authentification appelés par des ACTION de la Security EFSM.

### Relation avec l'EFSM

Les mutations Utilisateurs/Rôles/SSO peuvent déclencher des SIGNALS/EVENTS Security pertinents, par exemple :

- `security_roles_changed` ;
- `security_identity_disabled` ;
- `security_authorization_changed` ;
- `security_provider_changed` ;
- `security_session_invalidated` si une mutation exige de révoquer/revalider le contexte courant.

Mais l'édition d'un utilisateur, d'un rôle ou d'un provider n'est pas elle-même un STATE de l'EFSM. L'EFSM orchestre les changements temporels de sécurité ; utilisateurs/rôles/providers sont des données et services administrés par le domaine Security.

## ACTION PHP

Le développeur doit pouvoir ouvrir les ACTION depuis le diagramme et éditer leur vrai code PHP.

Le squelette/framework peut fournir des ACTION techniques standards telles que :

- demander l'authentification au provider SSO configuré ;
- matérialiser l'identité normalisée depuis un provider ;
- démarrer/renouveler/détruire la session ;
- mettre à jour le SecurityContext ;
- publier un EVENT de sécurité.

Le code métier ou provider spécifique reste extensible via ACTION PHP réelles.

Créer, Modifier et Affecter une ACTION sont trois opérations distinctes dans le designer.

## Pages/mock Security

Le squelette généré doit être utilisable immédiatement comme mock fonctionnel.

Selon la configuration de génération :

- une page SCORE login est générée si login local/UI est requis ;
- le mode SSO/Auth0 proxy peut ne pas nécessiter de formulaire local ;
- la surface Security affiche au minimum le diagramme Security, les utilisateurs, les rôles/autorisations et le SSO selon capabilities ;
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
- `security_reauthenticated` ;
- `security_provider_changed` lorsque pertinent.

Les autres micro-EFSM décident elles-mêmes comment réagir à ces événements.

## Coopération fullstack

Dans un fullstack, front et back restent deux applications OPUS autonomes.

Le front possède sa Security EFSM de présentation/session utilisateur et sa Navigation EFSM. Le back possède sa propre Security EFSM/API de validation des requêtes et du contexte délégué ; il n'a pas de Navigation UI.

La coopération inter-bastions passe exclusivement par REST sécurisé et identité déléguée/contrats signés existants ; aucune lecture directe de session front par le back. Le SSO/proxy doit préserver cette séparation : l'identité de confiance transmise au back suit le contrat REST sécurisé et n'autorise aucun partage implicite de session/front filesystem.

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

Les vues Utilisateurs, Rôles et SSO restent des vues de gestion Security distinctes du diagramme, mais intégrées dans la même section fonctionnelle Sécurité.

## Réutilisation de l'existant OPUS/OWASYS

La cible doit réutiliser plutôt que dupliquer :

- SSO manager/providers existants, notamment local-password et Auth0 proxy lorsqu'ils sont présents ;
- configuration SSO existante et ses contrats ;
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
5. mock login/point d'entrée SSO -> authentification -> home réellement navigable ;
6. logout/expiration -> retour login ou reprise SSO selon policy ;
7. vue Sécurité avec gestion réelle des utilisateurs selon provider/capabilities ;
8. vue Sécurité avec gestion réelle des rôles et droits CRUD par RESSOURCE ;
9. vue SSO avec providers/capabilities/configuration non secrète réels, provider par défaut et Auth0/proxy/local selon configuration ;
10. identité, provider et rôles matérialisés dans un SecurityContext injecté ;
11. ACL deny-by-default consultable par GUARD ;
12. ACTION PHP techniques réelles derrière le workflow Security/Navigation ;
13. événements Security/Navigation corrélés et observables par Profiler ;
14. aucun secret exposé par SCORE, logs ou Profiler ;
15. aucune dépendance JavaScript dans `owasys-back` ;
16. aucune régression de Sources + Git, qui sera traité ensuite avec sa propre micro-EFSM ;
17. application générée toujours exploitable comme squelette/mock avant ajout du métier.
