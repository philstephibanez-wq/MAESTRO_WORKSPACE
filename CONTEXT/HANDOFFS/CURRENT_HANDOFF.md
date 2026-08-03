# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-03

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B1_PROFILE_CONFORMANCE_GATE_2026-08-03.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45B1_PROFILE_CONFORMANCE_GATE_2026-08-03.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

- OPUS GitHub : `07756d41d171fec1758722874adaa889a931026e`.
- R45A3 est poussé et acquis.
- R45A2 est poussé et acquis.
- R46B15 est poussé et acquis.
- R46B10 reste annulé et interdit.
- Le workflow actif est la création d'un site.

## Livrable actif

```text
ZIP     : opus_p117w_r45b1_profile_conformance_gate.zip
SHA-256 : 38fb6a3832e14bfea4ecc3bb10f3b1450ef20833698805386c29d3f4fe30ba5d
FILES   : 2
BASE    : 07756d41d171fec1758722874adaa889a931026e
```

R45B1 empêche l'écriture et la validation d'un faux backend contenant SCORE,
JavaScript/TypeScript, métadonnées de paquets JavaScript, templates/layouts ou
une couche `shared`.

## Prochaine action

L'owner applique, valide et pousse R45B1. R45B2 génère ensuite le runtime REST
générique et le manifeste de corrélation fullstack. Aucun site témoin ne doit
être corrigé localement.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
