# P112A — ASAP + KB_FRONT + BACKOFFICE — PLAN D’ARCHITECTURE

Statut: PLAN CONTRACTUEL — AUCUN PATCH CODE
Portée: ASAP, KB_FRONT, Front musicien, Backoffice, futurs sites intranet/extranet/internet
Date: 2026-06-05

---

## 0. Contrat appliqué

Ce plan applique le contrat MAESTRO_WORKSPACE :

```text
Chaque couche métier est souveraine et précise.
La data, le traitement et la représentation sont séparés.
Les objets et contrats sont explicites.
Il n’existe aucun fallback silencieux.
Tout passe ou casse clairement.
Le workspace reste propre après chaque action.
```

Aucune migration ne doit être lancée tant que ce plan n’est pas validé.

---

## 1. Problème actuel

L’état actuel du front n’est pas satisfaisant.

Il mélange :

```text
1. un front PHP/Twig maison à la racine de MO_KB_FRONT
2. un vrai ASAP imbriqué dans MO_KB_FRONT_ASAP
```

Ce n’est pas la cible.

L’erreur architecturale est :

```text
ASAP intégré dans un front Twig
```

alors que la cible est :

```text
Twig intégré dans ASAP via Composer
```

---

## 2. Objectif P112

P112 doit rétablir une architecture propre :

```text
ASAP.git
= framework PHP Composer mutualisable

KB_FRONT.git
= application ASAP pour MO_KB, front + backoffice

Twig
= dépendance Composer d’ASAP, exposée via un adapter ASAP

Front musicien
= site/config dans KB_FRONT

Backoffice
= site/config dans KB_FRONT
```

Chaîne de dépendance cible :

```text
KB_FRONT
  -> logandplay/asap
      -> twig/twig
```

Interdit :

```text
KB_FRONT
  -> Twig front maison
      -> ASAP imbriqué
```

---

## 3. Règles fondamentales

### 3.1 Séparation des métiers

```text
ASAP
= framework, orchestration, routing, site resolver, dispatcher, template adapters

KB_FRONT
= application métier MO_KB, sites, modules, data, thèmes, représentations

Front musicien
= site configuré dans KB_FRONT

Backoffice
= site configuré dans KB_FRONT

Twig
= renderer HTML, jamais moteur souverain
```

### 3.2 Séparation data / traitement / représentation

```text
DATA
= faits, contenus, configs, états, routes, droits, DTO, ViewModels

TRAITEMENT
= services, engines, resolvers, validators, registries

REPRÉSENTATION
= HTML/Twig, JSON, Markdown, API response, widget, export

THÈME
= CSS, JS décoratif, assets, habillage
```

Une représentation consomme une data déjà validée.
Elle ne décide pas, ne corrige pas, ne fallback pas.

### 3.3 Zéro fallback silencieux

```text
site inconnu        -> SITE_NOT_RESOLVED
route inconnue      -> ROUTE_NOT_FOUND
module désactivé    -> MODULE_DISABLED
controller absent   -> CONTROLLER_NOT_FOUND
action interdite    -> ACTION_NOT_ALLOWED
template absent     -> TEMPLATE_NOT_FOUND
data invalide       -> VIEWMODEL_INVALID
config invalide     -> CONFIG_CONTRACT_FAILED
```

Un comportement par défaut est autorisé uniquement s’il est déclaré dans une configuration explicite.

---

## 4. Dépôt ASAP cible

Chemin recommandé :

```text
H:\UwAmp\www\_packages\ASAP
```

Nom Git recommandé :

```text
ASAP
```

ou :

```text
ASAP_Framework
```

Arborescence cible :

```text
ASAP
  .git
  composer.json
  README.md
  CHANGELOG.md
  LICENSE

  framework
    ASAP
      Application.class.php
      Router.class.php
      Configuration.class.php
      ConfigLoader.class.php

      SITE
        Site.class.php
        SiteResolver.class.php
        SiteRegistry.class.php

      ROUTING
        Route.class.php
        RouteCollection.class.php
        RouteMatch.class.php
        RouteResolver.class.php

      MODULE
        ModuleDefinition.class.php
        ModuleRegistry.class.php

      CONTROLLER
        Controller.class.php
        ActionRequest.class.php
        ActionResult.class.php

      TEMPLATE
        Adapter.class.php
        Twig.class.php
        Smarty.class.php
        X64.class.php

      RENDER
        RendererInterface.class.php
        HtmlRenderer.class.php
        JsonRenderer.class.php

      I18N
      REST
      FSM
      VIEW
      URL
      BDD
      ACL
      MENU
      MODEL
      HELPER

    libs
      adodb5
      Smarty-3.0.7
      x64

  skeleton
    public
      index.php
      .htaccess

    application
      default
        Index_controller.class.php
        templates
        local

    sites
      default
        site.xml
        routes.xml
        modules.xml
        theme.xml

    themes
      default
        css
        js
        img

  examples
    basic
    multisite

  DOC
    ARCHITECTURE.md
    COMPOSER.md
    MULTISITE.md
    SITE_RESOLVER.md
    TEMPLATE_ADAPTERS.md

  tests
```

### 4.1 Contrat ASAP

ASAP ne contient jamais :

```text
MO_KB
LogAndPlay spécifique
Maestro spécifique
VSTi spécifique
thème métier
route métier
secret
configuration de domaine réel
```

ASAP fournit :

```text
boot framework
site resolver
router
dispatcher
module registry
controller base
template adapters
renderer contracts
i18n contracts
ACL contracts
skeleton de site
examples
```

---

## 5. Composer côté ASAP

`ASAP/composer.json` cible :

```json
{
  "name": "logandplay/asap",
  "description": "ASAP PHP framework",
  "type": "library",
  "require": {
    "php": ">=8.0",
    "twig/twig": "^3.0"
  },
  "autoload": {
    "classmap": [
      "framework/ASAP",
      "framework/libs"
    ]
  }
}
```

Twig est donc une dépendance du framework.

```text
ASAP
  -> Composer
      -> twig/twig
```

ASAP expose Twig via :

```text
framework\ASAP\TEMPLATE\Twig.class.php
```

---

## 6. Dépôt KB_FRONT cible

Chemin recommandé :

```text
H:\UwAmp\www\KB_FRONT
```

Nom Git recommandé :

```text
KB_FRONT
```

ou conserver le dépôt GitHub actuel :

```text
Maestro_KB_Extranet
```

Arborescence cible :

```text
KB_FRONT
  .git
  composer.json
  composer.lock
  README.md
  .gitignore

  public
    index.php
    .htaccess

    api
      proxy.php

    assets
      css
      js
      img

  application
    default
      Index_controller.class.php
      helpers
        KbFront_helper.class.php
      templates
        layout.twig
      local
        fr
          I18n.xml
        en
          I18n.xml
        es
          I18n.xml

    musicien
      Index_controller.class.php
      Service
      ViewModel
      templates
        page.twig
      javascript
        index.js
      local
        fr
          index.xml
        en
          index.xml
        es
          index.xml

    matiere
    ecoute
    k2000
    technique
    security

    backoffice
      Index_controller.class.php
      Service
      ViewModel
      templates
        dashboard.twig
      javascript
        index.js
      local
        fr
          index.xml
        en
          index.xml
        es
          index.xml

  data
    navigation
    pages
    cards
    docs
    schemas

  sites
    _shared
      routes.common.xml
      modules.common.xml
      permissions.common.xml

    kb-front
      site.xml
      routes.xml
      modules.xml
      theme.xml
      permissions.xml

    kb-backoffice
      site.xml
      routes.xml
      modules.xml
      theme.xml
      permissions.xml

    kb-local
      site.xml
      routes.xml
      modules.xml
      theme.xml
      permissions.xml

  themes
    mokb
      css
      js
      img

    mokb-backoffice
      css
      js
      img

  config
    api.dist.php
    env.dist.php
    api.local.php
    env.local.php

  var
    cache
    logs

  DOC
    ARCHITECTURE.md
    FRONT_BACKOFFICE.md
    patches
```

---

## 7. Composer côté KB_FRONT

`KB_FRONT/composer.json` cible :

```json
{
  "name": "logandplay/kb-front",
  "type": "project",
  "repositories": [
    {
      "type": "path",
      "url": "../_packages/ASAP",
      "options": {
        "symlink": true
      }
    }
  ],
  "require": {
    "php": ">=8.0",
    "logandplay/asap": "*"
  }
}
```

KB_FRONT ne doit pas déclarer Twig comme moteur souverain du front.

Twig arrive via ASAP.

---

## 8. Gestion des sites

ASAP gère le multisite par capacité.

KB_FRONT déclare les sites par configuration.

```text
sites\kb-front
= interface musicien / consultation / usage normal

sites\kb-backoffice
= pilotage, ingestion, jobs, workers, sécurité, maintenance

sites\kb-local
= développement local / diagnostic
```

### 8.1 `site.xml`

Exemple :

```xml
<site id="kb-front">
  <hosts>
    <host>localhost</host>
    <host>127.0.0.1</host>
    <host>kb.local</host>
  </hosts>

  <basePath>/KB_FRONT</basePath>

  <defaultLang>fr</defaultLang>
  <langs>
    <lang>fr</lang>
    <lang>en</lang>
    <lang>es</lang>
  </langs>

  <defaultModule>musicien</defaultModule>
  <theme>mokb</theme>

  <routes file="routes.xml"/>
  <modules file="modules.xml"/>
  <permissions file="permissions.xml"/>
</site>
```

`site.xml` répond à :

```text
Quel site suis-je ?
Quels hosts/basePath ?
Quelle langue par défaut ?
Quels modules/routes/droits ?
Quel thème ?
```

### 8.2 `modules.xml`

Exemple `kb-front` :

```xml
<modules>
  <module name="musicien" enabled="true" menu="true" defaultAction="show"/>
  <module name="matiere" enabled="true" menu="true" defaultAction="show"/>
  <module name="ecoute" enabled="true" menu="true" defaultAction="show"/>
  <module name="k2000" enabled="true" menu="true" defaultAction="show"/>
  <module name="technique" enabled="limited" menu="false" defaultAction="show"/>
  <module name="security" enabled="false" menu="false"/>
  <module name="backoffice" enabled="false" menu="false"/>
</modules>
```

Exemple `kb-backoffice` :

```xml
<modules>
  <module name="backoffice" enabled="true" menu="true" defaultAction="dashboard"/>
  <module name="technique" enabled="true" menu="true" defaultAction="show"/>
  <module name="security" enabled="true" menu="true" defaultAction="show"/>
  <module name="k2000" enabled="true" menu="true" defaultAction="show"/>
  <module name="musicien" enabled="false" menu="false"/>
</modules>
```

### 8.3 `routes.xml`

Exemple :

```xml
<routes extends="../_shared/routes.common.xml">
  <route name="home" path="/">
    <target module="musicien" controller="index" action="show"/>
  </route>

  <route name="module_lang" path="/{lang}/{module}">
    <constraints>
      <lang>fr|en|es</lang>
      <module>musicien|matiere|ecoute|k2000|technique|security</module>
    </constraints>
    <target controller="index" action="show"/>
  </route>

  <route name="backoffice_dashboard" path="/{lang}/admin">
    <target module="backoffice" controller="index" action="dashboard"/>
  </route>
</routes>
```

Une route doit produire un objet typé :

```text
RouteMatch
  site
  lang
  module
  controller
  action
  parameters
```

---

## 9. Cycle de requête ASAP cible

Exemple :

```text
GET /fr/k2000/intake
```

Cycle :

```text
1. public/index.php charge Composer.
2. Composer charge logandplay/asap.
3. ASAP_Application démarre.
4. SiteResolver résout le site.
5. ConfigLoader charge site.xml/modules.xml/routes.xml/permissions.xml.
6. Router produit RouteMatch.
7. ModuleRegistry valide le module pour ce site.
8. Dispatcher valide controller/action.
9. Controller appelle les services applicatifs.
10. Services produisent la data.
11. ViewModel est construit et validé.
12. Renderer représente le ViewModel.
13. Twig rend HTML si représentation HTML.
```

Aucun fallback silencieux.

---

## 10. Front vs Backoffice

Front et backoffice restent dans le même dépôt `KB_FRONT` parce qu’ils partagent :

```text
backend MO_KB_DAEMON
domaine fonctionnel KB
modules métier
data
services
contrats
thème parent
```

Ils sont séparés par sites :

```text
sites\kb-front
sites\kb-backoffice
```

Et éventuellement par thèmes :

```text
themes\mokb
themes\mokb-backoffice
```

---

## 11. Git et hygiène

### 11.1 À versionner

```text
application/
data/
sites/
themes/
public/index.php
public/.htaccess
public/api/proxy.php
config/*.dist.php
composer.json
composer.lock
README.md
DOC/
```

### 11.2 À ignorer

```text
vendor/
var/cache/
var/logs/
.env
*.local.php
*.secret.php
*.tmp
*.bak
templates_c/
__pycache__/
node_modules/
```

### 11.3 Scories à éliminer lors des paliers futurs

```text
MO_KB_FRONT/app/Engine
MO_KB_FRONT/templates
MO_KB_FRONT/i18n
MO_KB_FRONT/public/index.php maison
MO_KB_FRONT/MO_KB_FRONT_ASAP imbriqué
var/cache suivi par Git
vendor suivi par Git
dossiers *_EXTRACT
```

Suppression seulement après migration validée.

---

## 12. Workspace VS Code cible

Après création des dépôts réels :

```text
MAESTRO_WORKSPACE
MAESTRO_V5
MO_KB_DAEMON
ASAP
KB_FRONT
DEMO_ASAP
```

Plus tard :

```text
DOC_MAESTRO_USER
DOC_MAESTRO_REF
DOC_VSTI_USER
DOC_VSTI_REF
```

Le workspace VS Code reflète les sources de vérité réelles.
Il ne doit pas inventer de dossiers qui n’existent pas encore.

---

## 13. Plan de migration proposé

### P112A — Plan architecture

```text
Écrire et valider ce document.
Aucun patch code.
```

### P112B — Créer dépôt ASAP

```text
Créer H:\UwAmp\www\_packages\ASAP.
Extraire uniquement le framework ASAP générique.
Créer composer.json ASAP.
Aucun code MO_KB.
```

### P112C — Composer ASAP

```text
Installer Twig via Composer dans ASAP.
Valider adapter Twig ASAP.
Valider skeleton ASAP.
```

### P112D — Créer KB_FRONT propre

```text
Créer H:\UwAmp\www\KB_FRONT.
Migrer application/sites/themes/data depuis l’ancien MO_KB_FRONT_ASAP utile.
Connecter à ASAP via Composer path repository.
```

### P112E — Front + Backoffice comme sites

```text
Créer sites/kb-front.
Créer sites/kb-backoffice.
Créer sites/kb-local.
Valider routes/modules/actions.
```

### P112F — Nettoyage ancien hybride

```text
Supprimer front Twig maison uniquement après validation.
Supprimer MO_KB_FRONT_ASAP imbriqué uniquement après bascule.
Nettoyer caches, vendor suivis, scories.
```

### P112G — VS Code workspace

```text
Ajouter ASAP.
Ajouter KB_FRONT.
Ajouter DEMO_ASAP si créé.
Retirer ancien MO_KB_FRONT seulement quand remplacé.
```

---

## 14. Conditions de validation

P112 est validé seulement si :

```text
ASAP est indépendant.
ASAP est installable via Composer.
Twig est une dépendance ASAP.
KB_FRONT dépend d’ASAP.
Front et backoffice sont des sites configurés.
Les modules/actions/routes sont stricts.
La data est séparée de la représentation.
Aucun fallback silencieux.
Git est propre.
Aucune scorie.
```

---

## 15. Prochaine action après validation

Prochain palier recommandé :

```text
P112B_CREATE_ASAP_REPO_SKELETON
```

Aucun fichier source existant ne doit être supprimé dans P112B.
