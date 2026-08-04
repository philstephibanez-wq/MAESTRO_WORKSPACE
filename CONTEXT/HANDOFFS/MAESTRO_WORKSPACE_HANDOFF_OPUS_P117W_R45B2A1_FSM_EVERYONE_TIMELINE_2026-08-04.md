# HANDOFF — OPUS P117W R45B2A1

Date : 2026-08-04

## Base acquise

- OPUS `master` : `dac97628f182b62ee7d2759583441f5bdf179c36`.
- R45B2 est poussé et acquis.
- Les sites générés ne sont jamais des cibles de correction locale.

## Livrable actif

```text
ZIP     : opus_p117w_r45b2a1_fsm_everyone_timeline.zip
SHA-256 : 4d4b1ee5b8585f8d1529578e08b4cbb6575ef1414c8c6c4ca86b3752776399fd
FILES   : 4
BASE    : dac97628f182b62ee7d2759583441f5bdf179c36
```

R45B2A1 corrige la génération FSM, sépare `everyone` des rôles métier et rend la timeline principale non dupliquée.

## Prochaine action

L'owner applique le ZIP dans `H:\\OPUS`, valide via OWASYS, committe et pousse OPUS. Après acquisition, R45B2A2 traite la rétention/rotation JSONL configurable, puis R45B3 le client REST frontend.
