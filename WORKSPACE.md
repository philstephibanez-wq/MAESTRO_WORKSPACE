# MAESTRO WORKSPACE

## OPUS / OWASYS — référence fonctionnelle obligatoire

OPUS est un framework. OWASYS est une application du framework OPUS.

La version fonctionnelle validée d’OWASYS est le commit OPUS suivant :

`2361908b674f0dcce17023a4fc90e17dc6f72ede`

La branche de travail concernée est :

`owasys-backend-first-remediation`

Toute évolution future d’OWASYS repart de cet état exact.

Cette référence contient notamment :

- toutes les pages fonctionnelles existantes ;
- le registre d’applications complet ;
- `demo-app` visible et sélectionnable ;
- la sélection et le changement d’application ;
- le contexte d’application courant ;
- les menus complets autorisés ;
- la FSM complète, visible, navigable et cliquable ;
- les routes, actions, données et contenus fonctionnels existants.

## Mandat exclusif de remédiation

À partir de cette référence, le seul travail autorisé est de remettre OWASYS progressivement en conformité avec des scripts modulaires correctement placés dans la structure OPUS.

Rien d’autre n’est dans le périmètre, à l’exception de la restauration explicitement demandée de la page de consultation du code source avec coloration syntaxique.

## Invariant absolu de comportement et de présentation

La refactorisation ne doit modifier aucune fonctionnalité existante et aucune présentation existante.

À chaque étape, le HTML visible, la navigation, les libellés, les formulaires, les routes, les redirections, les actions, les styles, la FSM et les données affichées doivent rester équivalents à la version validée.

Toute divergence visible ou fonctionnelle bloque l’étape et impose le retour à l’état précédent.

La restauration de la page de code source est un ajout fonctionnel explicitement autorisé. Elle ne doit entraîner aucune modification de la présentation des pages existantes.

## Structure cible

Chaque responsabilité doit être déplacée vers son emplacement canonique :

- actions d’état : `sites/owasys/application/states/<state>/actions` ;
- ViewModels d’état : `sites/owasys/application/states/<state>/views` ;
- templates d’état : `sites/owasys/application/states/<state>/templates` ;
- services propres à un état : sous `sites/owasys/application/states/<state>` ;
- code réellement partagé : `sites/owasys/application/default` ;
- assets publics : `sites/owasys/www/asset` ;
- point d’entrée public unique : `sites/owasys/www/index.php`.

Le monolithe fonctionnel reste la référence comportementale tant que chaque responsabilité n’a pas été remplacée et validée individuellement.

## Inventaire de décomposition du monolithe

Le monolithe actuel contient 19 responsabilités distinctes :

1. contexte HTTP : méthode, chemin, montage, liens et assets ;
2. chargement et validation de `site.json` et `routes.json` ;
3. chargement et validation de la configuration FSM ;
4. initialisation et gestion de session ;
5. stockage local des utilisateurs ;
6. authentification par mot de passe ;
7. déconnexion ;
8. changement obligatoire de mot de passe ;
9. résolution de route ;
10. chargement du ViewModel de l’état ;
11. indexation et contexte courant de la FSM ;
12. gestion de l’application courante ;
13. actions Registry : sélectionner, désélectionner et créer ;
14. garde `requires_current_app` ;
15. construction du menu ;
16. génération de la navigation Mermaid ;
17. rendu partagé : shell, navigation, topbar et contexte d’application ;
18. rendu des états particuliers : login, compte et Registry ;
19. rendu générique des cartes, sections, contrats, actions et document HTML final.

La responsabilité 1 dispose déjà d’un module préparé mais non branché. Il reste donc 18 migrations comportementales à réaliser avant suppression complète du script monolithique.

Chaque responsabilité doit être migrée séparément. Cette liste ne constitue pas une autorisation de créer 19 nouveaux monolithes.

## Restauration obligatoire de la page Code source

OWASYS doit retrouver une page dédiée à la consultation du code source de l’application courante.

Exigences minimales :

- page accessible depuis la navigation OWASYS autorisée ;
- consultation de l’arborescence des fichiers de l’application sélectionnée ;
- ouverture d’un fichier source dans un lecteur dédié ;
- coloration syntaxique adaptée au type de fichier ;
- affichage fidèle du contenu sans exécution ni transformation destructive ;
- protection stricte contre la sortie du répertoire de l’application courante ;
- aucun accès aux secrets, fichiers runtime sensibles ou chemins non autorisés ;
- fonctionnement sans altérer les pages ou la présentation existantes ;
- placement modulaire sous un état OWASYS dédié, avec actions, ViewModel, template et assets correctement séparés ;
- validation ciblée et contrôle navigateur avant activation.

Cette page doit d’abord être restaurée en lecture seule. Toute fonction d’édition sera traitée ultérieurement, séparément et uniquement après validation explicite.

## Méthode obligatoire

Chaque étape doit porter sur une seule responsabilité et rester petite, réversible et conservatrice :

1. inventorier précisément le comportement existant dans la référence ;
2. créer le nouveau module dans le bon répertoire ;
3. brancher uniquement cette responsabilité sur le nouveau module ;
4. conserver toutes les autres responsabilités inchangées ;
5. valider la syntaxe ;
6. exécuter un smoke ciblé ;
7. vérifier le rendu et le comportement dans le navigateur ;
8. supprimer l’ancien fragment monolithique uniquement après équivalence démontrée ;
9. mettre à jour ce WORKSPACE MAESTRO dans le même changement.

## Garanties de non-régression

À chaque étape, doivent rester présents et fonctionnels :

- toutes les pages ;
- `demo-app` dans la liste ;
- la sélection et le changement d’application ;
- le contexte d’application courant ;
- le menu complet autorisé ;
- la FSM complète, visible et cliquable ;
- les routes ;
- les actions déjà disponibles ;
- les données et contenus déjà visibles ;
- la présentation existante, sans changement visuel non demandé.

Un smoke vert ne suffit pas si le navigateur montre une régression.

## Interdictions

Sont interdits :

- tout refactor sans rapport direct avec la responsabilité en cours ;
- tout redesign visuel ;
- toute suppression fonctionnelle ;
- toute suppression avant remplacement validé ;
- toute réécriture complète d’une classe partagée pour une modification locale ;
- tout nettoyage global mélangé à une migration ;
- toute modification simultanée de plusieurs états ;
- toute modification du Registry, de la FSM, de l’authentification ou de la navigation sans nécessité directe et validation dédiée ;
- toute restauration d’un runtime parallèle ;
- toute affirmation de conformité sans validation ciblée et confirmation navigateur ;
- toute fonction d’édition du code source introduite en même temps que sa restauration en lecture seule.

## État de la remédiation incrémentale

### Étape 1 — contexte HTTP partagé préparé

Ajouts sur la branche OWASYS :

- `sites/owasys/application/default/http/request-context.php` ;
- `tools/smoke_owasys_request_context_module.php`.

Responsabilité couverte : normalisation de la méthode, du chemin, du point de montage `/owasys`, des liens et des assets.

Cette première étape est volontairement additive : le module est présent et isolé, mais il n’est pas encore branché dans le traitement applicatif. Aucun comportement fonctionnel de la référence n’a donc été retiré ou remplacé.

Validations locales obtenues :

- lint du module : OK ;
- lint du smoke : OK ;
- smoke ciblé : `OWASYS_REQUEST_CONTEXT_MODULE_SMOKE_OK` ;
- dépôt local propre après synchronisation.

### Point d’entrée public et lancement local

`sites/owasys/www/index.php` est l’unique point d’entrée public et le seul front controller.

Aucun `dev-router.php` séparé n’est autorisé.

Sous le serveur PHP intégré, `index.php` laisse le serveur servir directement les assets publics existants non-PHP, puis transmet les autres requêtes à l’implémentation applicative conservée dans `sites/owasys/www/application.php`.

Commande locale canonique :

`php -S 127.0.0.1:18080 -t sites/owasys/www sites/owasys/www/index.php`

## Règle de décision

En cas de doute, le comportement du commit de référence prévaut.

La modularisation doit reproduire le comportement existant avant de le remplacer. Elle ne doit jamais servir de prétexte à le simplifier, le réduire ou le supprimer.

Rien d’autre ne doit être modifié.
