# OPUS - Site Standard Contract

Contrat : OPUS_SITE_STANDARD_CONTRACT_CORE

## Portée

Ce contrat est obligatoire pour toutes les applications OPUS présentes et futures.

Aucune application OPUS ne doit utiliser une structure spécifique improvisée.

## Règle de racine site

Le nom du site est toujours le répertoire parent de `application`, `config` et `www`.

Structure interdite : `application/<site>/...`

Structure obligatoire : `sites/<site>/application/...`

## Structure canonique

```text
sites/<site>/
  application/
    default/
      bootstrap.php
      helpers/
      layouts/
      local/
      models/
      navigation/
      templates/
      views/

    <controller>/
      acl/
      helpers/
      javascript/
      local/
        <locale>/
      models/
      templates/
      views/

  config/

  www/
    index.php
    asset/
      css/
      js/
      themes/
        <theme>/
      vendor/
```

## Architecture applicative obligatoire

Toute application OPUS est :

- Singleton ;
- autonome sous `sites/<site>` ;
- pilotée par FSM, I18n, ACL deny-by-default et SSO ;
- compatible proxy Auth0 et bastion derrière les contrats génériques OPUS ;
- backend-first ;
- rendue exclusivement via SCORE ;
- sans `echo` produisant l'interface ;
- sans mélange HTML et PHP ;
- fonctionnelle sans JavaScript obligatoire ;
- instrumentée par Logger et Profiler ;
- localisée par défaut à partir de la langue du navigateur avec fallback explicite.

Lorsqu'un besoin n'est pas strictement métier à l'application, une évolution générique OPUS doit être proposée explicitement avant toute implémentation locale. La solution locale nécessite une décision owner.

## Règles structurelles

- Le nom du site est en amont de `application`.
- Le répertoire applicatif s'appelle `application`, pas `src`.
- Le répertoire web public s'appelle `www`, pas `public`.
- `www/index.php` est un point d'entrée public minimal.
- `www/index.php` ne contient aucune logique métier, aucun menu, aucun layout, aucun rendu HTML applicatif, aucune logique FSM, aucune logique d'authentification, aucun accès Registry et aucune composition I18n.
- `www/index.php` appelle uniquement le bootstrap applicatif OPUS situé sous `application/default`.
- `www` ne contient que le point d'entrée public et les ressources publiquement exposables.
- Les assets publics vont dans `www/asset`.
- Les CSS vont dans `www/asset/css`.
- Les JavaScript publics vont dans `www/asset/js`.
- Les thèmes publics vont dans `www/asset/themes`.
- Les bundles navigateur vendor vont dans `www/asset/vendor`.
- Aucun fichier applicatif privé ne doit être placé sous `www`.

## Règles backend-first

- OPUS et toutes ses applications sont backend-first.
- Le maximum de comportement est implémenté en PHP côté serveur.
- Le routage, la FSM, l'I18n, les menus, les permissions, les formulaires, les validations, les diffs, les opérations Git autorisées, le build et l'export sont traités côté backend.
- Le HTML final est rendu côté serveur par SCORE.
- La navigation est rendue directement à sa position finale par le backend.
- Les formulaires utilisent prioritairement `GET` ou `POST` avec redirection après traitement.
- JavaScript est limité à l'amélioration progressive et ne devient jamais la source de vérité applicative.
- JavaScript ne construit, ne déplace et ne reconstitue jamais le layout, le menu, l'application courante, les permissions ou les états métier.
- Aucun composant fonctionnel obligatoire ne dépend d'une mutation DOM après rendu.
- Sans JavaScript, le site reste navigable et exploitable.
- Les enrichissements autorisés incluent notamment CodeMirror, Mermaid et les aides ergonomiques non bloquantes.
- Tout enrichissement JavaScript dispose d'un fallback backend/HTML fonctionnel.

## Règles application/default

- `application/default` contient les parties communes du site, sans devenir un fourre-tout.
- Le bootstrap commun appartient à `application/default/bootstrap.php`.
- Les layouts communs appartiennent à `application/default/layouts`.
- Les menus et définitions de navigation communes appartiennent à `application/default/navigation`.
- Les templates communs appartiennent à `application/default/templates`.
- Les vues communes appartiennent à `application/default/views`.
- Les catalogues I18n communs appartiennent à `application/default/local`.
- Les composants communs restent clairement nommés, séparés et documentés.

## Règles controllers et représentations

- Chaque controller ou fonctionnalité possède son propre répertoire sous `application`.
- Chaque controller possède ses propres `acl`, `helpers`, `javascript`, `local`, `models`, `templates` et `views` si nécessaire.
- Les templates et views appartiennent à OPUS, pas aux controllers en HTML concaténé.
- Les menus sont déclaratifs et utilisent des clés I18n, jamais des textes UI bruts.
- Le fallback I18n canonique est `[[cle.i18n]]`.
- Une clé brute affichée sans doubles crochets signifie que le moteur I18n a été contourné et constitue une erreur bloquante.
- L'I18n utilise OPUS `local/i18n`, pas un service local improvisé.
- La langue initiale est négociée depuis `Accept-Language` parmi les locales supportées.
- L'authentification, l'administration, les mots de passe, ACL et RBAC utilisent OPUS.
- La navigation utilise OPUS FSM/CL.
- Toute représentation UI passe par SCORE.

## Configuration

Tous les fichiers de configuration sont lus via `Opus\File\File` ou son interface contractuelle.

Le parsing utilise les classes OPUS explicites :

```text
JSON -> Opus\File\Json
XML -> Opus\File\Xml
YAML/YML -> Opus\File\Yaml
```

`StructuredFileLoader` sélectionne le parser à partir du format déclaré ou de l'extension. Les lectures directes, parseurs ad hoc et fallbacks silencieux sont interdits.

## Frontière OWASYS

OWASYS est une application OPUS servant d'UI web et d'orchestration.

Toute commande métier ou mutation persistante OWASYS suit obligatoirement :

```text
SCORE UI
-> FSM + I18n + ACL + SSO
-> REST typé et sécurisé
-> FSM backend
-> commande Composer allow-listée
-> service/provider typé
-> résultat structuré
-> ViewModel
-> SCORE
```

Le frontend OWASYS n'écrit pas les fichiers, ne modifie pas directement le Registry, ne lance pas Composer/PHP/Git/shell et ne place aucune logique métier OWASYS sous `Opus/`.

## Logger et Profiler

Logger et Profiler sont obligatoires pour les opérations backend et les workflows frontend significatifs.

Chaque opération fournit une corrélation de trace entre le frontend, REST, la FSM backend, Composer et le rendu du résultat.

Aucun mot de passe, token, secret, clé HMAC, corps sensible, paramètre brut ou ligne de commande sensible n'entre dans Git, argv, logs, profiler, exceptions ou ZIP.

## Interdictions explicites

- Pas de site piloté par JavaScript.
- Pas de menu construit ou déplacé en JavaScript.
- Pas de layout reconstruit par manipulation DOM.
- Pas de logique applicative massive dans `www/index.php`.
- Pas de HTML métier concaténé dans le front controller.
- Pas d'`echo` produisant l'interface.
- Pas de mélange HTML/PHP dans une vue.
- Pas de configuration UI en texte brut hors I18n.
- Pas de fallback silencieux.
- Pas de parser de configuration local improvisé.
- Pas de mutation OWASYS contournant REST sécurisé puis Composer.
- Pas de smoke test validant une architecture contraire à ce contrat.

## Gate de conformité

Une application OPUS ne peut pas être déclarée conforme, livrée ou exportable tant que les points suivants ne sont pas vrais :

- `www/index.php` est minimal ;
- l'architecture Singleton est effective ;
- la logique applicative réside sous `application` ;
- la FSM est la source de vérité du cycle de vie ;
- ACL et SSO sont appliqués deny-by-default ;
- la locale initiale vient du navigateur avec fallback explicite ;
- la navigation et le layout sont rendus côté serveur via SCORE ;
- aucun `echo` UI ni mélange HTML/PHP n'existe ;
- JavaScript est uniquement progressif et non indispensable ;
- les textes UI passent par I18n ;
- la configuration passe par File et le parser structuré OPUS explicite ;
- Logger et Profiler fournissent une corrélation sans secret ;
- les besoins génériques sont proposés au framework avant duplication locale ;
- pour OWASYS, toute mutation traverse REST sécurisé puis Composer ;
- les smokes valident la structure réelle et ne consacrent pas un bricolage ;
- la navigation fonctionne sans JavaScript ;
- les fallbacks fonctionnels existent pour les enrichissements JS.

## OPUS Manager AMS

OPUS Manager est une application OPUS de type AMS.

Il respecte exactement ce contrat comme n'importe quelle autre application OPUS.

OPUS, encore OPUS, rien qu'OPUS.
