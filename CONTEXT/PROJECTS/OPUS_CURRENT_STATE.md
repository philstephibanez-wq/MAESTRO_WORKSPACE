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
- R45B2A3 : module `application/profiler` du scaffold historique, désormais remplacé par la politique R45B4 pour les nouveaux sites.
- R45B2A4 : alignement historique de `profiler:view`, désormais remplacé par la politique R45B4 pour les nouveaux sites.
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
SHA-256 : e67034362a664b78c0b993f46c358c9dea5e9a7b4b8747fc14b6dc0a0e23da16
FILES   : 9
BASE    : 6be07a76e20dfeea09b51c7c016083da626bf974
STATUS  : livré, application, validation, commit et push owner requis
```

Le ZIP ne contient que les neuf fichiers OPUS complets et exclut tout smoke, audit, rapport, log, cache, vendor et temporaire conformément au contrat global.

Smoke owner séparé :

```text
smoke_opus_p117w_r45b4_profiler_environment_owner.php
SHA-256 : 65aaa0dfc8adf171db262383452f0fc1b3914568d9d4997ce73d899c061f50a9
OUTPUT  : OPUS_P117W_R45B4_SMOKE_OK
```

Le smoke séparé utilise `token_get_all()` pour l'audit exhaustif des classes concrètes OPUS et doit être supprimé avant commit.

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

## Prévalidation assistant

- neuf fichiers PHP du ZIP : lint OK ;
- harnais local : `R45B4_LOCAL_HARNESS_OK` ;
- audit `token_get_all()` du smoke : test synthétique `AUDIT_OK` ;
- ZIP : neuf fichiers complets, aucune pollution interdite.

Le dépôt OPUS complet n'étant pas présent dans l'environnement de l'assistant, l'autoload optimisé et le smoke exhaustif restent des gates owner obligatoires avant conformité.

## Validation owner attendue

1. HEAD exact `6be07a76e20dfeea09b51c7c016083da626bf974` avant extraction ;
2. contrôle SHA-256 du ZIP et du smoke séparé ;
3. extraction du ZIP à la racine `H:\OPUS` ;
4. `composer dump-autoload -o` ;
5. copie temporaire du smoke à la racine OPUS ;
6. exécution du smoke et résultat `OPUS_P117W_R45B4_SMOKE_OK` ;
7. suppression du smoke avant commit ;
8. génération d'un nouveau site via OWASYS ;
9. contrôle du YAML commenté et de `links=false` ;
10. contrôle `links=true` ;
11. contrôle accès direct en `dev` ;
12. contrôle refus d'activation Web Profiler en production ;
13. contrôle HTTP 404 lorsque le Web Profiler n'est pas enregistré ;
14. confirmation qu'aucune logique Profiler propre au site n'est générée ;
15. commit et push owner après succès.

## Suite gouvernée

1. acquisition owner R45B4 ;
2. R45C : wizard OWASYS structuré ;
3. R45D : administration Sécurité.

NO PROFILER WEB OUTSIDE DEV.
NO SITE-OWNED PROFILER ROUTE/FSM/ACL/TEMPLATE.
NO OPUS_ENV GATE IN WEB CONTROLLER.
NO SMOKE IN OPUS ZIP.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L’ASSISTANT.
