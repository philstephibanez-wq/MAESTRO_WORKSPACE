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

Rien d’autre n’est dans le périmètre.

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
- les données et contenus déjà visibles.

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
- toute affirmation de conformité sans validation ciblée et confirmation navigateur.

## État de la remédiation incrémentale

### Étape 1 — contexte HTTP partagé préparé

Ajouts sur la branche OWASYS :

- `sites/owasys/application/default/http/request-context.php` ;
- `tools/smoke_owasys_request_context_module.php`.

Responsabilité couverte : normalisation de la méthode, du chemin, du point de montage `/owasys`, des liens et des assets.

Cette première étape est volontairement additive : le module est présent et isolé, mais `www/index.php` n’est pas encore modifié. Aucun comportement fonctionnel de la référence n’a donc été retiré ou remplacé.

Avant branchement dans `www/index.php`, les validations locales obligatoires sont :

- lint du module ;
- lint du smoke ;
- exécution du smoke ciblé ;
- confirmation navigateur que la version fonctionnelle reste intacte.

## Règle de décision

En cas de doute, le comportement du commit de référence prévaut.

La modularisation doit reproduire le comportement existant avant de le remplacer. Elle ne doit jamais servir de prétexte à le simplifier, le réduire ou le supprimer.

Rien d’autre ne doit être modifié.
