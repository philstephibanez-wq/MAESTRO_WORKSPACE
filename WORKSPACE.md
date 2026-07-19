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

## Priorité immédiate obligatoire — restauration de la page Code source

Avant toute autre extraction, modularisation ou refactorisation du monolithe OWASYS, la page **Code source** doit être restaurée et validée.

Aucun autre chantier OWASYS ne doit commencer ou continuer tant que cette restauration n’est pas terminée et confirmée dans le navigateur.

La restauration doit rétablir au minimum :

- un état OWASYS `source` dédié ;
- une entrée **Code source** dans la navigation autorisée et dans la FSM ;
- l’arborescence des fichiers de l’application actuellement sélectionnée ;
- l’ouverture d’un fichier autorisé ;
- l’affichage de son contenu avec coloration syntaxique locale ;
- la prise en charge au minimum de PHP, JavaScript, JSON, CSS, HTML, SQL, Markdown et `.score` ;
- le confinement strict au répertoire de l’application sélectionnée ;
- l’exclusion des secrets, fichiers runtime sensibles, dépendances et répertoires non autorisés ;
- le respect de `www/index.php` comme unique point d’entrée public ;
- la conservation intégrale de toutes les autres fonctionnalités et de la présentation existante.

La première restauration est en lecture seule. Les fonctions d’édition, de preview, de validation, d’écriture atomique et d’inspection Git ne peuvent être réactivées qu’après validation séparée de la page en lecture seule.

Références historiques à utiliser pour restaurer le comportement perdu sans réinventer l’interface :

- `20f1545cbfe762b2c803e6f4535f1707469cfef4` — interface visuelle Code source ;
- `02a459ea6537e560374dc2d7c16f62bf2ee2ff71` — chargement de la page dans l’état `source` ;
- `d87a3f10230f2087ca30294472e1704e348293a7` — source CodeMirror 6 et coloration syntaxique ;
- `d502c5f9aabe50f7769035ef74e2e52ac0765c15` — chargement local du bundle CodeMirror ;
- `5ddebf4c0c6c521ff34fce839976743e773e8c79` — bundle local CodeMirror 6.

## Mandat exclusif de remédiation

Après validation complète de la page Code source, le seul travail autorisé est de remettre OWASYS progressivement en conformité avec des scripts modulaires correctement placés dans la structure OPUS.

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
- les données et contenus déjà visibles ;
- la présentation existante.

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

Cette première étape est volontairement additive : le module est présent et isolé, mais il n’est pas encore branché dans le traitement applicatif. Aucun comportement fonctionnel de la référence n’a donc été retiré ou remplacé.

Validations locales obtenues :

- lint du module : OK ;
- lint du smoke : OK ;
- smoke ciblé : `OWASYS_REQUEST_CONTEXT_MODULE_SMOKE_OK` ;
- dépôt local propre après synchronisation.

Cette étape reste gelée jusqu’à la restauration et à la validation de la page Code source.

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
