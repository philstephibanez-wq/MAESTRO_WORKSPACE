# OPUS / OWASYS — contrat de création d'application et de sécurité des ressources

Date : 2026-07-31  
Statut : contrat obligatoire  
Portée : framework OPUS, OWASYS et toute application générée par OWASYS

## 1. Décisions définitives

OWASYS propose exactement trois modes, sans présélection :

- `frontend` : client SCORE connecté à un backend existant ;
- `backend` : serveur métier et API REST sécurisée, sans interface SCORE ;
- `fullstack` : frontend SCORE et backend REST corrélés, formant une application client-serveur.

`fullstack = frontend + backend`.

Le concept, profil, dossier ou runtime `shared` est interdit. Les fonctions communes proviennent directement du framework OPUS.

Toute application OPUS reste autonome sous `sites/<application>/`, Singleton, pilotée par FSM, I18n, SSO et ACL `deny-by-default`, instrumentée par Logger et Profiler. Toute interface est rendue exclusivement avec SCORE.

## 2. Responsabilités par mode

### 2.1 Frontend

Le frontend contient l'interface SCORE, la FSM de navigation, l'I18n, le client REST et, si demandé, le parcours de connexion.

Il ne stocke pas les identités, rôles, permissions ou ACL comme autorité de sécurité. Il peut masquer une action interdite pour l'ergonomie, mais le backend cible prend la décision d'autorisation.

OWASYS exige l'identifiant ou l'URL contractuelle du backend cible.

### 2.2 Backend

Le backend contient l'API REST, les services métier, la persistance, l'intégration SSO, le catalogue des ressources, les rôles, permissions, attributions et ACL.

Il ne contient aucune page SCORE, aucun login graphique et aucun JavaScript. Toute administration de sécurité passe par son API REST sécurisée.

### 2.3 Fullstack

OWASYS crée un frontend SCORE et un backend REST explicitement corrélés.

Flux obligatoire :

`frontend SCORE -> REST sécurisé -> backend -> services/persistance -> réponse -> ViewModel -> SCORE`

Il n'existe aucune troisième partie applicative intermédiaire.

## 3. Objets contractuels de sécurité

### 3.1 Identité

Une identité est fournie par SSO et normalisée par :

- `provider` : fournisseur de confiance ;
- `subject` : identifiant immuable chez ce fournisseur ;
- `label` : libellé d'affichage, non utilisé pour autoriser ;
- `status` : `active`, `disabled` ou `pending`.

La clé de sécurité unique est `provider + subject`. L'adresse électronique et le libellé ne sont jamais des identifiants d'autorisation.

OPUS ne crée pas le compte externe, ne collecte pas son mot de passe et ne versionne aucun secret. `local-password` est réservé au développement dans un stockage runtime non versionné.

### 3.2 Rôle

Un rôle regroupe des droits cohérents. Il possède :

- un `role_id` technique stable ;
- un libellé I18n modifiable ;
- un état actif ou désactivé ;
- une liste explicite de permissions et de périmètres.

Un changement de libellé ne change jamais `role_id`.

### 3.3 Permission

Une permission représente une capacité stable au format :

`<resource_type>:<action>`

Exemples :

- `application:read`
- `application:update`
- `document:read`
- `document:update`
- `identity:assign-role`
- `role:manage`
- `acl:manage`

Une permission ne désigne ni un utilisateur ni une ressource particulière.

### 3.4 Ressource

Toute ressource protégée est enregistrée dans un catalogue avec :

- `resource_type` : type stable, par exemple `application`, `document`, `project`, `route` ;
- `resource_id` : identifiant stable dans son type ;
- `parent_resource` facultatif ;
- `owner_identity` facultatif lorsque le métier reconnaît un propriétaire ;
- actions supportées ;
- état actif ou archivé.

Identifiant canonique :

`resource:<application_id>:<resource_type>:<resource_id>`

Une route technique est associée à une ressource métier et une action ; elle n'est pas, par défaut, le modèle métier d'autorisation.

### 3.5 Attribution de rôle

Une attribution relie une identité à un rôle dans un périmètre :

- `provider + subject` ;
- `role_id` ;
- `scope_type` ;
- `scope_id` ;
- dates de début et de fin facultatives ;
- état ;
- auteur, motif et `trace_id`.

Périmètres autorisés :

- `application` : toutes les ressources de l'application ;
- `resource_type` : toutes les ressources d'un type ;
- `resource` : une instance précise.

Le périmètre global multi-application est interdit sauf contrat d'administration OPUS distinct et explicite.

### 3.6 Règle ACL

Une règle ACL associe :

- une ressource ou un périmètre ;
- une action ;
- un sujet de règle, normalement un rôle ;
- un effet `allow` ou `deny` ;
- une priorité et une provenance ;
- une période de validité facultative.

Les ACL nominatives directement attachées à une identité sont des exceptions. Elles doivent être motivées, limitées, visibles dans l'autorisation effective et auditées.

## 4. Association des droits utilisateurs aux ressources

Le modèle obligatoire est un RBAC avec portée de ressource :

`identité -> attribution de rôle avec scope -> permissions du rôle -> ressource + action -> décision ACL`

Exemple :

- identité : `auth0|00u123` ;
- rôle : `project-editor` ;
- scope : `resource:my-app:project:P42` ;
- permissions : `project:read`, `project:update`, `document:read`, `document:update`.

Cette identité peut modifier le projet `P42` et, si le contrat de la ressource le prévoit, ses documents enfants. Elle ne peut pas modifier `P43`.

### 4.1 Algorithme de décision

Pour chaque requête, le backend exécute obligatoirement :

1. authentifier et normaliser l'identité SSO ;
2. résoudre la ressource canonique demandée ;
3. vérifier que l'action est déclarée pour son type ;
4. charger les attributions actives de l'identité ;
5. développer les permissions des rôles dans leurs scopes ;
6. appliquer les règles ACL de la ressource et, seulement si déclaré, de ses parents ;
7. faire prévaloir tout `deny` explicite ;
8. autoriser uniquement s'il reste au moins un `allow` applicable ;
9. refuser dans tous les autres cas ;
10. journaliser la décision sans secret.

Formule :

`ALLOW = identité_active AND action_connue AND allow_applicable AND NOT deny_applicable`

L'absence de règle, une ressource inconnue, une action inconnue, un scope expiré ou une erreur de résolution produit un refus explicite. Aucun fallback silencieux.

### 4.2 Héritage

L'héritage de droits n'est jamais implicite. Chaque type de ressource déclare si les droits du parent s'appliquent à ses enfants et pour quelles actions.

Un `deny` explicite sur l'enfant prévaut sur un `allow` hérité.

### 4.3 Propriétaire métier

La propriété d'une ressource ne donne aucun droit par elle-même. Si le métier veut accorder des droits au propriétaire, une politique explicite `owner` doit déclarer les actions concernées.

## 5. Droits initiaux clairs

Rôles de référence proposés à la création ; ils restent modifiables avant confirmation :

| Rôle | Droits initiaux |
|---|---|
| `administrator` | administrer la sécurité et toutes les ressources de l'application |
| `manager` | créer, lire et modifier les ressources métier autorisées, sans administrer la sécurité |
| `contributor` | créer et modifier les ressources situées dans ses scopes |
| `viewer` | lire uniquement les ressources situées dans ses scopes |

Ces rôles n'accordent rien tant que leurs permissions et scopes ne sont pas explicitement enregistrés.

Une application authentifiée administrable exige au moins une identité avec le rôle `administrator` au scope `application`. Une application entièrement anonyme peut être créée sans identité, mais n'expose alors aucune administration.

## 6. Workflow transactionnel de création

Aucune mutation avant la confirmation finale.

1. **Application** : identifiant, nom, description, choix obligatoire `frontend|backend|fullstack`.
2. **Localisation** : langue par défaut, langues de l'Union européenne et ukrainien, fallback explicite.
3. **Exposition** : publique, authentifiée ou mixte.
4. **Connexion** : backend cible pour `frontend` ; corrélation front/back pour `fullstack`.
5. **SSO** : fournisseur, issuer/audience/proxy de confiance et login graphique seulement si un frontend le nécessite.
6. **Rôles** : création des rôles initiaux.
7. **Permissions** : association explicite des capacités aux rôles.
8. **Ressources et ACL** : types de ressources, actions, scopes et règles initiales.
9. **Identités** : références SSO et attributions initiales ; jamais de création de mot de passe.
10. **Récapitulatif** : affichage complet des effets et composants qui seront créés.
11. **Confirmation** : une transaction unique.
12. **Exécution** : `owasys-front -> REST sécurisé -> owasys-back -> Composer -> validation -> Registry`.
13. **Résultat** : succès complet ou rollback complet sans scorie.

Les étapes sans objet sont affichées comme « non applicable » dans le récapitulatif ; elles ne sont pas silencieusement ignorées.

## 7. Workflow de modification dans Sécurité

L'espace **Sécurité** comporte cinq vues distinctes :

1. **Identités** : référencer, désactiver, réactiver et consulter l'historique.
2. **Rôles** : créer, renommer, désactiver et supprimer lorsqu'ils ne sont plus attribués.
3. **Permissions** : associer ou retirer des capacités à un rôle.
4. **Attributions** : attribuer ou révoquer un rôle à une identité dans un scope.
5. **Ressources et ACL** : cataloguer les ressources, définir les règles et afficher l'autorisation effective.

Toute mutation suit :

`demande -> SSO -> garde ACL -> validation -> aperçu du diff -> confirmation -> écriture atomique -> invalidation des autorisations -> audit`

L'aperçu indique l'acteur, la cible, les anciennes et nouvelles valeurs, les accès gagnés ou perdus et les utilisateurs affectés.

## 8. Protections obligatoires

- contrôle décisif exclusivement côté backend ;
- `deny-by-default` ;
- impossibilité de retirer ou désactiver le dernier administrateur actif ;
- garde renforcée pour modifier ses propres privilèges critiques ;
- réauthentification pour les opérations sensibles ;
- contrôle de concurrence par version ou ETag ;
- suppression interdite d'un rôle encore attribué ;
- archivage des ressources sans destruction de l'historique d'autorisation ;
- invalidation immédiate des caches et sessions d'autorisation concernés ;
- aucune modification directe des fichiers de sécurité en production ;
- aucune donnée sensible dans Git, logs, Profiler, exceptions ou artefacts ;
- audit avec acteur, cible, motif, avant/après, résultat et `trace_id`.

## 9. FSM contractuelle

Création :

`application -> localisation -> exposition -> authentification -> roles -> permissions -> ressources_acl -> identites -> review -> confirmed -> provisioning -> succeeded|rolled_back`

Administration :

`requested -> authenticated -> authorized -> validated -> previewed -> confirmed -> committed|rejected|rolled_back`

Toute transition est gardée par SSO/ACL et instrumentée par Logger/Profiler.

## 10. Critères d'acceptation

Le contrat est accepté seulement si les tests prouvent :

- choix explicite des trois modes et absence totale de `shared` ;
- frontend seul relié à un backend existant ;
- backend seul sans SCORE ni JavaScript ;
- fullstack client-serveur avec front et back corrélés ;
- identité unique par `provider + subject` ;
- droits effectifs déterminés par rôle, permission, scope, ressource et action ;
- refus par défaut et priorité du `deny` ;
- héritage uniquement déclaré ;
- aucun contrôle seulement visuel ;
- protection du dernier administrateur ;
- aperçu et confirmation avant mutation ;
- transaction ou rollback intégral ;
- audit Logger/Profiler corrélé ;
- aucune fuite de secret.
