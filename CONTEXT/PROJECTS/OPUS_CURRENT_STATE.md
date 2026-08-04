# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-04.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : dac97628f182b62ee7d2759583441f5bdf179c36
Dernier acquis : R45B2
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R45B2 est poussé et acquis au HEAD owner courant.
- R45B1, R45A3, R45A2 et R46B15 sont acquis.
- R46B10 est annulé et interdit.
- OWASYS et le générateur OPUS sont les cibles ; aucun site généré n'est corrigé localement.

## Livrable owner actif — R45B2A1

```text
ZIP     : opus_p117w_r45b2a1_fsm_everyone_timeline.zip
SHA-256 : 4d4b1ee5b8585f8d1529578e08b4cbb6575ef1414c8c6c4ca86b3752776399fd
FILES   : 4
BASE    : dac97628f182b62ee7d2759583441f5bdf179c36
STATUS  : livré, validation et push owner requis
```

R45B2A1 corrige le nom obligatoire des FSM générées, sépare `everyone` des rôles métier et affiche une timeline principale fondée sur les spans sans duplication des événements.

## Suite gouvernée

- R45B2A2 : rétention bornée et rotation JSONL configurable ;
- R45B3 : client REST frontend générique et validateurs croisés ;
- R45C : wizard OWASYS structuré ;
- R45D : administration Sécurité.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
