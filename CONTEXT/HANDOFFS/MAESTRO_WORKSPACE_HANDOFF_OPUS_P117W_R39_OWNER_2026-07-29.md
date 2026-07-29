# MAESTRO WORKSPACE — Handoff OPUS P117W R39 owner

Date : 2026-07-29

## Base confirmée

```text
Workspace restauré : P117W R38
Workspace SHA de base : 7cf50b997d8c9f572bc40adb984b679018804c1b
OPUS owner R38 : 913e9a821a28542c1de65f98d03bb2d63e82637f
```

## Correctif demandé

Supprimer le stockage replay fichier non borné de `owasys-back` sans mécanisme de remplacement.

Conserver :

- HMAC et fenêtre temporelle de 60 secondes ;
- nonce signé obligatoire ;
- Logger et Profiler ;
- backend PHP pur ;
- flux `owasys-front -> REST sécurisé -> owasys-back -> Composer`.

Supprimer :

- `RestReplayStore` et son interface ;
- `replay_store` dans la configuration ;
- toute lecture et écriture sous `var/rest` ;
- le répertoire runtime `sites/owasys-back/var/rest`.

Interdire SQLite, cache ou autre stockage substitutif.

## Livrable

```text
opus_p117w_r39_remove_rest_replay_store.zip
SHA-256: 58600d6287b9f732ebd8e2afb577bd1edba69eccc05caec3dc50d24c4c2aaaac
```

## Responsabilités

```text
ChatGPT : MAESTRO_WORKSPACE + ZIP différentiel uniquement
Owner    : appliquer, valider, committer et pousser OPUS/OWASYS
```

Le workspace ne doit pas déclarer R39 présent sur OPUS tant que l’owner n’a pas fourni le SHA de son push.
