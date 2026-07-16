# MAESTRO_WORKSPACE — Handoff OWASYS / OPUS

**Date de consolidation :** 2026-07-16  
**Priorité de reprise :** P113B4 — OWASYS runtime UI, i18n et sélecteur de langues  
**Dépôt live concerné :** `H:\OPUS`  
**Workspace de gouvernance :** `H:\MAESTRO_WORKSPACE`

## 1. Règles impératives

1. Relire avant tout patch :
   `H:\MAESTRO_WORKSPACE\CONTEXT\CONTRACTS\MAESTRO_WORKSPACE_ULTIMATE_CONTRACT.md`
2. GitHub et le dépôt live réel sont les sources de vérité.
3. Aucun patch sans lecture des fichiers réels et état Git.
4. Zéro fallback silencieux.
5. Les commandes destinées à `cmd` ou au terminal VS Code ne contiennent que des commandes exécutables.
6. OPUS reprend la conception ASAP, avec ses évolutions :
   - `application`, pas un fourre-tout `src`;
   - une zone par contrôleur/fonction;
   - `application/default` pour les éléments communs hérités;
   - `www/asset` pour CSS et JavaScript;
   - la documentation de gouvernance appartient à `MAESTRO_WORKSPACE`.
7. OWASYS doit être protégé par authentification effective sur toutes les routes privées.
8. Les textes visibles doivent passer par i18n, sans chaînes critiques en dur.
9. La longueur des traductions doit être prise en compte pour un affichage professionnel.

## 2. Correction de trajectoire i18n

Le sélecteur de langue OWASYS ne doit **pas** être limité à français/anglais.

Il doit proposer :

- les 24 langues officielles de l’Union européenne ;
- l’ukrainien ;
- un rendu compact et professionnel même lorsque 20 à 25 langues sont disponibles ;
- un seul sélecteur, sans répétition du nom de langue ailleurs dans l’interface ;
- les noms de langues affichés dans leur forme native ;
- une langue active clairement identifiable ;
- un fallback explicite et diagnostiqué, jamais silencieux.

### Langues minimales attendues

`bg`, `hr`, `cs`, `da`, `nl`, `en`, `et`, `fi`, `fr`, `de`, `el`, `hu`, `ga`, `it`, `lv`, `lt`, `mt`, `pl`, `pt`, `ro`, `sk`, `sl`, `es`, `sv`, `uk`.

La présence d’une langue dans le sélecteur ne signifie pas qu’une traduction partielle est acceptable. Les locales incomplètes doivent être diagnostiquées.

## 3. État technique observé

### Serveur de développement valide

La commande de lancement utilisée est :

`php bin\opus serve:site owasys --host=127.0.0.1 --port=8090`

Le serveur a correctement servi :

- `/asset/css/owasys.css`
- `/asset/themes/owasys/css/theme.css`
- `/asset/js/owasys.js`
- `/asset/themes/owasys/js/theme.js`

### Blocage runtime actuel

La route `/applications` a produit :

`TypeError: Argument #1 ($value) must be of type string, null given`

Emplacements observés :

- helper défini dans `sites/owasys/www/index.php`, vers la ligne 82 ;
- appel fautif vers la ligne 744.

La correction prévue était de rendre le helper HTML nullable-safe, mais la première commande Python a échoué dans `cmd` et Python n’était pas disponible depuis ce terminal.

Un correctif PHP/base64 a ensuite été proposé, mais son application effective n’a pas été prouvée.

### Sélecteur de langue

Le sélecteur annoncé FR/EN n’est pas visible dans l’interface.

Il ne faut pas reprendre ce correctif tel quel : la cible fonctionnelle est désormais le sélecteur **UE + ukrainien**.

## 4. Fichiers à inspecter avant toute modification

- `sites/owasys/www/index.php`
- `sites/owasys/application/default/local/`
- `sites/owasys/www/asset/css/owasys.css`
- `sites/owasys/www/asset/js/owasys.js`
- `sites/owasys/www/asset/themes/owasys/`
- `tools/smoke_owasys_i18n.php`
- les smokes globaux OPUS
- le routeur généré sous `var/dev-server/` uniquement comme artefact runtime, pas comme source à modifier

## 5. Prochaine passe obligatoire

1. Lire le contrat ultime.
2. Vérifier `git status --short --branch` dans `H:\OPUS`.
3. Inspecter le contenu réel des fichiers listés ci-dessus.
4. Corriger le helper HTML nullable sans masquer l’origine des données nulles.
5. Construire un registre de locales unique et typé pour les 24 langues UE + ukrainien.
6. Rendre un unique sélecteur compact :
   - liste déroulante native ou composant accessible ;
   - recherche/filtrage si nécessaire ;
   - conservation correcte de la route et des paramètres utiles ;
   - pas de libellé redondant « Choose language ».
7. Brancher toutes les chaînes visibles sur i18n.
8. Ajouter des diagnostics de couverture et de longueur.
9. Ajouter ou renforcer les smokes :
   - registre des 25 langues ;
   - absence de sélecteur FR/EN codé en dur ;
   - absence de textes critiques codés en dur ;
   - locale active ;
   - fallback explicite ;
   - rendu `/applications` sans fatal ;
   - ressources CSS/JS accessibles ;
   - authentification réellement bloquante.
10. Exécuter les syntaxes, smokes ciblés et recette globale.
11. Ne committer/pousser qu’après résultats verts et état Git maîtrisé.

## 6. Points fonctionnels OWASYS déjà décidés

- OWASYS doit utiliser une FSM pour représenter les états de navigation et leurs transitions.
- La configuration des transitions doit avoir une source de vérité explicite ; SQLite OWASYS est envisagé pour le runtime, sans mélange avec les textes i18n.
- L’authentification doit demander un vrai utilisateur et mot de passe.
- Un mauvais identifiant doit interdire l’accès à toutes les routes privées.
- Le premier utilisateur n’est pas supposé français.
- OPUS Framework et OPUS Manager forment un AMS — Application Management System.
- L’arborescence applicative doit rester conforme à l’héritage ASAP et aux règles du workspace.

## 7. Critère de sortie P113B4

P113B4 n’est pas terminé tant que :

- `/applications` s’affiche sans fatal ;
- le sélecteur UE + ukrainien est visible et utilisable ;
- une seule occurrence du choix de langue est affichée ;
- aucun mélange français/anglais ne subsiste dans une locale ;
- la couverture i18n est diagnostiquée ;
- l’interface reste professionnelle avec des chaînes longues ;
- les routes privées sont réellement protégées ;
- tous les smokes et la recette globale passent ;
- le dépôt est propre ou ses écarts sont explicitement documentés.
