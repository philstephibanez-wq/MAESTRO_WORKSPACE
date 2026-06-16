# OPUS — ADN des sites sécurisés par bastion FSM

Date: 2026-06-16
Status: architecture thesis document for OPUS public presentation
Scope: OPUS, OPUS public release, OPUS documentation, future SERVER_LINUX, KB and Maestro integration

## 1. Résumé

OPUS est un framework MVC PHP data-driven dont la sécurité n'est pas ajoutée autour du routage ou des contrôleurs, mais pilotée par un plan de contrôle central fondé sur une FSM, des ACL et un modèle d'identité de type SSO-like.

La thèse défendue ici est simple : un site web sécurisé ne doit pas être conçu comme une collection de routes menant directement à des contrôleurs. Il doit être conçu comme un système d'états fortifiés. Chaque état applicatif forme une zone protégée. Chaque transition agit comme une porte contrôlée. Chaque route, action, API, rendu, génération de site ou invocation d'outil métier devient une intention qui doit traverser le bastion FSM avant toute exécution.

OPUS vise donc une double exigence : rendre la création de sites simple pour le développeur, tout en rendant impossible le contournement du plan de contrôle. La simplicité vient de la configuration data-driven, de profils déclaratifs et d'outils de génération. La sécurité vient de la FSM, de l'ACL, de l'identité SSO-like, des états bloqués, des audits et des rapports d'exploitation.

## 2. Thèse centrale

OPUS n'est pas seulement un framework MVC. OPUS est un moteur de sites data-driven dont le MVC est piloté par un bastion FSM/ACL/SSO-like.

```text
OPUS = MVC data-driven + plan de contrôle FSM/ACL/SSO-like + génération/configuration + observabilité.
```

Le MVC reste le modèle d'exécution applicative. La FSM ne remplace pas les contrôleurs, les templates ou les ViewModels. Elle contrôle le droit d'atteindre ces composants.

La sécurité d'OPUS repose donc sur une idée forte : aucune intention applicative ne doit atteindre son exécution métier sans être passée par le plan de contrôle.

## 3. Métaphore du bastion FSM

La FSM OPUS peut être comprise comme un bastion.

```text
Chaque état = une zone fortifiée.
Chaque transition = une porte contrôlée.
Chaque route = une intention d'accès.
Chaque controller = un périphérique exécutif autorisé.
Chaque blocage = une fermeture de porte avec trace.
```

Dans un MVC classique, la route conduit rapidement au contrôleur. Dans OPUS, la route devient une instruction d'entrée soumise à l'état courant, à l'identité, aux droits, aux scopes, aux permissions et aux transitions autorisées.

Une requête ne demande donc pas seulement :

```text
Quel controller exécuter ?
```

Elle demande :

```text
Dans quel état suis-je ?
Qui demande l'action ?
Quelle route est appelée ?
Quelle transition est demandée ?
Cette transition existe-t-elle ?
L'acteur est-il authentifié ?
L'acteur possède-t-il les droits ACL nécessaires ?
Le scope API ou SSO-like est-il compatible ?
Le système est-il dans un état intègre ?
```

Seulement après ces décisions, OPUS peut autoriser le contrôleur.

## 4. Séparation stricte des couches

La force d'OPUS dépend de la séparation des métiers de chaque couche. Le plan de contrôle protège l'application, mais les outils métier ne deviennent jamais la couche sécurité.

### 4.1 Plan de contrôle

Le plan de contrôle est responsable des décisions de sécurité et d'état.

```text
CONTROL PLANE
- FSM
- ACL
- identité SSO-like
- authentification
- autorisation
- scopes
- rôles
- permissions
- états bloqués
```

### 4.2 Runtime MVC

Le runtime MVC est responsable de l'exécution applicative autorisée.

```text
MVC RUNTIME
- résolution du site
- résolution de route
- controllers
- ViewModels
- ScoreTemplate
- réponses HTTP ou API
```

### 4.3 Outils métier

Les outils métier font leur travail métier. Ils sont sécurisés par OPUS, mais ne pilotent pas la sécurité OPUS.

```text
TOOLS / BUSINESS UTILITIES
- LSTSAR / TLSTSAR
- générateurs de site
- loaders
- transformers
- stores
- outils KB
- outils Maestro
```

### 4.4 Observabilité et exploitation

L'observabilité fournit les preuves, rapports, journaux et alertes nécessaires à l'exploitation.

```text
OBSERVABILITY / OPERATIONS
- logs
- reports
- audits
- notifications
- dashboard administrateur
```

Règle fondamentale :

```text
Le plan de contrôle protège les outils.
Les outils ne deviennent jamais le plan de contrôle.
```

## 5. Pipeline officiel OPUS

Le pipeline cible d'une requête OPUS doit suivre une séquence contrôlée.

```text
Request
-> Bootstrap
-> Site resolution
-> Route resolution
-> Identity / SSO-like context
-> Authentication decision
-> FSM decision
-> ACL authorization
-> API token / scope decision when applicable
-> Authorized controller action
-> Optional authorized tool invocation
-> ViewModel
-> ScoreTemplate or API response
-> Observability event / report when applicable
```

La FSM ne remplace pas l'ACL ni l'identité. Elle orchestre le contexte de contrôle.

```text
La FSM décide si l'action est possible dans l'état courant.
L'ACL décide si l'acteur a le droit d'exécuter l'action.
Le SSO-like établit qui est l'acteur et avec quel niveau de confiance.
```

## 6. Fail-closed et états bloqués

OPUS doit fonctionner en fail-closed.

Si une situation est étrange, incomplète, incohérente ou suspecte, OPUS ne doit pas continuer par défaut. Il doit passer dans un état bloqué explicite.

Exemples d'états bloqués :

```text
UNKNOWN_ROUTE_BLOCKED
CONFIG_BLOCKED
AUTH_BLOCKED
ACL_BLOCKED
FSM_TRANSITION_BLOCKED
API_SCOPE_BLOCKED
INTEGRITY_BLOCKED
TOOL_INVOCATION_BLOCKED
```

Le blocage ne doit pas être un simple échec technique. Il doit être un état contrôlé, auditable et exploitable.

Un état bloqué doit répondre aux questions suivantes :

```text
Quelle intention a été demandée ?
Qui l'a demandée ?
Dans quel état était le système ?
Quelle transition était attendue ?
Quelle règle a refusé l'exécution ?
Quel est l'état bloqué choisi ?
Quelle intervention est attendue ?
```

## 7. Data-driven : créer un site par configuration

OPUS doit permettre de créer et gérer un site principalement par configuration correcte.

Le développeur ne doit pas écrire toute la plomberie FSM/ACL/SSO-like à la main pour chaque page simple. Il doit pouvoir déclarer des données et des profils de contrôle.

Flux attendu :

```text
site configuration
-> route declarations
-> FSM / ACL / SSO-like policy declarations
-> controller / view / template bindings
-> generator validation
-> generated or validated site skeleton
-> smoke validation report
```

La configuration devient l'ADN du site. Le moteur OPUS la lit, la valide, la sécurise et la transforme en site opérationnel.

Cela suppose des outils officiels :

```text
- création d'un nouveau site
- validation de la configuration
- génération de routes
- génération de squelette controller / ViewModel / template
- génération ou validation des profils FSM/ACL/SSO-like
- génération de diagnostics explicites
- production d'un rapport de validation
```

Le principe est :

```text
Moteur puissant, configuration stricte.
Données correctes, site générable.
Données incorrectes, blocage explicite.
```

## 8. Ergonomie développeur

La sécurité ne doit pas rendre la création d'un site pénible.

OPUS doit proposer deux niveaux d'usage.

### 8.1 Niveau site simple

Pour une page publique simple, le développeur doit pouvoir utiliser un profil standard.

Exemple conceptuel :

```text
route: /about
controller: AboutController
view: about.score
profile: public_page
```

En interne, OPUS applique un profil complet :

```text
state: PUBLIC_BROWSING
identity: anonymous_allowed
acl: public_read
transition: VIEW_PUBLIC_PAGE
observability: PUBLIC_PAGE_VIEW
```

La sécurité existe, mais elle est portée par un profil officiel.

### 8.2 Niveau route sensible

Pour une route admin, API, KB ou Maestro, le développeur doit déclarer explicitement les exigences.

Exemple conceptuel :

```text
route: /admin/sites
controller: AdminSiteController
action: list
profile: admin_page
required_state: AUTHENTICATED_ADMIN
required_role: admin
transition: ADMIN_VIEW_SITE_STATE
scope: site.read
```

Ici, la FSM, l'ACL et le SSO-like deviennent visibles car l'action est sensible.

Règle d'ergonomie :

```text
Simple à déclarer.
Impossible à contourner.
```

## 9. Dashboard administrateur

OPUS doit offrir ou supporter un dashboard administrateur. Ce dashboard n'est pas une porte arrière. C'est une application OPUS protégée par le même plan de contrôle.

Il doit permettre à l'administrateur de superviser et d'intervenir sans contourner la sécurité.

Fonctions possibles :

```text
- voir les sites déclarés
- voir l'état FSM de chaque site
- voir les routes actives
- voir les profils ACL / scopes / rôles
- voir les états bloqués
- consulter les rapports
- acquitter une alerte
- relancer un audit
- recharger une configuration
- débloquer manuellement une situation si autorisé
```

Chaque bouton du dashboard doit correspondre à :

```text
une route
+ une intention
+ une transition FSM
+ une permission ACL
+ un contexte d'identité
+ un audit / report
```

## 10. Notifications et intervention humaine

Lorsqu'un état bloqué survient, OPUS doit pouvoir remonter l'information par un canal d'exploitation : mail, dashboard, webhook ou API interne.

La notification n'est pas la sécurité. Elle n'est pas LSTSAR. Elle est un canal d'exploitation.

Flux cible :

```text
anomalie détectée
-> état bloqué FSM
-> événement d'observabilité
-> notification d'exploitation
-> intervention humaine si nécessaire
-> action de déblocage autorisée et auditée
```

Aucun auto-déblocage silencieux ne doit être autorisé.

## 11. Place de LSTSAR / TLSTSAR

LSTSAR / TLSTSAR est une classe ou famille d'outils utile et data-driven. Elle est sécurisée par OPUS, comme les autres outils métier. Elle ne fait pas partie de la couche sécurité.

Son rôle est métier :

```text
Trace -> Load -> Secure -> Transform -> Store -> Audit -> Report
```

Dans une opération LSTSAR, le `Report` est obligatoire parce qu'il prouve le traitement métier réalisé. Mais ce `Report` n'est pas le plan de sécurité OPUS.

La règle est :

```text
FSM / ACL / SSO-like autorisent ou bloquent l'accès à LSTSAR.
LSTSAR exécute son métier uniquement après autorisation.
LSTSAR produit son rapport métier.
```

## 12. Apports attendus pour OPUS

Le modèle FSM-Bastion donne à OPUS une identité propre.

OPUS n'est pas un clone de Laravel ou Symfony. OPUS vise un autre domaine : les applications contrôlées, auditables, data-driven, administrables, utiles à des systèmes comme KB et Maestro.

Apports :

```text
- sécurité intégrée au flux
- configuration déclarative stricte
- génération de sites par données
- séparation forte des couches
- observabilité intégrée
- dashboard administrateur
- blocage fail-closed
- adaptation à KB et Maestro
```

## 13. Validation expérimentale

Pour prouver OPUS, il faudra valider plusieurs scénarios.

### 13.1 Site public simple

```text
Créer un site
Déclarer une page publique
Générer ou valider route/controller/ViewModel/template
Rendre la page
Produire un rapport de validation
```

### 13.2 Route protégée

```text
Déclarer une route admin
Déclarer état FSM et rôle ACL
Tester accès autorisé
Tester accès refusé
Vérifier état bloqué / audit / notification
```

### 13.3 API SSO-like

```text
Déclarer un endpoint API
Présenter token / scope
Valider identité
Valider scope
Refuser token expiré ou douteux
Produire événement d'observabilité
```

### 13.4 Outil métier LSTSAR

```text
Déclarer une opération LSTSAR
Contrôler l'accès par FSM/ACL/SSO-like
Exécuter l'outil
Produire le report métier
Stocker le rapport hors racine source OPUS
```

### 13.5 Dashboard administrateur

```text
Voir un état bloqué
Consulter le rapport
Acquitter l'alerte
Débloquer manuellement si autorisé
Auditer l'intervention
```

## 14. Lien avec KB et Maestro

OPUS est vital pour KB et Maestro parce qu'il doit fournir une base web et API contrôlée, sûre, administrable et documentée.

KB a besoin d'un socle capable de gérer des données, des jobs, des validations et des interfaces d'administration sans contournement de sécurité.

Maestro a besoin d'un socle capable de présenter des états, des workflows, des services, des rapports et des décisions dans une interface claire et contrôlée.

OPUS doit donc devenir le socle public et technique qui permet de revenir à KB et Maestro rapidement, puis à l'objectif final : composer de la musique.

## 15. Formulation produit

Formulation courte :

```text
OPUS — Framework MVC sécurisé piloté par bastion FSM.
```

Formulation complète :

```text
OPUS est un framework PHP MVC data-driven, piloté par un plan de contrôle FSM/ACL/SSO-like, conçu pour générer, sécuriser, administrer et auditer des sites et applications contrôlées.
```

Formulation développeur :

```text
OPUS rend la création de sites simple par configuration, mais rend impossible l'exécution d'une action sans décision explicite d'état, d'identité et d'autorisation.
```

## 16. Conclusion

L'ADN d'un site sécurisé par bastion FSM repose sur une idée simple : la sécurité n'est pas un filtre ajouté à la fin, elle est le plan de contrôle qui pilote l'exécution.

OPUS doit incarner cette idée en combinant :

```text
- MVC clair
- moteur data-driven
- FSM centrale
- ACL explicite
- identité SSO-like
- états bloqués fail-closed
- outils métier protégés
- rapports et observabilité
- dashboard administrateur
- génération de sites par configuration
```

Ce modèle donne à OPUS une identité forte : un framework simple à utiliser, strict à contourner, et adapté aux systèmes contrôlés comme KB et Maestro.
