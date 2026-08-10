# OPUS P117W R45D2A5 — GENERATED PROFILER IFRAME INTEGRATION

Date : 2026-08-10  
Statut : LIVRABLE OWNER À VALIDER

## Base OPUS

```text
dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
opus_p117w_r45d2a3_generated_login_observability
```

## Constat source

Le Web Profiler générique fonctionne et la trace est accessible, mais l’intégration générée expose encore un lien direct vers `/_opus/profiler/trace/<trace_id>`. Le clic remplace donc la page applicative par le Profiler.

La cause est générique : `GeneratedSiteRuntime` enrichit le ViewModel avec l’URL de trace, puis le layout généré l’expose comme navigation. Le problème n’est ni la route du Profiler ni un fichier propre à `essai2`.

## Décision

En développement, le Profiler d’une application générée doit rester dans la page courante. La route Web Profiler autonome reste la source de l’iframe, mais elle ne doit plus constituer la navigation normale de la page applicative.

Le rendu du conteneur iframe doit lui-même passer par SCORE.

## Correctif R45D2A5

Fichiers :

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Application/Runtime/templates/profiler-iframe.score
Opus/Profiler/ProfilerConfiguration.php
```

Comportement :

1. en développement OPUS, lorsque collecte + Web Profiler sont actifs, la surface Profiler est disponible pour les sites générés existants lancés avec `OPUS_ENV=dev` ;
2. `GeneratedSiteRuntime` obtient l’URL de la trace courante depuis `ProfilerLinkProvider` ;
3. la page applicative reste la page principale ;
4. la trace courante est rendue dans un `iframe` SCORE sous le contenu de la page ;
5. le lien direct hérité des anciens layouts est neutralisé dans le ViewModel après composition de l’iframe, afin qu’il ne puisse plus remplacer la page ;
6. les pages d’erreur SCORE peuvent également embarquer la trace courante tant que le Profiler est actif ;
7. la route autonome `/_opus/profiler/trace/<trace_id>` reste disponible comme source same-origin de l’iframe ;
8. aucune modification de `sites/essai2`, ACL, SSO ou FSM ;
9. aucune purge des sidecars `.lock` ;
10. aucun secret ou champ de formulaire n’est injecté dans l’iframe ou dans le Profiler.

## Livrable

```text
ZIP     : opus_p117w_r45d2a5_generated_profiler_iframe_integration.zip
SHA-256 : 9ee324fae8a26f6d5083951cfc182c9d9709fb2f874e91747cbf29f8508d74bd
BASE    : dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
FILES   : 3
```

## Validation assistant

```text
PHP lint GeneratedSiteRuntime.php          OK
PHP lint ProfilerConfiguration.php         OK
SCORE iframe template                      présent
interfaces homonymes existantes            conformes aux 4 marqueurs
site-specific files                         aucun
Profiler .lock                              inchangé
```

## Gate login `essai2`

R45D2A5 ne modifie pas l’authentification. R45D2A3 journalise déjà `security.sso/authentication.failed` avec un `error_code` normalisé et sans secret. Tant que le code exact du POST de connexion n’est pas fourni, aucun correctif SSO supplémentaire ne doit être inventé.

Après R45D2A5, l’échec de connexion doit être consultable dans le Profiler embarqué de la même page ; le panneau Security / ACL / SSO ou le Logger donne la preuve à utiliser pour le correctif suivant.

NO SITE-SPECIFIC PATCH.  
NO ACL RELAXATION.  
NO SSO RELAXATION.  
NO PROFILER NAVIGATION-AWAY.  
NO PROFILER LOCK PURGE.  
NO SECRET IN LOGS/PROFILER.  
NO PUSH OPUS BY ASSISTANT.
