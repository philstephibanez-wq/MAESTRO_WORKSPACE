# MAESTRO WORKSPACE — Handoff OPUS P117W R46C1

Date : 2026-07-31  
Base OPUS relue : `ecdd12c` (`opus_p117w_r46b1_profiler_rest_collector`)

## État réel

- R46A1 est validé et poussé.
- R46B1 est présent sur `OPUS/master` au commit `ecdd12c`.
- R46C n'était pas implémenté avant ce différentiel : le panneau OWASYS était un `aside` statique sans iframe.
- R46C1 est livré sous forme de ZIP différentiel et reste à appliquer, linter, tester puis pousser par l'owner.

## Cause traitée

OPUS possédait déjà `WebProfilerController`, `WebProfilerView` et un SCORE générique, mais ces briques lisaient un ancien stockage composé d'un fichier JSON par trace. R46A1 écrit désormais un JSONL par application. OWASYS ne routait pas vers ce contrôleur et affichait une corrélation statique non prouvée.

## Différentiel R46C1

Archive : `opus_p117w_r46c1_profiler_score_iframe.zip`  
SHA-256 : `339db6148b5a8202fcd5c1c0127fa3e2fe6f9b925ed9e047fe8f345034828098`

Le différentiel :

1. branche la route `/_opus/profiler/trace/<trace_id>` sur le Profiler JSONL V2 ;
2. impose un environnement `dev`, `local` ou `development` ;
3. impose l'ACL serveur `profiler:view` ;
4. rend le détail par le SCORE générique OPUS ;
5. place ce rendu dans une iframe same-origin hébergée par l'`aside` OWASYS ;
6. envoie `Content-Security-Policy: frame-ancestors 'self'` et `X-Frame-Options: SAMEORIGIN` ;
7. supprime la chaîne statique `front → REST → back → Composer` ;
8. affiche événements, spans, statuts, durées et indisponibilités réellement présents.

## Validation acquise

- `git diff --check` sans sortie ;
- JSON ACL valide ;
- archive testée sans erreur ;
- 10 fichiers complets aux chemins finaux ;
- aucune dépendance, cache, log, smoke ou rapport dans le ZIP.

PHP et Composer sont absents de l'environnement de construction. Le lint, l'autoload et la recette HTTP/DOM restent obligatoires sur `H:\OPUS`.

## Critère de preuve owner

R46C1 n'est accepté que si le DOM OWASYS contient réellement un `iframe.ow-profiler-frame`, que sa route retourne un SCORE OPUS avec les événements de la trace demandée, que l'accès est refusé hors développement et sans `profiler:view`, et que la corrélation statique a disparu.

NO EVENT, NO CLAIM.  
NO TEST, NO ACCEPTANCE.
