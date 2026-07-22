# MAESTRO WORKSPACE

## OPUS / applications — cadre impératif

OPUS est un framework. Chaque site sous `sites/<application>` est une application autonome du framework.

```text
application -> OPUS Framework
```

La direction inverse est interdite. Le framework ne contient aucune logique, aucun dépôt, aucun contrôleur, aucun template ni aucun namespace propre à une application déterminée.

Dépôts :

- code : `philstephibanez-wq/OPUS` ;
- gouvernance : `philstephibanez-wq/MAESTRO_WORKSPACE`.

## Source relue

État de `OPUS/master` relu le 2026-07-22 :

```text
24a6e7ff7abbce5e13559a0501ec000bc126871a
p117i
```

Le comportement observé dans le navigateur et les erreurs runtime priment sur toute déclaration de conformité.

## Arborescence applicative

```text
sites/<application>/
  application/
    default/
    <module>/
  config/
  var/
  www/
    index.php
```

Règles :

1. `sites/<application>/www/index.php` est l’unique point d’entrée public.
2. `OPUS/www` est interdit.
3. `application/default` est exclusivement la couche commune.
4. `application/default` n’est jamais une page home.
5. Les modules fonctionnels sont directement sous `application/<module>`.
6. `application/states` est interdit.
7. Les vues utilisent exclusivement les templates `.score`.
8. Les contrôleurs préparent des données de vue et ne construisent pas le HTML.
9. `www` ne contient que le front controller et les ressources publiques.

## Frontière OWASYS

Le chemin et namespace suivants sont interdits :

```text
Opus/Owasys/
Opus\Owasys\*
```

Toute logique propre à OWASYS doit rester sous :

```text
sites/owasys/application/
```

Implantation du Registry :

```text
sites/owasys/application/registry/repositories/RegistryRepository.php
sites/owasys/application/registry/models/RegistryModel.php
sites/owasys/application/registry/controllers/RegistryController.php
```

Le Registry conserve sa base runtime sous :

```text
sites/owasys/var/registry/owasys.sqlite
```

La suppression de `Opus/Owasys` est une correction architecturale. Le runtime ne doit jamais demander de restaurer ce répertoire.

## FSM, ACL et SSO

OWASYS est piloté par le pipeline suivant :

```text
requête/action
  -> résolution événement
  -> identité SSO
  -> décision ACL
  -> transition FSM
  -> actions FSM
  -> état/module cible
  -> ViewModel
  -> template SCORE
```

La FSM est la source de vérité pour les états, modules, routes, événements, transitions, gardes, actions et projection Mermaid. `site.json` ne contient pas de liste fonctionnelle de modules.

L’ACL est `deny-by-default`. Le masquage d’un élément d’interface ne remplace jamais le contrôle serveur.

Toute authentification passe par l’abstraction SSO OPUS. Le store local de développement reste non versionné sous `sites/owasys/var/auth/local-users.json`.

## Mermaid

Le schéma Mermaid est une projection de la FSM canonique filtrée par ACL.

Règles :

- seuls les états autorisés sont affichés ;
- seules les transitions `visual: true` sont projetées ;
- les flèches d’action doivent avoir une ligne et une pointe visibles ;
- chaque nœud autorisé doit être cliquable à la souris et activable par Entrée ou Espace ;
- l’état courant est mis en évidence ;
- aucun CDN ni copie applicative du bundle Mermaid ;
- le transport de la source Mermaid utilise `OPUS_MERMAID_SOURCE_JSON_V1` ;
- le bundle est servi par la whitelist framework.

Le responder d’assets framework est limité à :

```text
mermaid/opus-mermaid.js
codemirror/opus-codemirror.js
```

Il ne doit pas devenir un serveur générique de fichiers internes OPUS.

## ODBC — frontière canonique

OPUS expose une seule façade publique de base de données :

```text
Opus\Database\Odbc
Opus/Database/Odbc.php
```

Cette façade agrège les services techniques sans devenir une classe monolithique. Les implémentations spécialisées restent sous :

```text
Opus/Database/Odbc/
  connexion
  configuration de source
  métadonnées
  requêtes
  mutations préparées
  capacités
```

Règles :

1. toute base est accédée par ODBC ;
2. `Opus\Database\Odbc` est le point d’entrée documenté ;
3. `Opus\Database\Odbc\*` contient uniquement des briques techniques génériques ;
4. Model consomme ODBC par `Opus\Model\Adapter\OdbcModelAdapter` ;
5. LSTSAR consomme les modèles ODBC et ne devient pas une seconde abstraction de base ;
6. les mutations utilisent des commandes structurées, des paramètres préparés, ACL, confirmation et dry-run ;
7. le SQL brut provenant d’une interface n’est jamais accepté par la couche de mutation ;
8. UPDATE et DELETE exigent un prédicat non vide ;
9. la configuration d’une source peut être DSN ou DSN-less ;
10. les mots de passe ne sont jamais exposés par les méthodes de description.

Les chemins suivants sont obsolètes et doivent être supprimés après application du correctif de migration :

```text
Opus/OdbcExplorer/
packages/opus-odbc-manager/
```

Le terme `Manager` ou `Explorer` désigne un produit applicatif, jamais la façade framework.

La future interface d’administration appartient exclusivement à :

```text
sites/odbcexplorer/
  application/default/
  application/<module>/
  config/
  var/
  www/index.php
```

Elle devra être une application OPUS autonome pilotée par FSM, ACL et SSO, rendue par SCORE et utilisant l’i18n canonique. Elle consommera `Opus\Database\Odbc`, `Opus\Model` et `Opus\Lstsar`.

## i18n — contrat ASAP restauré

OWASYS expose les 24 langues officielles de l’Union européenne plus l’ukrainien :

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

L’i18n est un moteur et non un simple tableau de libellés.

Pipeline canonique :

```text
locale explicite
  -> catalogue global application/default/local/<locale>
  -> surcharge catalogue application/<module FSM>/local/<locale>
  -> sélection de la clé
  -> sélection du genre masculin/féminin/neutre
  -> sélection plurielle selon la locale et le nombre
  -> substitution stricte des paramètres
  -> échappement par SCORE
```

Règles :

1. aucune langue de repli implicite ;
2. aucune clé manquante remplacée par son propre nom ;
3. le catalogue global est obligatoire ;
4. le catalogue du module actif surcharge le global lorsqu’il existe ;
5. les catalogues PHP OPUS et les catalogues JSON ASAP `messages` + `plurals` sont acceptés ;
6. les formes grammaticales combinent genre et nombre ;
7. les formes slaves `one`, `few`, `many`, `other` sont sélectionnées par une règle de locale ;
8. les règles couvrent toutes les locales UE déclarées par OWASYS ainsi que l’ukrainien ;
9. une forme requise absente provoque une erreur explicite ;
10. un paramètre de substitution absent provoque une erreur explicite ;
11. les textes statiques des templates utilisent la directive SCORE native `[[ i18n: ... ]]` ;
12. SCORE ne charge pas lui-même les fichiers de catalogue : il consomme un `TranslationRuntimeInterface` configuré pour l’application, la locale et le module FSM actifs.

Syntaxes SCORE officielles :

```score
[[ i18n: auth.login ]]
[[ i18n: auth.welcome name=identity.label ]]
[[ i18n: registry.application_count count=sync.total ]]
[[ i18n: registry.selected count=selection.total gender=selection.gender ]]
```

Le résultat de la directive i18n est échappé par défaut. Aucun équivalent i18n brut n’est autorisé.

## Politique GitHub et ZIP

Aucune écriture directe dans `philstephibanez-wq/OPUS`.

Les correctifs OPUS/OWASYS sont livrés sous forme de ZIP local contenant uniquement les fichiers runtime à ajouter ou remplacer.

Le ZIP ne contient pas :

- de Markdown ;
- de manifeste à la racine ;
- de script d’application ou de rollback à la racine ;
- de smoke sous `sites/owasys` ;
- de handoff ou de spécification.

Les suppressions sont données séparément sous forme de commandes `cmd` exécutables.

## Jalon actif — P117J

Objectifs :

1. créer la façade publique `Opus\Database\Odbc` ;
2. conserver l’implémentation technique sous `Opus\Database\Odbc\*` ;
3. ajouter un registre strict de sources ODBC ;
4. exposer les opérations Model et la préparation LSTSAR depuis la façade ;
5. déplacer le CRUD générique vers une couche de mutations structurées ODBC ;
6. imposer paramètres préparés, ACL, confirmation, prédicat et dry-run ;
7. supprimer localement `Opus/OdbcExplorer` et le package historique s’il existe ;
8. ne pas créer encore une interface partielle sous `sites/odbcexplorer` ;
9. préserver OWASYS, sa FSM, son ACL, son SSO, son Registry, Mermaid et son i18n ;
10. ne pousser aucun code OPUS/OWASYS directement.

## Garanties de non-régression

Doivent rester fonctionnels :

- login SSO et changement de mot de passe avec contrôle de visibilité ;
- ACL serveur ;
- Registry et sélection d’application ;
- contexte applicatif courant ;
- FSM complète ;
- menu horizontal séparé du header ;
- schéma Mermaid dérivé de la FSM ;
- 25 locales avec drapeaux ;
- rendu SCORE et directive i18n ;
- fonctionnement Windows et système sensible à la casse.
