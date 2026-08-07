# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-07.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 6be07a76e20dfeea09b51c7c016083da626bf974
Dernier acquis : R45B3 contrat client REST et catalogues croisés
Livrable actif : R45B4 Profiler configurable par environnement
```

## Jalons acquis

- R45B2A2 : rétention/rotation bornée du Profiler JSONL.
- R45B2A3 : module `application/profiler` dans le scaffold historique, désormais remplacé par la politique R45B4.
- R45B2A4 : alignement historique de `profiler:view`, désormais remplacé par la politique R45B4.
- E1 : `SiteSourceWorkspace`, publié à `60f45aae8ee6f3a10096069076900a41c33d9a19`.
- E2A : frontière Source REST/Composer, publiée à `1fc49e9e53efdd002513cc7b037a07cb2faacffc`.
- E2B : éditeur Sources frontend, publié à `d6548ec0fb1dc4bd376e730a943f45e502eed51e` et validé par édition réelle depuis OWASYS.
- E3A : workspace Git générique/backend, publié à `4b1f621051a306443ada7eb5fada2a8e9363b0aa`.
- E3B : interface Git frontend, publiée à `7b390b662573b1e71bd8d770bbcad3d3b386325b` et validée par création effective d'un commit depuis OWASYS `Sources et Git`.
- R45B3 : contrat client REST/catalogues croisés, publié à `6be07a76e20dfeea09b51c7c016083da626bf974`.

R45B3 est acquis et constitue la base exacte de R45B4.

R46 `dev-server --site=` est abandonné et ne doit jamais être appliqué.

## Contrat dev-server conservé

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

Le dépôt racine ne déclare pas de script `composer dev-server` sans préfixe `opus:`.

## État R45B3 acquis

R45B3 fournit :

- `RestResourceCatalog` générique et interface homonyme ;
- catalogue partagé de 23 ressources ;
- fingerprint déterministe indépendant de l'ordre ;
- validation croisée frontend/backend et inline/externe ;
- en-tête runtime `X-Opus-Rest-Catalog` ;
- refus client des méthodes et ressources non déclarées avant transport ;
- HTTP 409 avant Composer en cas de dérive ;
- statuts, enveloppes JSON, content-type et traces strictement contrôlés ;
- limites de requête et de réponse à 2 MiB ;
- acteur REST normalisé ;
- redirections désactivées ;
- `profiler_records` et corps sensibles expurgés des diagnostics.

Commit owner :

```text
6be07a76e20dfeea09b51c7c016083da626bf974
opus_p117w_r45b3_rest_client_contract
```

## Livrable owner actif — R45B4

```text
ZIP     : opus_p117w_r45b4_profiler_environment_config.zip
SHA-256 : dba3294a4dca74749e78bfb183985e1b501a6cb09b9805aa77537bd66931de98
FILES   : 10
BASE    : 6be07a76e20dfeea09b51c7c016083da626bf974
STATUS  : livré, application, validation, commit et push owner requis
```

Smoke inclus :

```text
tools/smoke_p117w_r45b4_profiler_environment.php
SHA-256 : baf59d199eeea2e2528fdcb6d5cfe265a07ac4098df2cc5352fed9dba3a20b7b
OUTPUT  : OPUS_P117W_R45B4_SMOKE_OK
```

R45B4 traite la cause générique du Web Profiler :

- configuration d'environnement lue par `File` + `StructuredFileLoader` ;
- `profiler.collect`, `profiler.web.enabled` et `profiler.web.links` séparés ;
- Web Profiler autorisé uniquement avec `environment: dev` ;
- configuration production tentant d'activer le Web Profiler refusée au bootstrap ;
- `ProfilerLinkProvider` générique injectant le slot `diagnostics.profiler_*` ;
- URL `/_opus/profiler/trace/{trace_id}` ;
- `links=false` conserve l'accès direct sans afficher le lien ;
- `WebProfilerController` sans `OPUS_ENV` ni `accessGranted` ;
- contrôleur, vue et fournisseur Web Profiler non instanciés lorsqu'ils ne sont pas enregistrés ;
- vraie HTTP 404 pour l'URL Profiler lorsque le Web Profiler est absent ;
- suppression, pour les nouveaux sites générés, de la route/FSM/ACL/I18n/template/CSS Profiler propres au site ;
- `Application.php` générée délègue au runtime OPUS sans instancier le Profiler ;
- layout SCORE limité au slot générique ;
- `config/environment.yaml` généré avec commentaires YAML explicites ;
- aucune correction de `test7` ni d'un autre site généré existant.

## Validation owner attendue

1. HEAD exact `6be07a76e20dfeea09b51c7c016083da626bf974` avant extraction ;
2. contrôle SHA-256 du ZIP ;
3. extraction à la racine `H:\OPUS` ;
4. `composer dump-autoload -o` ;
5. `php tools\smoke_p117w_r45b4_profiler_environment.php` ;
6. génération d'un nouveau site via OWASYS ;
7. contrôle du YAML commenté et de `links=false` ;
8. contrôle `links=true` ;
9. contrôle de l'accès direct en `dev` ;
10. contrôle du refus d'activation Web Profiler en production ;
11. contrôle HTTP 404 lorsque le Web Profiler n'est pas enregistré ;
12. confirmation qu'aucune logique Profiler propre au site n'est générée ;
13. commit et push owner après succès.

## Suite gouvernée

1. acquisition owner R45B4 ;
2. R45C : wizard OWASYS structuré ;
3. R45D : administration Sécurité.

NO PROFILER WEB OUTSIDE DEV.
NO SITE-OWNED PROFILER ROUTE/FSM/ACL/TEMPLATE.
NO OPUS_ENV GATE IN WEB CONTROLLER.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L’ASSISTANT.
