# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 07756d41d171fec1758722874adaa889a931026e
Dernier acquis : R45A3
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R45A3 est poussé et acquis ; la frontière REST/Profiler conserve le résultat métier et les codes canoniques.
- R45A2 est poussé et acquis ; le modèle typé générique ACL/SSO est présent.
- R46B15 est acquis ; `registry.clear` et le rejeu Profiler distant sont idempotents.
- R45A1 est acquis : priorité du deny et chargement ACL structuré.
- R46B10 est annulé et interdit.
- Le contrat FSM V2 reste `table_fsm + current_state + signal -> next_state`.
- Les sites générés sont des témoins, jamais des cibles de correction locale.

## Validation runtime acquise

La collision sur `test` est désormais restituée sous son code canonique
`OPUS_SCAFFOLD_TARGET_ALREADY_EXISTS`. Elle ne doit pas déclencher de suppression
automatique ni de nouvelle tentative avec le même identifiant.

## Livrable owner actif — R45B1

```text
ZIP     : opus_p117w_r45b1_profile_conformance_gate.zip
SHA-256 : 38fb6a3832e14bfea4ecc3bb10f3b1450ef20833698805386c29d3f4fe30ba5d
FILES   : 2
BASE    : 07756d41d171fec1758722874adaa889a931026e
STATUS  : livré, validation et push owner requis
```

R45B1 corrige `presentation=false` pour backend et bloque avant écriture puis à
la validation tout artefact SCORE/JavaScript/TypeScript/package manager,
template/layout ou couche `shared` dans ce profil.

## Suite gouvernée

Après acquisition de R45B1, R45B2 poursuit le scaffold réellement distinct :

- frontend : SCORE et client REST avec backend cible ;
- backend : REST, FSM, SSO, ACL et persistance, sans SCORE ni JavaScript ;
- fullstack : un seul site, frontière REST obligatoire, sans `shared`.

R45C (wizard structuré) et R45D (administration Sécurité) restent ultérieurs.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
