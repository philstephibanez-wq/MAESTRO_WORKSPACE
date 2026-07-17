# OPUS - Site Standard Contract

Contrat : OPUS_SITE_STANDARD_CONTRACT_CORE

## Portee

Ce contrat est obligatoire pour tous les sites OPUS presents et futurs.

Aucun site OPUS ne doit utiliser une structure specifique improvisee.

## Regle de racine site

Le nom du site est toujours le repertoire parent de `application`, `config` et `www`.

Structure interdite : `application/<site>/...`

Structure obligatoire : `sites/<site>/application/...`

## Structure canonique

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

## Regles structurelles

- Le nom du site est en amont de `application`.
- Le repertoire applicatif s'appelle `application`, pas `src`.
- Le repertoire web public s'appelle `www`, pas `public`.
- `www/index.php` est un point d'entree public minimal.
- `www/index.php` ne contient aucune logique metier, aucun menu, aucun layout, aucun rendu HTML applicatif, aucune logique FSM, aucune logique d'authentification, aucun acces registre et aucune composition I18N.
- `www/index.php` appelle uniquement le bootstrap applicatif OPUS situe sous `application/default`.
- `www` ne contient que le point d'entree public et les ressources publiquement exposables.
- Les assets publics vont dans `www/asset`.
- Les CSS vont dans `www/asset/css`.
- Les JavaScript publics vont dans `www/asset/js`.
- Les themes publics vont dans `www/asset/themes`.
- Les bundles navigateur vendor vont dans `www/asset/vendor`.
- Aucun fichier applicatif prive ne doit etre place sous `www`.

## Regles backend-first

- OPUS et tous ses sites sont backend-first.
- Le maximum de comportement doit etre implemente en PHP cote serveur.
- Le routage, la FSM, l'I18N, les menus, les permissions, les formulaires, les validations, les diffs, les operations Git autorisees, le build et l'export sont traites cote backend.
- Le HTML final est rendu cote serveur.
- La navigation est rendue directement a sa position finale par le backend.
- Les formulaires utilisent prioritairement `GET` ou `POST` avec redirection apres traitement.
- JavaScript est limite a l'amelioration progressive et ne doit jamais devenir la source de verite applicative.
- JavaScript ne doit pas construire, deplacer ou reconstituer le layout, le menu, l'application courante, les permissions ou les etats metier.
- Aucun composant fonctionnel obligatoire ne doit dependre d'une mutation DOM apres rendu.
- Sans JavaScript, le site doit rester navigable et exploitable.
- Les enrichissements autorises incluent notamment CodeMirror, Mermaid et les aides ergonomiques non bloquantes.
- Tout enrichissement JavaScript doit disposer d'un fallback backend/HTML fonctionnel, par exemple un `textarea` pour l'editeur.

## Regles application/default

- `application/default` contient les parties communes du site, sans devenir un fourre-tout.
- Le bootstrap commun appartient a `application/default/bootstrap.php`.
- Les layouts communs appartiennent a `application/default/layouts`.
- Les menus et definitions de navigation communes appartiennent a `application/default/navigation`.
- Les templates communs appartiennent a `application/default/templates`.
- Les vues communes appartiennent a `application/default/views`.
- Les catalogues I18N communs appartiennent a `application/default/local`.
- Les composants communs doivent rester clairement nommes, separes et documentes.

## Regles controllers et representations

- Chaque controller ou fonctionnalite possede son propre repertoire sous `application`.
- Chaque controller possede ses propres `acl`, `helpers`, `javascript`, `local`, `models`, `templates` et `views` si necessaire.
- Les templates et views appartiennent a OPUS, pas aux controllers en HTML concatene.
- Les menus sont declaratifs et utilisent des cles I18N, jamais des textes UI bruts.
- Le fallback I18N canonique est `[[cle.i18n]]`.
- Une cle brute comme `menu.source` affichee sans doubles crochets signifie que le moteur I18N a ete contourne et constitue une erreur bloquante.
- L'I18N utilise OPUS `local/i18n`, pas un service local improvise.
- L'auth, admin, mot de passe, ACL et RBAC utilisent OPUS.
- La navigation utilise OPUS FSM/CL.

## Interdictions explicites

- Pas de site pilote par JavaScript.
- Pas de menu construit ou deplace en JavaScript.
- Pas de layout reconstruit par manipulation DOM.
- Pas de logique applicative massive dans `www/index.php`.
- Pas de HTML metier concatene dans le front controller.
- Pas de configuration UI en texte brut hors I18N.
- Pas de fallback silencieux.
- Pas de smoke test qui valide une architecture contraire a ce contrat.

## Gate de conformite

Un site OPUS ne peut pas etre declare conforme, livre ou exportable tant que les points suivants ne sont pas vrais :

- `www/index.php` est minimal ;
- la logique applicative reside sous `application` ;
- la navigation et le layout sont rendus cote serveur ;
- JavaScript est uniquement progressif et non indispensable ;
- les textes UI passent par I18N ;
- les smokes valident la structure reelle et ne consacrent pas un bricolage ;
- la navigation fonctionne sans JavaScript ;
- les fallbacks fonctionnels existent pour les enrichissements JS.

## OPUS Manager AMS

OPUS Manager est une application OPUS de type AMS.

Il doit respecter exactement ce contrat comme n'importe quel autre site OPUS.

OPUS, encore OPUS, rien qu'OPUS.