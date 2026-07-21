# MAESTRO WORKSPACE

## OPUS / OWASYS — cadre

OPUS est un framework. OWASYS est une application du framework OPUS.

Dépôts concernés :

- framework et application : `philstephibanez-wq/OPUS` ;
- pilotage du travail : `philstephibanez-wq/MAESTRO_WORKSPACE`.

## Nouvelle référence fonctionnelle obligatoire

La nouvelle version fonctionnelle et visuelle de référence d’OWASYS est le commit OPUS suivant :

`371c3757e8e80a62a198bc44a9f1b03d42a0ddec`

Branche correspondante :

`owasys-backend-first-remediation`

Toute évolution future d’OWASYS doit préserver exactement le comportement et la présentation validés à ce commit.

Cette référence comprend notamment :

- toutes les pages fonctionnelles existantes ;
- le registre d’applications, dont `demo-app` ;
- la sélection et le changement d’application ;
- le contexte d’application courant ;
- la FSM complète, visible, navigable et cliquable ;
- la page **Code source** en lecture seule ;
- l’arborescence des sources repliée par défaut ;
- la coloration syntaxique CodeMirror locale ;
- les 25 locales : 24 langues officielles de l’Union européenne plus l’ukrainien ;
- le sélecteur de langue avec drapeaux ;
- le header distinct de la barre de navigation horizontale ;
- le menu horizontal complet ;
- `sites/owasys/www/index.php` comme point d’entrée public unique.

## Interdiction absolue de modification directe du dépôt GitHub OPUS

À compter de cette référence, ChatGPT ne doit plus effectuer aucune écriture directe dans le dépôt GitHub :

`philstephibanez-wq/OPUS`

Cette interdiction couvre notamment :

- création, modification ou suppression de fichier ;
- création de commit ;
- déplacement de branche ou de référence ;
- création de branche ou de pull request ;
- toute autre mutation distante du dépôt OPUS.

L’accès en lecture au dépôt OPUS reste autorisé pour analyser l’existant, préparer un patch, vérifier une référence ou établir un diagnostic.

Les modifications OPUS doivent désormais être fournies sous forme de patch ou de commandes locales contrôlées, puis appliquées et validées par l’utilisateur dans son dépôt local. Aucun push vers GitHub OPUS ne doit être effectué par ChatGPT.

Cette interdiction vise uniquement le dépôt GitHub OPUS. Le dépôt `MAESTRO_WORKSPACE` peut être mis à jour directement lorsque l’utilisateur le demande.

## Mandat exclusif de remédiation

Le seul travail autorisé sur OWASYS est la décomposition incrémentale du monolithe fonctionnel en modules correctement placés, sans aucune modification de fonctionnalité ni de présentation.

Le monolithe fonctionnel reste la référence comportementale tant que chaque responsabilité n’a pas été remplacée et validée individuellement.

## Responsabilités à refactorer

Le monolithe OWASYS contient 19 responsabilités principales.

La responsabilité **contexte HTTP partagé** dispose déjà d’un module préparé mais non branché. Il reste donc 18 migrations effectives à réaliser.

1. Contexte HTTP : méthode, chemin, montage `/owasys`, liens et assets — module préparé, non branché.
2. Chargement et validation de `site.json` et `routes.json`.
3. Chargement et validation de la configuration FSM.
4. Initialisation et gestion de session.
5. Stockage runtime local des utilisateurs.
6. Authentification par mot de passe.
7. Déconnexion.
8. Changement obligatoire de mot de passe.
9. Résolution des routes.
10. Chargement du ViewModel de l’état.
11. Indexation de la FSM et gestion du contexte d’état courant.
12. Gestion de l’application courante.
13. Actions Registry : sélectionner, désélectionner et créer une application.
14. Garde `requires_current_app`.
15. Construction du menu et de la navigation horizontale.
16. Génération de la navigation Mermaid.
17. Rendu partagé : header, authentification, langue, contexte applicatif et shell.
18. Rendu des états particuliers : login, compte et Registry.
19. Rendu générique : cartes, sections, contrats, actions et document HTML final.

La page **Code source**, son explorateur, son action de lecture confinée et ses assets constituent désormais une fonctionnalité restaurée à préserver. Ils ne doivent pas être supprimés, simplifiés ou redesignés pendant la décomposition du monolithe.

## Structure cible

Chaque responsabilité doit être déplacée vers son emplacement canonique :

- actions d’état : `sites/owasys/application/states/<state>/actions` ;
- ViewModels d’état : `sites/owasys/application/states/<state>/views` ;
- templates d’état : `sites/owasys/application/states/<state>/templates` ;
- services propres à un état : sous `sites/owasys/application/states/<state>` ;
- code réellement partagé : `sites/owasys/application/default` ;
- assets publics : `sites/owasys/www/asset` ;
- point d’entrée public unique : `sites/owasys/www/index.php`.

## Méthode obligatoire

Chaque étape porte sur une seule responsabilité et doit rester petite, réversible et conservatrice :

1. inventorier précisément le comportement existant dans la référence ;
2. préparer le module dans le bon répertoire ;
3. fournir un patch local, sans écrire directement dans GitHub OPUS ;
4. appliquer localement uniquement cette responsabilité ;
5. conserver toutes les autres responsabilités inchangées ;
6. valider la syntaxe ;
7. exécuter un smoke ciblé ;
8. vérifier le rendu et le comportement dans le navigateur ;
9. supprimer l’ancien fragment uniquement après équivalence démontrée ;
10. mettre à jour ce WORKSPACE MAESTRO après validation.

## Garanties de non-régression

À chaque étape doivent rester présents, fonctionnels et visuellement identiques à la référence :

- toutes les pages ;
- `demo-app` dans le Registry ;
- la sélection et le changement d’application ;
- le contexte d’application courant ;
- le header séparé du menu horizontal ;
- le menu horizontal complet ;
- le sélecteur des 25 langues avec drapeaux ;
- les catalogues i18n ;
- la page Code source, son arbre replié par défaut et sa coloration CodeMirror ;
- la FSM complète, visible et cliquable ;
- les routes et actions ;
- les données et contenus visibles ;
- la présentation existante.

Un smoke vert ne suffit pas si le navigateur montre une régression.

## Interdictions fonctionnelles et architecturales

Sont interdits :

- toute écriture directe dans GitHub OPUS par ChatGPT ;
- tout refactor sans rapport direct avec la responsabilité en cours ;
- tout redesign visuel ;
- toute suppression fonctionnelle ;
- toute suppression avant remplacement validé ;
- toute réécriture globale pour une modification locale ;
- tout nettoyage général mélangé à une migration ;
- toute modification simultanée de plusieurs responsabilités ;
- toute modification du Registry, de la FSM, de l’authentification, de l’i18n ou de la navigation sans nécessité directe et validation dédiée ;
- toute restauration d’un runtime parallèle ;
- tout routeur public séparé de `www/index.php` ;
- toute affirmation de conformité sans validation ciblée et confirmation navigateur.

## État de la remédiation

### Contexte HTTP partagé préparé

Fichiers existants :

- `sites/owasys/application/default/http/request-context.php` ;
- `tools/smoke_owasys_request_context_module.php`.

Responsabilité couverte : normalisation de la méthode, du chemin, du point de montage `/owasys`, des liens et des assets.

Le module est additif et n’est pas encore branché dans le traitement applicatif.

Validation locale déjà obtenue :

- lint du module : OK ;
- lint du smoke : OK ;
- smoke ciblé : `OWASYS_REQUEST_CONTEXT_MODULE_SMOKE_OK`.

### Point d’entrée public et lancement local

`sites/owasys/www/index.php` est l’unique point d’entrée public et le seul front controller.

Aucun `dev-router.php` séparé n’est autorisé.

Commande locale canonique :

`php -S 127.0.0.1:18080 -t sites/owasys/www sites/owasys/www/index.php`

## Règle de décision

En cas de doute, le comportement et la présentation du commit `371c3757e8e80a62a198bc44a9f1b03d42a0ddec` prévalent.

La modularisation doit reproduire l’existant avant de le remplacer. Elle ne doit jamais servir de prétexte à le simplifier, le réduire, le déplacer visuellement ou le supprimer.
