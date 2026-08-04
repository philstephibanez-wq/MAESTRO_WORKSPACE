# HANDOFF — OPUS P117W R45B2A1R2

Date : 2026-08-04
Base : `edf17d28d32b1c2f293ba7993252b6e1748c906c`

R45B2A1 est acquis. R45B2A1R1 a été appliqué localement mais les validations owner ont révélé deux régressions de `SiteCommandService` : rejet du nom FSM standard OWASYS et exigences de backend généré appliquées à `owasys-back`.

Le livrable cumulatif actif est :

```text
opus_p117w_r45b2a1r2_everyone_validation_regressions.zip
SHA-256 c8dbf7d0c726c659b666728b208fcd7b024aaa5c7c04fe9ccf39591ada122516
2 fichiers complets
```

Il corrige uniquement les causes génériques dans OPUS. Aucun fichier OWASYS, `test2`, `test3` ou autre site généré n'est inclus.

Gate owner : lint des deux fichiers, autoload, validation de `owasys-front` et `owasys-back`, puis tests de création depuis OWASYS. Aucun commit tant que les deux validations échouent.

Suite après acquisition : R45B2A2, rétention et rotation JSONL configurables.
