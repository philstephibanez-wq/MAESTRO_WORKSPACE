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

État de `OPUS/master` relu le 2026-07-21 :

```text
e43955ff2a3db1056fdf2d6887432d11bae50bf1
p117f
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

## ODBCExplorer

La séparation cible est :

```text
Opus/OdbcExplorer/ ou Opus/Database/Odbc/
  moteur générique réutilisable

sites/odbcexplorer/
  application autonome OPUS
  FSM + ACL + SSO
  contrôleurs
  templates .score
  assets publics
```

Le moteur générique peut rester dans le framework s’il ne contient aucune route, page, template, libellé, menu ou logique d’une application particulière.

L’interface ODBCExplorer ne doit pas vivre sous `Opus/`, ni être pilotée comme une application depuis `packages/opus-odbc-manager`. Le package historique est une source à auditer et à migrer, pas la cible runtime.

## i18n

OWASYS expose les 24 langues officielles de l’Union européenne plus l’ukrainien :

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

Toutes les chaînes visibles ou accessibles passent par les catalogues i18n.

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

## Jalon actif — P117H

Objectifs :

1. supprimer toute dépendance runtime `Opus\Owasys` ;
2. relocaliser le Registry dans le module applicatif `registry` ;
3. préserver la base SQLite runtime existante ;
4. reconnaître les contrats de site actuels lors de la découverte ;
5. finaliser les flèches Mermaid et la navigabilité souris/clavier ;
6. ne modifier ni la FSM fonctionnelle, ni ACL, ni SSO ;
7. cadrer ODBCExplorer sans déplacer son moteur générique dans une application ;
8. ne jamais recréer `Opus/Owasys`.

## Garanties de non-régression

Doivent rester fonctionnels :

- login SSO et changement de mot de passe ;
- ACL serveur ;
- Registry et sélection d’application ;
- contexte applicatif courant ;
- FSM complète ;
- menu horizontal séparé du header ;
- schéma Mermaid dérivé de la FSM ;
- 25 locales avec drapeaux ;
- rendu SCORE ;
- fonctionnement Windows et système sensible à la casse.
