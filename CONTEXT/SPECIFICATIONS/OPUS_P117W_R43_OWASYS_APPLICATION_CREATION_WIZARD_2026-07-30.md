# OPUS P117W R43 — assistant OWASYS de création d’application

Date : 2026-07-30  
Base OPUS owner : `98842dba015402af7e8b3421e62032236c2d8f30`  
Statut : spécification active avant correctif différentiel.

## État canonique

- R42 est appliqué au commit `bbac194fac44e22a6f33be39c497d20c7ca93421`.
- `sites/opus-demo` a été supprimé par l’owner au commit `98842dba015402af7e8b3421e62032236c2d8f30`.
- Aucun site généré ne doit être conservé comme base avant validation de R43.
- OWASYS reste composé de `owasys-front` et `owasys-back`, deux applications OPUS autonomes.

## Cause

L’action OWASYS `new` n’est pas un assistant de création :

- le formulaire SCORE ne collecte que `site_id` et `profile` ;
- `OwasysApplicationCreationModel` transmet uniquement ces deux champs ;
- la ressource REST `POST /api/v1/applications` appelle directement `site.create` ;
- `SiteScaffoldPlan` préfabrique selon le profil 7 ou 8 modules techniques et leurs pages ;
- aucun choix d’authentification, page de connexion, fournisseur SSO, rôles, utilisateurs initiaux, permissions ou ACL n’est recueilli ;
- aucune étape de récapitulatif et de confirmation n’existe.

Le résultat de `new` est donc un démonstrateur OPUS surchargé, pas une application neuve minimale.

## Résultat minimal de `new`

Une création réussie produit exactement :

- une application autonome plate sous `sites/<application-id>` ;
- un Singleton applicatif ;
- une page d’accueil unique ;
- une route d’accueil unique ;
- un état FSM initial unique correspondant à l’accueil ;
- une page de connexion uniquement lorsqu’elle a été explicitement demandée ;
- aucune autre page, rubrique, entrée de navigation ou transition métier ;
- SCORE uniquement, sans `echo` UI et sans mélange HTML/PHP ;
- ACL deny-by-default et SSO configurés selon les réponses ;
- Logger et Profiler corrélés ;
- locale initiale négociée depuis `Accept-Language`, fallback français explicite ;
- catalogues I18n pour les 24 langues officielles de l’Union européenne plus l’ukrainien ;
- un sélecteur offrant toutes ces langues, sans dupliquer la page.

## Étapes obligatoires de l’assistant

L’assistant OWASYS est piloté par FSM et fonctionne sans JavaScript obligatoire.

1. **Identité de l’application**
   - identifiant ;
   - nom affiché ;
   - profil `frontend`, `backend` ou `fullstack`.

2. **Accès**
   - site public ou authentification requise ;
   - page de connexion : oui/non ;
   - fournisseur : session locale de développement, Auth0-proxy, bastion/proxy ou fournisseur OPUS déclaré ;
   - comportement après connexion et déconnexion.

3. **Rôles et permissions**
   - rôle anonyme éventuel ;
   - rôle authentifié par défaut ;
   - rôles initiaux et hiérarchie ;
   - permissions `resource:action` ;
   - ACL de l’accueil et, si créée, de la page de connexion.

4. **Utilisateurs initiaux**
   - création facultative d’identités initiales ;
   - association aux rôles ;
   - aucun mot de passe, token ou secret dans Git, argv, logs, profiler, exception ou ZIP ;
   - les secrets locaux de développement utilisent exclusivement le store runtime OPUS/SSO prévu.

5. **Langues**
   - les 24 langues officielles de l’UE plus l’ukrainien sont obligatoirement initialisées ;
   - langue initiale depuis le navigateur ;
   - fallback français explicite ;
   - traductions d’accueil et de connexion présentes dans chaque catalogue.

6. **Récapitulatif**
   - affichage SCORE de tous les choix non sensibles ;
   - diagnostics des incompatibilités avant mutation ;
   - confirmation explicite ou retour à une étape précédente.

7. **Création transactionnelle**
   - une seule commande métier après confirmation ;
   - validation complète avant écriture ;
   - écriture atomique du plan ;
   - validation OPUS puis synchronisation Registry ;
   - sélection de l’application créée ;
   - en cas d’échec, suppression contrôlée de tout artefact partiel créé par la transaction.

## FSM du workflow

États minimaux :

```text
creation_identity
creation_access
creation_roles
creation_users
creation_languages
creation_review
creation_submitting
creation_succeeded
creation_failed
creation_cancelled
```

Chaque POST devient un événement FSM. Le serveur conserve un brouillon de session non sensible et vérifie les transitions. Le navigateur ne peut ni sauter une garde ni fournir une commande, un chemin, un CWD ou une option Composer libre.

## Flux d’autorité

```text
owasys-front SCORE
-> FSM + I18n + ACL + SSO
-> requête REST typée
-> owasys-back authentifié et autorisé
-> FSM backend
-> commande Composer allow-listée
-> plan de scaffold validé
-> écriture atomique
-> validation OPUS
-> registry.sync
-> réponse structurée
-> ViewModel
-> SCORE
```

`owasys-front` n’écrit aucun fichier. `owasys-back` reste exclusivement PHP et ne contient aucun JavaScript, TypeScript, Node.js ni gestionnaire de paquets JavaScript.

## Contrat de requête

La mutation finale transporte un blueprint typé, borné et non sensible. Elle ne transporte jamais de mot de passe ou secret. Le backend refuse :

- champ inconnu ;
- rôle, permission, locale ou fournisseur non allow-listé ;
- incohérence entre site public, login et ACL ;
- login demandé sans fournisseur compatible ;
- rôle référencé mais non déclaré ;
- page, route ou état supplémentaire non autorisé par `new`.

## Ajouts ultérieurs

Après `new`, toute page est ajoutée par un workflow distinct et atomique corrélant :

```text
page -> route -> état/transitions FSM -> contrôleur/ViewModel
-> SCORE -> navigation -> ACL -> I18n
```

Aucune opération d’ajout ne doit laisser une corrélation partielle.

## Portée du futur ZIP

Le correctif R43 devra contenir uniquement les fichiers complets nécessaires dans :

- `sites/owasys-front` pour la FSM, le contrôleur, le modèle, SCORE, CSS et I18n ;
- `sites/owasys-back` pour les contrats REST/allow-list et l’orchestration PHP ;
- OPUS uniquement si un contrat générique de blueprint/scaffold atomique est indispensable, sans solution locale dupliquée.

Avant le ZIP, chaque fichier réel doit être relu au HEAD owner. L’assistant ne committe ni ne pousse OPUS/OWASYS.

## Acceptation

- création accessible depuis `/<locale>/applications/new` ;
- parcours complet piloté par FSM ;
- fonctionnement sans JavaScript ;
- récapitulatif avant mutation ;
- site neuf avec accueil seulement, plus login uniquement si demandé ;
- aucune page technique préfabriquée ;
- UE + ukrainien dans les catalogues et le sélecteur ;
- ACL/SSO/rôles conformes aux choix ;
- aucun secret versionné ou journalisé ;
- corrélation unique front/REST/back/Composer/Registry ;
- rollback sans scorie sur échec ;
- validation OPUS et Registry réussies ;
- backend OWASYS exclusivement PHP.

TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO PARTIAL SITE.  
NO SECRET IN DELIVERY.
