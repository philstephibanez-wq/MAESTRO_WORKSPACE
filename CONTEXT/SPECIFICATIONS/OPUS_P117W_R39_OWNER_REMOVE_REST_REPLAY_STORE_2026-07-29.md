# OPUS P117W R39 — Supprimer le stockage REST replay non borné

Date : 2026-07-29  
Base OPUS owner : P117W R38, commit `913e9a821a28542c1de65f98d03bb2d63e82637f`  
Statut : correctif différentiel à appliquer, valider, committer et pousser exclusivement par l’owner.

## Cause

`Opus\\Api\\Rest\\RestReplayStore` écrit un fichier JSON par nonce sous :

```text
sites/owasys-back/var/rest/replay/
```

Aucune expiration ni purge ne borne ce stockage. Le répertoire grossit indéfiniment.

## Décision owner

- supprimer totalement `var/rest` ;
- supprimer `RestReplayStore.php` et `RestReplayStoreInterface.php` ;
- retirer `replay_store` de `backend.rest.json` ;
- retirer de `RestServer` toute création, consultation et écriture du store ;
- ne créer ni SQLite, ni cache, ni stockage de remplacement ;
- conserver l’authentification HMAC et `max_clock_skew_seconds = 60` ;
- conserver Logger et Profiler ;
- maintenir `owasys-back` exclusivement en PHP, sans JavaScript.

La suppression de la persistance anti-rejeu est explicite et assumée par l’owner. Le nonce reste obligatoire et signé ; la fraîcheur reste contrôlée par HMAC.

## Livrable différentiel

```text
opus_p117w_r39_remove_rest_replay_store.zip
SHA-256: 58600d6287b9f732ebd8e2afb577bd1edba69eccc05caec3dc50d24c4c2aaaac
Fichiers complets: 2
```

Fichiers remplacés :

```text
Opus/Api/Rest/RestServer.php
sites/owasys-back/config/backend.rest.json
```

Suppressions owner :

```text
Opus/Api/Rest/RestReplayStore.php
Opus/Api/Rest/RestReplayStoreInterface.php
sites/owasys-back/var/rest/
```

## Autorité Git

ChatGPT ne committe et ne pousse ni OPUS ni OWASYS. L’owner applique le ZIP sur `H:\\OPUS`, effectue les suppressions, valide, committe et pousse OPUS.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
