# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-09

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_INCIDENT_OPUS_P117W_R45C3_R45C4_DELIVERY_INVALID_2026-08-09.md`
6. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Source de vérité publiée

OPUS `master` GitHub publie toujours :

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

R45C2 reste le dernier état acquis publié.

## État owner local

Le retour owner du 2026-08-09 montre :

```text
HEAD local = 0e0e54857214144d6c98ebec85cf9eee007676a0
```

Ce commit n'est pas résolvable sur GitHub au moment de la relecture.

Le front OWASYS renvoie HTTP 500 sur :

```text
http://127.0.0.1:8000/fr-FR/applications
```

## R45C3 / R45C4

R45C3 n'est pas acquis : la projection FSM est visible, mais la validation runtime complète n'a pas abouti.

R45C4 est retiré et ne doit plus être utilisé.

Les deux livraisons précédentes étaient non conformes au format imposé par `README-FIRST.md` : elles reposaient sur des scripts `apply_*` au lieu de ZIP différentiels contenant uniquement les fichiers complets à leurs chemins finaux.

R45C4 avait en plus une garde de HEAD obsolète par rapport au HEAD owner local et un smoke séparé invoqué sans garantie de présence.

## Blocage avant prochain livrable

```text
NO SOURCE OF TRUTH, NO PATCH.
```

La source owner live correspondant au HEAD `0e0e548...` doit être relue avant toute nouvelle correction OPUS/OWASYS.

Fichiers minimaux à obtenir :

```text
Opus/Api/Rest/RestClient.php
Opus/Api/Rest/RestClientInterface.php
sites/owasys-front/config/rest-api.json
sites/owasys-front/config/site.json
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
sites/owasys-front/application/registry/models/RegistryModel.php
sites/owasys-front/application/default/controllers/RuntimeController.php
sites/owasys-back/config/site.json
```

## Règle de prochain livrable

Le prochain ZIP différentiel :

- contient uniquement les fichiers complets modifiés à leurs chemins finaux ;
- ne contient aucun script `apply_*`, smoke, rapport, log ou temporaire ;
- est construit uniquement après relecture des fichiers owner live ;
- est validé avec les deux applications OWASYS dans leur état de runtime réel ;
- n'est jamais poussé dans OPUS par l'assistant.

## Suite

1. récupérer la source live owner exacte ;
2. diagnostiquer le HTTP 500 et la frontière REST sur cette source ;
3. livrer un ZIP différentiel direct conforme ;
4. valider runtime front + back ;
5. seulement après acquisition, reprendre R45D Sécurité/RBAC.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
