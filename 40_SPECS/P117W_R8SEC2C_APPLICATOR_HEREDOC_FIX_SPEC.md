# P117W R8SEC2C — Applicator heredoc fix

## Cause
R8SEC2B ne modifie aucun fichier OPUS car l'applicateur s'arrête avant la phase d'écriture avec `R8SEC2_RUNTIME_CONSTRUCTOR_PATTERN:0`.

La cause est interne au livrable : le premier `replaceOnce()` visant le bloc de propriétés de `GeneratedSiteRuntime.php` ouvre un nowdoc `<<<'OLD'` mais le termine par `NEW,` au lieu de `OLD,`. Le code PHP reste syntaxiquement valide, mais la chaîne de recherche absorbe une partie du code suivant et ne peut donc jamais être trouvée dans la source OPUS.

Ce défaut est distinct des fins de ligne Windows. R8SEC2B normalisait correctement CRLF/CR vers LF ; le diagnostic CRLF était donc incomplet.

## Correction
R8SEC2C corrige uniquement cette cause dans l'applicateur R8SEC2 : le terminator du nowdoc de recherche des propriétés devient `OLD,`.

Les gates Git de R8SEC2A/B restent conservées :
- contrôle du blob canonique `HEAD:<path>` ;
- refus si une cible est dirty ;
- préservation des fichiers layout runtime non ciblés ;
- aucune écriture avant validation et transformation complète de toutes les cibles.

## Cibles métier R8SEC2 inchangées
- enforcement `SecurityQuarantine::assertBusinessAllowed()` dans `GeneratedSiteRuntime` avant config/session/routing/ACL/FSM/SCORE métier ;
- NMI `security_violation -> security_quarantine` ;
- NMI `critical_error/fail -> fault` ;
- migration du scaffold générique et des FSM `essai`, `owasys-front`, `owasys-back` ;
- aucune transition automatique de recovery.

## Validation
L'applicateur doit afficher `R8SEC2C_OK`. En cas d'échec, aucune des cinq cibles ne doit être écrite.
