# HANDOFF — OPUS P117W R45B2A1R5

Date : 2026-08-05

## Base

OPUS `master` : `0d593557bdceb700e1985cbe03523e93b83619d2`.

R45B2A1R4 est acquis. `test4` confirme que la FSM est chargée, mais révèle deux défauts génériques de scaffold : assets statiques interceptés par le front controller et identifiant de contrat interne visible dans le footer.

## Livrable actif

```text
ZIP     : opus_p117w_r45b2a1r5_generated_site_static_assets_footer.zip
SHA-256 : fc9028fc703dc29f3d0c5255358e93d1c96170dc2c87aaf422579cc5a5b579ea
FILES   : 1
BASE    : 0d593557bdceb700e1985cbe03523e93b83619d2
```

Chemin unique :

- `Opus/Scaffold/SiteScaffoldPlan.php`

## Validation owner obligatoire

Appliquer le ZIP, linter, régénérer l'autoload, valider `owasys-front` et `owasys-back`, puis contrôler le diff. Supprimer `test4` par la commande OPUS et recréer un site depuis OWASYS. Ne jamais réparer `test4` à la main.

Le nouveau site doit charger ses CSS et ne plus afficher `OPUS_SITE_STANDARD_CONTRACT_CORE`.

PHP/Composer/runtime n'ont pas été exécutés dans le conteneur de préparation.

## Suite

Le défaut `FSM 0` du Profiler est distinct : la FSM fonctionne, mais le runtime généré n'émet pas encore d'événements `fsm.*` réellement mesurés. Ce sera le livrable suivant seulement après acquisition de R45B2A1R5.

L'éditeur Sources/Git reste planifié après stabilisation de cette génération de bout en bout.
