# OPUS P117W — R45B4 PROFILER ENVIRONMENT CONFIG

Date : 2026-08-07  
Statut : livrable owner prêt  
Base OPUS : `6be07a76e20dfeea09b51c7c016083da626bf974`

## 1. Acquisition précédente

R45B3 est acquis sur `OPUS/master` au commit :

```text
6be07a76e20dfeea09b51c7c016083da626bf974
opus_p117w_r45b3_rest_client_contract
```

R45B4 est construit exclusivement sur ce HEAD. Aucun fichier de `test7`, `testxxxx` ou autre site généré existant n'est corrigé.

## 2. Cause générique traitée

Avant R45B4, le Web Profiler était encore partiellement possédé par le site généré :

- route `profiler.trace` dans `routes.json` ;
- état et transition Profiler dans la FSM applicative ;
- droit `profiler:view` dans l'ACL du site ;
- message I18n et composant `profiler-link.score` ;
- footer/CSS Profiler spécifiques ;
- instanciation du `Profiler` dans l'`Application.php` générée ;
- décision d'environnement effectuée dans `WebProfilerController` via `OPUS_ENV` et `accessGranted`.

Cette structure ne permettait pas de rendre le Web Profiler réellement absent en production et obligeait le site généré à connaître sa mécanique interne.

R45B4 déplace cette décision dans OPUS et le bootstrap du runtime générique.

## 3. Configuration d'environnement

R45B4 ajoute :

```text
Opus/Profiler/ProfilerConfiguration.php
Opus/Profiler/ProfilerConfigurationInterface.php
```

Contrat :

```text
OPUS_PROFILER_ENVIRONMENT_CONFIG_V1
```

La configuration est lue au bootstrap par `File` puis `StructuredFileLoader` depuis `config/environment.yaml`.

Valeur générée par défaut :

```yaml
# Configuration d'environnement OPUS.
# Cette configuration est lue par File + StructuredFileLoader au bootstrap.
contract: OPUS_PROFILER_ENVIRONMENT_CONFIG_V1

# dev est le seul environnement autorisant le Web Profiler.
# En production, profiler.web.enabled ou profiler.web.links à true est refusé.
environment: dev

profiler:
  # Active la collecte des mesures Profiler.
  # En production, la valeur recommandée est false.
  collect: true

  web:
    # Enregistre la route Web Profiler générique OPUS.
    # Cette option est autorisée uniquement avec environment: dev.
    enabled: true

    # Injecte le lien de la trace courante dans le ViewModel SCORE.
    # false conserve la collecte et l'URL directe sans afficher de lien,
    # ce qui permet de visualiser la page comme en production.
    links: false
```

Les commentaires sont du YAML standard et sont compatibles avec le parseur OPUS.

## 4. Trois décisions distinctes

R45B4 sépare strictement :

1. `profiler.collect` : collecte des traces ;
2. `profiler.web.enabled` : enregistrement du Web Profiler ;
3. `profiler.web.links` : injection du lien dans le ViewModel SCORE.

Règles :

- `links=true` exige `web.enabled=true` ;
- `web.enabled=true` exige `collect=true` ;
- tout `profiler.web` actif hors environnement exact `dev` est refusé au bootstrap ;
- l'absence de `config/environment.yaml` adopte une politique sûre : production, collecte/web/liens désactivés ;
- `opus:dev-server` ne force aucune de ces valeurs.

## 5. Fournisseur générique de lien

R45B4 ajoute :

```text
Opus/Profiler/ProfilerLinkProvider.php
Opus/Profiler/ProfilerLinkProviderInterface.php
```

Le fournisseur enrichit uniquement le slot générique :

```text
diagnostics.profiler_available
diagnostics.profiler_url
diagnostics.profiler_label
```

Lorsque la trace courante est valide :

```text
/_opus/profiler/trace/{trace_id}
```

Le layout SCORE ne connaît aucune classe Profiler et ne contient que :

```text
[[ if: diagnostics.profiler_available ]]
<a href="{{ diagnostics.profiler_url }}">{{ diagnostics.profiler_label }}</a>
[[ endif ]]
```

Avec `links=false`, le lien n'est pas produit mais la route directe reste disponible si `web.enabled=true`.

## 6. Bootstrap et production

`GeneratedSiteRuntime` charge la politique au constructeur, avant le dispatch HTTP.

En `dev` avec Web Profiler activé :

- le collecteur est disponible si `collect=true` ;
- `WebProfilerController` et `WebProfilerView` sont instanciés uniquement si `web.enabled=true` ;
- `ProfilerLinkProvider` est instancié uniquement si `links=true` ;
- la route réservée OPUS `/_opus/profiler/trace/{trace_id}` est traitée par le runtime.

Hors `dev` :

- toute tentative d'activer `profiler.web` est refusée au bootstrap ;
- aucun contrôleur Web Profiler n'est instancié ;
- aucun `WebProfilerView` n'est instancié ;
- aucun fournisseur de liens n'est enregistré ;
- aucune route Profiler de site n'existe ;
- une URL `/_opus/profiler/trace/{trace_id}` sans Web Profiler enregistré produit `OPUS_GENERATED_ROUTE_NOT_FOUND`, mappé HTTP 404 ;
- aucun template/asset Web Profiler n'est chargé par le runtime.

La collecte reste indépendante du Web Profiler ; en production, `collect=false` est la valeur recommandée.

## 7. Contrôleur Web Profiler

`WebProfilerController` redevient un contrôleur de route pur :

- plus de lecture directe de `OPUS_ENV` ;
- plus de booléen `accessGranted` ;
- aucune décision de bootstrap ou d'environnement pendant la requête ;
- validation du chemin/trace et rendu seulement.

La décision d'existence du composant est donc structurelle et prise avant la requête.

## 8. Scaffold générique

R45B4 ajoute :

```text
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicyInterface.php
```

et branche cette politique dans `Opus/Scaffold/ScaffoldEntry.php`.

La canonicalisation intervient avant l'aperçu Composer et avant l'écriture filesystem. Elle retire des nouveaux sites générés :

- le répertoire applicatif Profiler ;
- la route `profiler.trace` ;
- l'état/transition FSM Profiler ;
- la policy ACL `profiler:view` ;
- le message I18n `profiler.link` ;
- `profiler-link.score` ;
- le lien Profiler du footer ;
- le sélecteur CSS Profiler ;
- l'instanciation Profiler dans l'`Application.php` générée.

Elle génère à la place `config/environment.yaml` commenté et le slot SCORE générique dans le layout.

Le site généré ne contient donc plus de logique Web Profiler propre ; il consomme seulement le ViewModel fourni par OPUS.

## 9. Contrats de classes

Les nouvelles classes concrètes implémentent chacune leur interface homonyme. Les interfaces étendent directement :

- `OpusFrameworkComponentInterface` ;
- `OpusExceptionAwareInterface` ;
- `OpusProfilerAwareInterface` ;
- `OpusSelfDocumentingInterface`.

## 10. Livrable

```text
ZIP     : opus_p117w_r45b4_profiler_environment_config.zip
SHA-256 : dba3294a4dca74749e78bfb183985e1b501a6cb09b9805aa77537bd66931de98
FILES   : 10
BASE    : 6be07a76e20dfeea09b51c7c016083da626bf974
```

Fichiers complets :

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Profiler/ProfilerConfiguration.php
Opus/Profiler/ProfilerConfigurationInterface.php
Opus/Profiler/ProfilerLinkProvider.php
Opus/Profiler/ProfilerLinkProviderInterface.php
Opus/Profiler/WebProfilerController.php
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicyInterface.php
Opus/Scaffold/ScaffoldEntry.php
tools/smoke_p117w_r45b4_profiler_environment.php
```

Smoke :

```text
FILE    : tools/smoke_p117w_r45b4_profiler_environment.php
SHA-256 : baf59d199eeea2e2528fdcb6d5cfe265a07ac4098df2cc5352fed9dba3a20b7b
OUTPUT  : OPUS_P117W_R45B4_SMOKE_OK
```

## 11. Validation effectuée avant livraison

- `php -l` : 10/10 fichiers PHP OK ;
- harnais local de contrat : `R45B4_LOCAL_HARNESS_OK` ;
- contrôle structurel du contrôleur : plus de `OPUS_ENV` ni `accessGranted` ;
- contrôle de la canonicalisation : route/FSM/ACL/composant Profiler retirés ;
- contrôle de la configuration : production + Web Profiler refusée ;
- contrôle du fournisseur : URL de trace générique correcte ;
- contrôle du ZIP : 10 fichiers aux chemins finaux.

Le smoke complet avec l'autoload réel OPUS doit être exécuté par l'owner après extraction dans `H:\OPUS`.

## 12. Validation owner obligatoire

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r45b4_profiler_environment_config.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b4_profiler_environment_config.zip"
composer dump-autoload -o
php tools\smoke_p117w_r45b4_profiler_environment.php
```

Résultat attendu :

```text
OPUS_P117W_R45B4_SMOKE_OK
```

Puis générer un nouveau site depuis le wizard OWASYS et vérifier :

1. `config/environment.yaml` présent et commenté ;
2. `links=false` : aucun lien affiché ;
3. `web.enabled=true` : URL directe Profiler disponible en `dev` ;
4. `links=true` : lien injecté dans SCORE ;
5. environnement production avec `web.enabled=true` : bootstrap refusé ;
6. production avec Web Profiler désactivé : URL Profiler = HTTP 404 ;
7. aucune route/FSM/ACL/template Profiler propre au site généré ;
8. commit et push OPUS par l'owner seulement après succès.

## 13. Périmètre exclu

R45B4 ne contient :

- aucune correction de `test7` ou d'un autre site généré existant ;
- aucune modification OWASYS métier ;
- aucun JavaScript backend ;
- aucun secret ;
- aucun log, cache ou vendor ;
- aucun push OPUS par l'assistant.

## 14. Suite gouvernée

Après acquisition R45B4 :

```text
R45C — wizard OWASYS structuré
R45D — administration Sécurité
```

NO PROFILER WEB OUTSIDE DEV.  
NO SITE-OWNED PROFILER ROUTE.  
NO SITE-OWNED PROFILER FSM/ACL/TEMPLATE.  
NO OPUS_ENV GATE IN WEB CONTROLLER.  
NO LOCAL SITE FIX.  
NO BACKEND JAVASCRIPT.  
NO PUSH OPUS PAR L’ASSISTANT.
