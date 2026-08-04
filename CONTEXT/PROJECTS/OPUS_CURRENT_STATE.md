# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-04.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : edf17d28d32b1c2f293ba7993252b6e1748c906c
Dernier acquis : R45B2A1
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R45B2A1 est poussé et acquis au HEAD owner courant.
- R45B2, R45B1, R45A3, R45A2 et R46B15 sont acquis.
- R46B10 est annulé et interdit.
- OWASYS et le générateur OPUS sont les cibles ; aucun site généré n'est corrigé localement.
- La timeline observée est réduite aux spans réels ; un panneau sans événement mesuré reste explicitement vide.

## Livrable owner actif — R45B2A1R1

```text
ZIP     : opus_p117w_r45b2a1r1_everyone_runtime_authorization.zip
SHA-256 : 719df05a387a62426ef570e34fd6c7d4115ad82c6c43d929139c5ec3810b0c34
FILES   : 1
BASE    : edf17d28d32b1c2f293ba7993252b6e1748c906c
STATUS  : livré, validation et push owner requis
```

R45B2A1R1 corrige la cause générique de `OPUS_AUTH_REQUIRED` sur l'accueil public : une politique accordée à `everyone` autorise toute identité sans transformer `everyone` en rôle métier ni supprimer l'état `anonymous`.

## Suite gouvernée

- R45B2A2 : rétention bornée et rotation JSONL configurable ;
- R45B3 : client REST frontend générique et validateurs croisés ;
- R45C : wizard OWASYS structuré ;
- R45D : administration Sécurité.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
