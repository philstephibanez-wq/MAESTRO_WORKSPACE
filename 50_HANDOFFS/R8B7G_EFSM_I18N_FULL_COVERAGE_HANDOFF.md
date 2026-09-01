# R8B7G — Handoff EFSM I18n complète front + back

Date: 2026-09-01

## Baseline

GitHub OPUS relu: `1034e0b7cc0bb323219458dbf08b07cf8843c316` (`R8B7C`).

## État validé avant tranche

- runtime OWASYS front déclaré OK après R8B7F;
- géométrie `sites/owasys-front/config/navigation.fsm.layout.json` modifiée localement par l'owner et à préserver;
- R8B7E/R8B7F ont supprimé l'API générique de fallback OPUS et le caller résiduel du designer, mais ne sont pas encore confirmés comme commit/push GitHub dans ce handoff;
- l'audit NO-FALLBACK reste ouvert pour les politiques/catalogues/routes.

## Prochaine tranche

R8B7G doit fournir les catalogues exacts nécessaires aux labels visibles des states/transitions EFSM de `owasys-front` et `owasys-back`.

Aucun layout ne fait partie du ZIP.
Aucun fallback/inherits ne doit être introduit.
Les IDs techniques restent inchangés.

## Gate obligatoire

Le workflow stepwise impose de fermer le lot local déjà validé avant d'appliquer R8B7G. Le prochain échange doit donc établir le HEAD et l'état Git locaux après R8B7E/R8B7F et la modification de géométrie. Si le worktree est dirty, l'owner doit revoir/committer/pousser le lot validé avant application du nouveau ZIP.

## Critères runtime R8B7G

- Navigation front: aucun `⚠` sur state/transition traduit;
- Security front: idem;
- Registry/Application/Data/Source/Git/Build front: idem;
- projection des EFSM de `owasys-back`: idem;
- absence de 500;
- géométrie propriétaire inchangée.
