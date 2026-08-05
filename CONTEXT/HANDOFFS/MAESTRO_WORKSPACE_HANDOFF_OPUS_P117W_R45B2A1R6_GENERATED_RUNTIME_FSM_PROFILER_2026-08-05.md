# HANDOFF — OPUS P117W R45B2A1R6

Date : 2026-08-05

## Base

OPUS `master` : `d18badad99298376a25d388bb0a76e25efc14d98`.

R45B2A1R5 est acquis. `test5` confirme le rendu SCORE corrigé. Le défaut actif est `FSM 0` : la FSM fonctionne, mais le runtime généré ne reçoit pas le Profiler actif de l'application.

## Livrable actif

```text
ZIP     : opus_p117w_r45b2a1r6_generated_runtime_fsm_profiler.zip
SHA-256 : b5937135d47dbfbec62bafd40a7754423c8db5caf1e11b9cc6c113b197a56d1d
FILES   : 3
BASE    : d18badad99298376a25d388bb0a76e25efc14d98
```

Chemins :

- `Opus/Application/Runtime/GeneratedSiteRuntime.php` ;
- `Opus/Fsm/FsmProcessor.php` ;
- `Opus/Scaffold/SiteScaffoldPlan.php`.

## Validation owner obligatoire

Appliquer le ZIP, linter les trois sources, régénérer l'autoload, valider les deux bastions OWASYS et contrôler le diff. Supprimer `test5` par la commande OPUS puis le recréer depuis OWASYS ; ne jamais le réparer à la main.

Le panneau FSM doit être alimenté par les événements réels du runtime. L'accueil produit notamment `fsm.transition.skipped`; une navigation vers un autre état produit le span `fsm.transition` et `fsm.transition.completed`.

PHP/Composer/runtime n'ont pas été exécutés dans le conteneur de préparation.

## Suite

Après acquisition : rétention/rotation bornée du Profiler, puis éditeur Sources/Git selon E1/E2/E3.
