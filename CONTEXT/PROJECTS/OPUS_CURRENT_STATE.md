# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : ad33c64cb091711bcf98e7a1c9307cb4029e0ca6
Dernier acquis : R45A2
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R45A2 est poussé et acquis ; le modèle typé générique ACL/SSO est présent.
- R46B15 est acquis ; `registry.clear` et le rejeu Profiler distant sont idempotents.
- R45A1 est acquis : priorité du deny et chargement ACL structuré.
- R46B10 est annulé et interdit.
- Le contrat FSM V2 reste `table_fsm + current_state + signal -> next_state`.
- Les sites générés sont des témoins, jamais des cibles de correction locale.

## Défaut runtime confirmé

Une première création `site.create` peut réussir côté Composer et produire HTTP `201`, puis être requalifiée en échec parce que `RestServer` lit sa trace avant de la finaliser. Une nouvelle tentative sur le même identifiant rencontre ensuite la cible existante, mais le code canonique du scaffold est masqué.

## Livrable owner actif — R45A3

```text
ZIP     : opus_p117w_r45a3_rest_profiler_transaction_boundary.zip
SHA-256 : 6ceb5e5a55ca0b501dffc9748190fdc62b4a862ca8767df48fc278843e57b96d
FILES   : 1
BASE    : ad33c64cb091711bcf98e7a1c9307cb4029e0ca6
STATUS  : livré, validation et push owner requis
```

R45A3 finalise la trace avant lecture, rend la télémétrie non transactionnelle vis-à-vis du résultat métier et conserve les codes canoniques avec détails.

## Suite gouvernée

Après acquisition de R45A3, R45B doit rendre les profils réellement distincts :

- frontend : SCORE et client REST avec backend cible ;
- backend : REST, FSM, SSO, ACL et persistance, sans SCORE ni JavaScript ;
- fullstack : un seul site, frontière REST obligatoire, sans `shared`.

R45C (wizard structuré) et R45D (administration Sécurité) restent ultérieurs.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
