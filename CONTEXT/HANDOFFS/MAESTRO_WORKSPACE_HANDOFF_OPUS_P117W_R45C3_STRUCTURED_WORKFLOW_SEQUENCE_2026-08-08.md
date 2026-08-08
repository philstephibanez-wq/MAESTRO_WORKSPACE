# MAESTRO WORKSPACE HANDOFF — OPUS P117W R45C3 STRUCTURED WORKFLOW SEQUENCE

Date : 2026-08-08

## Base owner acquise

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

Retour owner : R45C2 fonctionne. La prévisualisation du site est acquise.

## Livrable actif

```text
ZIP     : opus_p117w_r45c3_structured_workflow_sequence.zip
SHA-256 : dfed4919c19c95fa055f01576369de621a35757290003629f753c997f2659399
SCRIPT  : apply_opus_p117w_r45c3_structured_workflow_sequence.php
SHA-256 : 690a5588462859142cce828b6a26d982ab016df867b69d4935c2b40b2893b982
BASE    : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
TARGETS : 2
OUTPUT  : OPUS_P117W_R45C3_APPLIED / FILES=2
```

Smoke séparé :

```text
smoke_opus_p117w_r45c3_structured_workflow_sequence_owner.php
SHA-256 : 6b8cec5f07f1526ed3f676d014c6eef11af3d7a60fdafc86e9c854f0672accbf
OUTPUT  : OPUS_P117W_R45C3_SMOKE_OK / FILES=2
```

## Cause traitée

La FSM OWASYS publiée reste dans l'ancien ordre :

```text
Applications -> Structure -> Sources de données -> Workflows -> Sécurité -> Sources et Git -> Construction et validation
```

et une création réussie saute directement à `build`.

R45C3 rend la FSM OWASYS conforme au contrat de construction :

```text
Applications -> Sources de données -> Structure -> Sécurité -> Workflows -> Sources et Git -> Construction et validation
```

La création réussie et la sélection d'une application ouvrent `Sources de données`.

## Cibles

```text
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
```

Aucune classe `Opus/**/*.php` n'est modifiée.

## Validation owner

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45c3_structured_workflow_sequence.zip"
php apply_opus_p117w_r45c3_structured_workflow_sequence.php
composer dump-autoload -o
php "%USERPROFILE%\Downloads\smoke_opus_p117w_r45c3_structured_workflow_sequence_owner.php"
```

Puis relancer OWASYS back/front et vérifier :

- ordre des onglets et du diagramme FSM ;
- sélection application -> `Sources de données` ;
- création application -> `Sources de données` ;
- accès direct aux modules toujours soumis FSM/ACL ;
- `Visualiser le site` toujours fonctionnel ;
- aucune modification de la FSM du site généré.

## Suite

Après acquisition R45C3 : R45D administration Sécurité/RBAC OWASYS admin-only, distincte de la sécurité propre aux sites générés.

NO SITE-SPECIFIC PATCH.  
NO FSM MERGE.  
NO ROLE MERGE.  
NO ACL BYPASS.  
NO BACKEND JAVASCRIPT.  
NO OPUS PUSH BY ASSISTANT.
