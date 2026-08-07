# OPUS P117W — R45B4 PROFILER ENVIRONMENT CONFIG

Date : 2026-08-07  
Statut : livrable owner prêt, validation owner requise  
Base OPUS : `6be07a76e20dfeea09b51c7c016083da626bf974`

## 1. Base acquise

R45B3 est acquis sur `OPUS/master` :

```text
6be07a76e20dfeea09b51c7c016083da626bf974
opus_p117w_r45b3_rest_client_contract
```

R45B4 est construit exclusivement sur ce HEAD. Aucun fichier de `test7`, `testxxxx` ou autre site généré existant n'est corrigé.

## 2. Cause générique

Avant R45B4, le Web Profiler était encore partiellement possédé par le site généré :

- route `profiler.trace` dans `routes.json` ;
- état et transition Profiler dans la FSM applicative ;
- droit `profiler:view` dans l'ACL du site ;
- message I18n et composant `profiler-link.score` ;
- footer/CSS Profiler spécifiques ;
- instanciation du `Profiler` dans l'`Application.php` générée ;
- décision d'environnement effectuée dans `WebProfilerController` via `OPUS_ENV` et `accessGranted`.

R45B4 déplace cette décision dans OPUS et dans le bootstrap du runtime générique. Le site généré ne connaît plus la mécanique Web Profiler ; il consomme uniquement un slot générique du ViewModel SCORE.

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

La configuration est lue au bootstrap par `File` puis `StructuredFileLoader` depuis :

```text
config/environment.yaml
```

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

Les commentaires sont du YAML standard accepté par le parseur OPUS.

## 4. Trois capacités séparées

R45B4 sépare strictement :

1. `profiler.collect` : collecte des traces ;
2. `profiler.web.enabled` : enregistrement du Web Profiler ;
3. `profiler.web.links` : injection du lien dans le ViewModel SCORE.

Règles :

- `links=true` exige `web.enabled=true` ;
- `web.enabled=true` exige `collect=true` ;
- tout Web Profiler actif hors environnement exact `dev` est refusé au bootstrap ;
- l'absence de `config/environment.yaml` adopte une politique sûre : production, collecte/web/liens désactivés ;
- `opus:dev-server` ne force aucune valeur.

## 5. Fournisseur générique de lien

R45B4 ajoute :

```text
Opus/Profiler/ProfilerLinkProvider.php
Opus/Profiler/ProfilerLinkProviderInterface.php
```

Il enrichit uniquement :

```text
diagnostics.profiler_available
diagnostics.profiler_url
diagnostics.profiler_label
```

Pour une trace courante valide :

```text
/_opus/profiler/trace/{trace_id}
```

Le layout SCORE ne contient que :

```text
[[ if: diagnostics.profiler_available ]]
<a href="{{ diagnostics.profiler_url }}">{{ diagnostics.profiler_label }}</a>
[[ endif ]]
```

Avec `links=false`, aucun lien n'est rendu. Si `web.enabled=true`, l'accès direct reste disponible en `dev`.

## 6. Bootstrap et production

`GeneratedSiteRuntime` charge la politique au constructeur, avant le dispatch HTTP.

Lorsque le Web Profiler est activé en `dev` :

- le collecteur existe si `collect=true` ;
- `WebProfilerController` et `WebProfilerView` sont instanciés uniquement si `web.enabled=true` ;
- `ProfilerLinkProvider` est instancié uniquement si `links=true` ;
- la route réservée OPUS `/_opus/profiler/trace/{trace_id}` est gérée par le runtime.

Hors `dev` :

- une configuration tentant d'activer `profiler.web.enabled` ou `profiler.web.links` est refusée au bootstrap ;
- aucun contrôleur Web Profiler n'est instancié ;
- aucun `WebProfilerView` n'est instancié ;
- aucun fournisseur de liens n'est enregistré ;
- aucune route Profiler de site n'existe ;
- l'URL réservée sans Web Profiler enregistré produit `OPUS_GENERATED_ROUTE_NOT_FOUND`, mappé HTTP 404 ;
- aucun template/asset Web Profiler n'est chargé par le runtime.

La collecte reste indépendante du Web Profiler ; en production, `collect=false` reste la valeur recommandée.

## 7. Contrôleur Web Profiler

`WebProfilerController` redevient un contrôleur de route pur :

- plus de lecture directe de `OPUS_ENV` ;
- plus de booléen `accessGranted` ;
- aucune décision d'environnement pendant la requête ;
- validation du chemin/trace et rendu seulement.

La décision d'existence du composant est structurelle et prise au bootstrap.

## 8. Scaffold générique

R45B4 ajoute :

```text
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicyInterface.php
```

et branche cette politique dans :

```text
Opus/Scaffold/ScaffoldEntry.php
```

La canonicalisation intervient avant l'aperçu Composer et avant l'écriture filesystem. Pour les nouveaux sites, elle retire :

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

## 9. Contrats de classes

Les nouvelles classes concrètes implémentent chacune leur interface homonyme. Les interfaces étendent directement :

- `OpusFrameworkComponentInterface` ;
- `OpusExceptionAwareInterface` ;
- `OpusProfilerAwareInterface` ;
- `OpusSelfDocumentingInterface`.

Le smoke owner séparé exécute en plus un audit exhaustif `token_get_all()` de `Opus/**/*.php` pour bloquer toute classe concrète non conforme.

## 10. ZIP différentiel contractuel

Le contrat global interdit les smokes, audits, rapports, caches, vendors et temporaires dans le ZIP OPUS. Le smoke est donc livré séparément.

```text
ZIP     : opus_p117w_r45b4_profiler_environment_config.zip
SHA-256 : e67034362a664b78c0b993f46c358c9dea5e9a7b4b8747fc14b6dc0a0e23da16
FILES   : 9
BASE    : 6be07a76e20dfeea09b51c7c016083da626bf974
```

Fichiers complets du ZIP :

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
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45b4_profiler_environment_owner.php
SHA-256 : 65aaa0dfc8adf171db262383452f0fc1b3914568d9d4997ce73d899c061f50a9
OUTPUT  : OPUS_P117W_R45B4_SMOKE_OK
```

Le smoke séparé n'est pas destiné à être committé dans OPUS.

## 11. Prévalidation effectuée

- `php -l` : tous les neuf fichiers PHP du ZIP OK ;
- harnais local de contrat : `R45B4_LOCAL_HARNESS_OK` ;
- audit `token_get_all()` du smoke testé sur un arbre synthétique : `AUDIT_OK` ;
- contrôleur contrôlé sans `OPUS_ENV` ni `accessGranted` ;
- canonicalisation contrôlée : route/FSM/ACL/composant Profiler retirés ;
- production + Web Profiler contrôlée comme configuration refusée ;
- URL du fournisseur contrôlée ;
- ZIP contrôlé : neuf fichiers complets aux chemins finaux, aucun smoke/log/cache/vendor/rapport.

Le dépôt OPUS complet et son autoload n'étant pas présent dans l'environnement d'exécution de l'assistant, `composer dump-autoload -o` et le smoke exhaustif doivent être exécutés par l'owner avant toute déclaration de conformité.

## 12. Validation owner obligatoire

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r45b4_profiler_environment_config.zip" SHA256
certutil -hashfile "%USERPROFILE%\Downloads\smoke_opus_p117w_r45b4_profiler_environment_owner.php" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b4_profiler_environment_config.zip"
composer dump-autoload -o
copy /Y "%USERPROFILE%\Downloads\smoke_opus_p117w_r45b4_profiler_environment_owner.php" "H:\OPUS\smoke_opus_p117w_r45b4_profiler_environment_owner.php"
php smoke_opus_p117w_r45b4_profiler_environment_owner.php
del /Q "H:\OPUS\smoke_opus_p117w_r45b4_profiler_environment_owner.php"
```

Résultat attendu du smoke :

```text
OPUS_P117W_R45B4_SMOKE_OK
```

Puis générer un nouveau site depuis le wizard OWASYS et vérifier :

1. `config/environment.yaml` présent et commenté ;
2. `links=false` : aucun lien affiché ;
3. `web.enabled=true` : accès direct au Profiler en `dev` ;
4. `links=true` : lien injecté dans SCORE ;
5. production avec Web Profiler activé : bootstrap refusé ;
6. production avec Web Profiler désactivé : URL Profiler = HTTP 404 ;
7. aucune route/FSM/ACL/I18n/template/CSS Profiler propre au site généré ;
8. smoke owner supprimé avant commit ;
9. commit et push OPUS uniquement par l'owner après succès.

## 13. Périmètre exclu

R45B4 ne contient :

- aucune correction de `test7` ou d'un site généré existant ;
- aucune modification OWASYS métier ;
- aucun JavaScript backend ;
- aucun secret ;
- aucun log, cache, vendor, rapport ou smoke dans le ZIP ;
- aucun push OPUS par l'assistant.

## 14. Suite gouvernée

Après acquisition R45B4 :

```text
R45C — wizard OWASYS structuré
R45D — administration Sécurité
```

NO PROFILER WEB OUTSIDE DEV.  
NO SITE-OWNED PROFILER ROUTE/FSM/ACL/TEMPLATE.  
NO OPUS_ENV GATE IN WEB CONTROLLER.  
NO SMOKE IN OPUS ZIP.  
NO LOCAL SITE FIX.  
NO BACKEND JAVASCRIPT.  
NO PUSH OPUS PAR L’ASSISTANT.
