# P117W R8SEC2A — Handoff

R8SEC2 a été correctement stoppé avant toute modification locale sur un faux mismatch de baseline dans `sites/essai/config/application.fsm.json`. Les sorties owner montrent ensuite `git status --porcelain=v1 -uall` vide et `git diff` vide : aucune modification R8SEC2 n'a été appliquée.

Cause retenue : comparaison d'un SHA Git blob attendu avec un SHA recalculé sur les octets du working tree Windows, sensible aux conversions CRLF.

R8SEC2A remplace uniquement cette gate par : propreté Git de chaque cible + `git rev-parse HEAD:<path>` comparé au blob SHA GitHub attendu. Le contenu fonctionnel R8SEC2 reste inchangé.

Ne pas considérer la capture FSM comme preuve de R8SEC2 : l'applicateur a quitté avant les écritures. Le diagramme visible correspond donc encore à l'état antérieur.
