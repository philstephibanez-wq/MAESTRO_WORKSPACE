# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 4a4193094f1ea33270909008a0a1a0c8eac61c3e
Dernier acquis : R45B1
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R45B1 est poussé et acquis au commit `c585ceb` ; le gate backend est actif.
- Le commit owner `4a419309… cleanup` supprime seulement le site témoin.
- R45A3 est acquis ; la frontière REST/Profiler conserve le résultat métier.
- R45A2 et R45A1 sont acquis ; le socle ACL/SSO deny-first est présent.
- R46B15 est acquis ; `registry.clear` et le rejeu Profiler sont idempotents.
- R46B10 est annulé et interdit.
- Les sites générés sont des témoins, jamais des cibles de correction locale.

## Livrable owner actif — R45B2

```text
ZIP     : opus_p117w_r45b2_backend_rest_profile_runtime.zip
SHA-256 : 39bf3866f4a1c02f5b0a2bbb826223117a7bd8a5dbaf5b4accf5ca5fcf2c489f
FILES   : 2
BASE    : 4a4193094f1ea33270909008a0a1a0c8eac61c3e
STATUS  : livré, validation et push owner requis
```

R45B2 fait produire au profil backend un Singleton PHP, un contrôleur REST
contractuel, une FSM, ACL/SSO, une authentification HMAC, un catalogue Composer
allow-listé et des diagnostics propres, sans SCORE/JavaScript/`shared`.

Le profil fullstack reçoit le manifeste
`OPUS_FULLSTACK_REST_CORRELATION_V1`. Son client REST frontend reste le jalon
R45B3 et n'est pas déclaré acquis prématurément.

## Suite gouvernée

Après acquisition de R45B2 :

- R45B3 : client REST frontend générique et validateurs croisés ;
- R45C : wizard OWASYS structuré ;
- R45D : administration Sécurité.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
