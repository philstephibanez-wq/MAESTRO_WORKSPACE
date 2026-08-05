# HANDOFF — OPUS P117W R45B2A1R7

Date : 2026-08-05

## Base

OPUS `master` : `381de7d4a6ca145c7a572630cb84d97a0741da6c`.

R45B2A1R6 est acquis. L'instrumentation FSM est présente, mais les applications générées n'exposent pas encore la surface Web Profiler.

## Livrable actif

```text
ZIP     : opus_p117w_r45b2a1r7_generated_web_profiler_surface.zip
SHA-256 : 21b70a957df89954814d7e19610a38014734012a6a1841dca72ba6e1f29f2359
FILES   : 2
BASE    : 381de7d4a6ca145c7a572630cb84d97a0741da6c
```

Chemins :

- `Opus/Application/Runtime/GeneratedSiteRuntime.php` ;
- `Opus/Scaffold/SiteScaffoldPlan.php`.

## Validation owner obligatoire

Appliquer le ZIP, linter les deux sources, régénérer l'autoload, valider les deux bastions OWASYS et contrôler le diff. Supprimer le site témoin par la commande OPUS puis le recréer depuis OWASYS ; ne jamais le réparer à la main.

Contrôler séparément l'accès refusé anonyme, l'accès autorisé d'un rôle déclaré en environnement de développement, l'ouverture d'une trace terminée et l'interdiction hors développement.

PHP CLI/Composer/runtime n'ont pas été exécutés dans le conteneur de préparation. Un parseur PHP indépendant et `git diff --check` ont réussi.

## Suite

Après acquisition fonctionnelle complète : rétention/rotation bornée du Profiler, puis éditeur Sources/Git selon E1/E2/E3.
