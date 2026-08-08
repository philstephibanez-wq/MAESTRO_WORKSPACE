# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-08

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45C3_STRUCTURED_WORKFLOW_SEQUENCE_2026-08-08.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45C3_STRUCTURED_WORKFLOW_SEQUENCE_2026-08-08.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte OPUS

OPUS `master` owner publié :

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

R45C2 est acquis.

## Retour owner R45C2

Le bouton `Visualiser le site` fonctionne désormais et la prévisualisation s'ouvre correctement.

Le correctif R45C2 est donc considéré acquis sur la base owner publiée ci-dessus.

## Livrable actif — R45C3

```text
ZIP     : opus_p117w_r45c3_structured_workflow_sequence.zip
SHA-256 : dfed4919c19c95fa055f01576369de621a35757290003629f753c997f2659399
SCRIPT  : apply_opus_p117w_r45c3_structured_workflow_sequence.php
SHA-256 : 690a5588462859142cce828b6a26d982ab016df867b69d4935c2b40b2893b982
BASE    : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
TARGETS : 2
OUTPUT  : OPUS_P117W_R45C3_APPLIED / FILES=2
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45c3_structured_workflow_sequence_owner.php
SHA-256 : 6b8cec5f07f1526ed3f676d014c6eef11af3d7a60fdafc86e9c854f0672accbf
OUTPUT  : OPUS_P117W_R45C3_SMOKE_OK / FILES=2
```

## Cause traitée R45C3

La FSM OWASYS publiée reste alignée sur un ancien ordre de construction et une création réussie saute directement vers `build`.

R45C3 rend la FSM OWASYS conforme au contrat acquis :

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

La création réussie et la sélection d'une application ouvrent `Sources de données`.

`Sources de données` est une étape éventuelle : aucune BDD n'est imposée.

La sécurité OWASYS et la sécurité du site généré restent strictement séparées.

## Cibles R45C3

```text
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
```

Aucune classe `Opus/**/*.php` n'est modifiée.

## Gates owner R45C3

1. HEAD exact `058984bfb0229bf5f27c74cd2b59c6614bf74b4e` ;
2. les deux cibles propres ;
3. appliquer ZIP ;
4. `OPUS_P117W_R45C3_APPLIED` + `FILES=2` ;
5. `composer dump-autoload -o` ;
6. smoke séparé -> `OPUS_P117W_R45C3_SMOKE_OK` ;
7. relancer OWASYS back/front ;
8. vérifier l'ordre des onglets et du diagramme FSM ;
9. sélectionner une application -> `Sources de données` ;
10. créer une application -> après matérialisation, `Sources de données` ;
11. vérifier que `Visualiser le site` R45C2 fonctionne toujours ;
12. vérifier qu'aucune FSM de site généré n'est couplée à la FSM OWASYS ;
13. commit/push OPUS uniquement par l'owner après succès.

## Suite

Après acquisition R45C3 : R45D administration Sécurité/RBAC OWASYS admin-only, distincte des rôles et ACL propres aux sites générés.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
