# HANDOFF — OPUS P117W R45B2A1R1

Date : 2026-08-04

## Base acquise

- OPUS `master` : `edf17d28d32b1c2f293ba7993252b6e1748c906c`.
- R45B2A1 est poussé et acquis.
- Les sites générés ne sont jamais des cibles de correction locale.

## Livrable actif

```text
ZIP     : opus_p117w_r45b2a1r1_everyone_runtime_authorization.zip
SHA-256 : 719df05a387a62426ef570e34fd6c7d4115ad82c6c43d929139c5ec3810b0c34
FILES   : 1
BASE    : edf17d28d32b1c2f293ba7993252b6e1748c906c
```

R45B2A1R1 corrige la cause générique de `OPUS_AUTH_REQUIRED` sur un accueil public : `everyone` est reconnu comme sujet collectif implicite sans être ajouté aux rôles métier, tandis que les autres politiques restent deny-by-default.

## Profiler

La timeline observée est correctement réduite aux spans. Un panneau sans événement mesuré reste explicitement vide conformément au principe `NO EVENT, NO CLAIM`.

## Prochaine action

L'owner applique le ZIP dans `H:\\OPUS`, valide via OWASYS sur un nouveau site généré, committe et pousse OPUS. Après acquisition, R45B2A2 traite la rétention/rotation JSONL configurable, puis R45B3 le client REST frontend.
