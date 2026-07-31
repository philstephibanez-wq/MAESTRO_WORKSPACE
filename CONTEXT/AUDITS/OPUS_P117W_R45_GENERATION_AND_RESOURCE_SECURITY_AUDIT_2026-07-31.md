# OPUS / OWASYS — audit R45 de la génération des profils et de la sécurité

Date : 2026-07-31  
Base OPUS auditée : `7dbceea` (`opus_p117w_r44c_opaque_score_source_rendering + test2`)  
Statut : audit canonique préalable au développement  
Périmètre : générateur OPUS, assistant OWASYS et moteur ACL générique ; `sites/test2` est un témoin non modifiable.

## 1. Conclusion

R44C valide la transaction de création et le rendu opaque des sources SCORE. Il ne valide pas encore un générateur conforme pour les trois profils ni le contrat de sécurité des ressources.

`test2` est déclaré `frontend` dans `opus-site.json` et `config/site.json`. Il ne peut donc pas servir de preuve fullstack.

Les écarts doivent être corrigés à la source dans OPUS et OWASYS. Aucun fichier de `sites/test2` ne doit être patché ; l'application témoin sera supprimée puis régénérée par l'owner après livraison.

## 2. Ce qui est acquis

- choix explicite `frontend|backend|fullstack` dans OWASYS, sans présélection ;
- transaction `owasys-front -> REST sécurisé -> owasys-back -> Composer` ;
- rollback/scories contrôlés par le workflow existant ;
- site autonome, Singleton, FSM, I18n UE + ukrainien, Logger/Profiler ;
- interface générée en SCORE pour le profil frontend ;
- OPUS possède déjà un moteur ACL hiérarchique générique capable d'évaluer rôles, ressources, privilèges, héritage et règles allow/deny.

## 3. Écarts bloquants du générateur

### 3.1 Profils non réellement distincts

`SiteScaffoldPlan::entries()` crée actuellement la même base de présentation pour les trois profils : `www`, assets, layout SCORE, templates, navigation, module `home` et vues.

`profileCapabilities()` déclare à tort `presentation: true` pour `backend`.

Conséquences :

- `backend` reçoit une interface SCORE et des assets alors qu'il doit être une API REST PHP sans SCORE ni JavaScript ;
- `frontend` ne reçoit aucun contrat obligatoire de backend cible ;
- `fullstack` ne reçoit aucune corrélation explicite entre son frontend SCORE et son backend REST ;
- le flux client-serveur n'est pas prouvé par le scaffold.

### 3.2 Fullstack mal spécifié dans l'implémentation

Le fullstack cible est une seule application et un seul déploiement par défaut sur le même serveur, contenant :

- un client frontend SCORE ;
- un serveur backend REST ;
- une frontière REST obligatoire entre les deux.

Il ne doit générer ni deuxième site indépendant, ni dossier `fullstack`, ni couche `shared`, ni troisième runtime.

### 3.3 Sécurité collectée mais non modélisée

Le wizard collecte des listes textuelles globales :

- rôles ;
- permissions ;
- rôles autorisés sur `home` ;
- utilisateurs initiaux ;
- un rôle commun aux utilisateurs initiaux.

Le blueprint et le scaffold ne produisent pas :

- l'association explicite rôle -> permissions ;
- les types de ressources et leurs actions CRUD/métier ;
- les ressources canoniques ;
- les scopes `application|resource_type|resource` ;
- les attributions `provider + subject -> role_id + scope` ;
- les règles ACL allow/deny ;
- l'autorisation effective ;
- la protection du dernier administrateur ;
- les versions/ETag, aperçu, réauthentification et audit des mutations.

Les permissions écrites dans `config/acl.json` sont donc un catalogue orphelin et n'accordent aucun droit calculable par rôle sur une ressource.

### 3.4 Moteur ACL générique partiellement réutilisable

`Opus\Security\Access\Engine\HierarchicalAclEngine` constitue la bonne base générique, mais deux corrections sont obligatoires avant câblage :

1. la décision actuelle retient la dernière règle correspondante ; le contrat exige qu'un `deny` explicite applicable prévale sur tout `allow` ;
2. `ConfigAclPolicy::fromFile()` lit et parse directement avec `is_file`, `file_get_contents` et `json_decode`, en violation du contrat File + Json/StructuredFileLoader.

Le format ACL simplifié généré (`OPUS_GENERATED_APPLICATION_ACL_V1`) n'est pas le format riche attendu par `ConfigAclPolicy` (`OPUS_ACL_POLICY_REGISTRY_V1`). Le générateur ne câble donc pas le moteur disponible.

## 4. Développement R45 imposé

R45 doit être découpé en gates atomiques.

### R45A — contrats et moteur générique OPUS

- définir les DTO/contrats typés : identité, rôle, permission, type de ressource, ressource, attribution scopée, règle ACL et décision effective ;
- rendre la priorité du `deny` indépendante de l'ordre des règles ;
- imposer ressource/action connues et refus explicite sinon ;
- lire toute configuration via File puis Json/StructuredFileLoader ;
- ajouter interfaces homonymes et quatre marqueurs à toute nouvelle classe concrète ;
- ajouter les smokes unitaires génériques.

### R45B — scaffold réellement profilé

- `frontend` : SCORE/FSM/I18n/client REST, backend cible obligatoire, aucune autorité de sécurité locale ;
- `backend` : API REST/FSM/SSO/ACL/persistance, aucun SCORE, aucun JavaScript ;
- `fullstack` : composants frontend et backend dans le même site et déploiement par défaut, corrélés par URL REST locale contractuelle ;
- aucun `shared` ;
- génération d'un manifeste de corrélation client-serveur ;
- validators prouvant les interdictions propres à chaque profil.

### R45C — assistant OWASYS cohérent

FSM cible :

`application -> localisation -> exposition -> connexion -> sso -> roles -> permissions -> ressources_acl -> identites -> review -> confirmed -> provisioning -> succeeded|rolled_back`

Le wizard doit éditer des structures explicites, pas des listes ambiguës. Aucune mutation avant confirmation.

### R45D — administration Sécurité

Cinq vues SCORE : Identités, Rôles, Permissions, Attributions, Ressources et ACL.

Toute mutation traverse REST sécurisé puis Composer, avec aperçu du diff, confirmation, écriture atomique, version/ETag, réauthentification sensible, invalidation et audit corrélé.

## 5. Critères d'acceptation

La livraison n'est acceptée que si des sites témoins régénérés prouvent :

- frontend sans backend interne et avec backend cible ;
- backend sans fichier SCORE ni JavaScript ;
- fullstack sur un même site/serveur par défaut avec appel REST obligatoire ;
- absence totale de `shared` ;
- rôle associant explicitement CRUD/actions métier à un type de ressource ;
- attribution SSO scopée à une application, un type ou une ressource ;
- `deny-by-default` et priorité absolue du deny ;
- protection du dernier administrateur ;
- aucune correction locale de `test2`.

## 6. Décision

GO R45A uniquement comme prochain patch. R45B, R45C et R45D restent bloqués tant que le moteur et les contrats génériques R45A ne sont pas validés par l'owner.
