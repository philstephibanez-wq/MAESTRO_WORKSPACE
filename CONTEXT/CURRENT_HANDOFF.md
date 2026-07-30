# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-30

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R38_REMOVE_LAYERED_CREATION_AND_REGISTRY_SPLIT_BRAIN_2026-07-29.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R38_REMOVE_LAYERED_CREATION_2026-07-29.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R39_OWNER_REMOVE_REST_REPLAY_STORE_2026-07-29.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R39_OWNER_2026-07-29.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R40_OWNER_REMOVE_DEMO_OPUS_LAYERED_RESIDUE_2026-07-30.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R40_OWNER_REMOVE_DEMO_OPUS_2026-07-30.md
```

## Base restaurée

```text
MAESTRO_WORKSPACE P117W R38 : 7cf50b997d8c9f572bc40adb984b679018804c1b
OPUS owner R38 observé         : 913e9a821a28542c1de65f98d03bb2d63e82637f
```

Les onze commits workspace postérieurs qui mélangeaient rectifications, écritures OPUS indues et faux statut canonique R39 ont été retirés de `master`.

## R39 owner à appliquer

Supprimer la croissance infinie de `sites/owasys-back/var/rest/replay` :

- remplacer `RestServer.php` ;
- remplacer `backend.rest.json` ;
- supprimer `RestReplayStore.php` ;
- supprimer `RestReplayStoreInterface.php` ;
- supprimer `sites/owasys-back/var/rest` ;
- ne créer aucun SQLite, cache ou stockage de remplacement ;
- conserver HMAC, nonce signé, fenêtre de 60 secondes, Logger et Profiler ;
- conserver `owasys-back` exclusivement en PHP, sans JavaScript.

## Livrable

```text
opus_p117w_r39_remove_rest_replay_store.zip
SHA-256 : 58600d6287b9f732ebd8e2afb577bd1edba69eccc05caec3dc50d24c4c2aaaac
Fichiers complets : 2
Statut OPUS : à appliquer et pousser par l’owner
```

## Autorité

```text
Assistant : écrire MAESTRO_WORKSPACE et livrer le ZIP différentiel
Owner     : appliquer, valider, committer et pousser OPUS/OWASYS
```

Ne jamais demander à l’owner de tirer un commit OPUS produit par l’assistant.

## R40 owner — nettoyage layered restant

La cible prévue par le nettoyage R38 est maintenant identifiée sur GitHub :

```text
sites/demo-opus
```

Au HEAD OPUS owner R39
`d8e72130dbb932df6babd38fd3b0048fcd38405d`, c’est le seul site sous
`sites/*/config/site.json` portant `OPUS_SITE_LAYERED_CONTRACT_V2` ou
`application_layers`. Il bloque correctement `registry-sync`.

Décision :

- supprimer intégralement `sites/demo-opus` ;
- ne pas le migrer ;
- ne pas modifier le Registry pour l’ignorer ;
- valider puis committer et pousser exclusivement par l’owner ;
- aucun ZIP, car cette étape ne contient que des suppressions explicites.

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
TOUJOURS TRAITER LA CAUSE.
NO FALLBACK SILENCIEUX.
NO SHARED LAYER.
