# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : e5878b367146a37c8f0c27a103491dc59a7a21db
Dernier acquis : R46B15
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R46B15 est poussé et acquis ; `registry.clear` et le rejeu Profiler distant sont idempotents.
- Le Profiler ne bloque plus le retour au workflow de création.
- R45A1 est acquis : deny prioritaire et chargement ACL structuré.
- R46B10 est annulé et interdit.
- Le contrat FSM V2 reste `table_fsm + current_state + signal -> next_state`.
- `test2` et tout site généré sont des témoins, jamais des cibles de correction locale.

## Livrable owner actif — R45A2

```text
ZIP     : opus_p117w_r45a2_typed_access_control_model.zip
SHA-256 : 05bd036c90d53cbcd51cf49c3d0a582c3dcf92b79f00caf50ead671274270140
FILES   : 16
BASE    : e5878b367146a37c8f0c27a103491dc59a7a21db
STATUS  : livré, validation et push owner requis
```

R45A2 fournit les objets contractuels typés nécessaires à la suite de la création : rôles, permissions, ressources, scopes, attributions SSO, règles et requêtes d'autorisation.

## Suite gouvernée

Après acquisition de R45A2, R45B doit corriger la cause générique des profils aujourd'hui seulement déclaratifs :

- frontend : SCORE et client REST avec backend cible ;
- backend : REST, FSM, SSO, ACL et persistance, sans SCORE ni JavaScript ;
- fullstack : un seul site, frontière REST obligatoire, sans `shared`.

R45C (wizard structuré) et R45D (administration Sécurité) restent ultérieurs.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
