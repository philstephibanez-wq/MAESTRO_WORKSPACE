# P117W R8SEC2C — Handoff

## Statut
R8SEC2B échoue avant toute écriture avec `R8SEC2_RUNTIME_CONSTRUCTOR_PATTERN:0`.

## Cause exacte
Dans `tools/apply_p117w_r8sec2b_runtime_quarantine.php`, le nowdoc de recherche du bloc de propriétés de `GeneratedSiteRuntime.php` est ouvert par `<<<'OLD'` mais fermé par `NEW,`. Le script est syntaxiquement valide mais le motif de recherche est faux.

## Livrable correctif
R8SEC2C conserve l'intégralité de R8SEC2B et remplace uniquement ce terminator erroné par `OLD,`.

## Invariants
- aucune écriture OPUS/OWASYS par l'assistant ;
- owner applique le ZIP ;
- `sites/essai/config/application.fsm.layout.json` n'est jamais ciblé ni nettoyé ;
- toute cible R8SEC2 doit être propre avant mutation ;
- l'applicateur doit terminer par `R8SEC2C_OK` avant validation des diffs.
