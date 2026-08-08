# OPUS P117W R45C3 — STRUCTURED OWASYS WORKFLOW SEQUENCE

Date : 2026-08-08  
Statut : livrable owner à valider

## Source de vérité

OPUS `master` owner publié :

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

R45C2 est acquis : le retour owner confirme que `Visualiser le site` fonctionne et ouvre la prévisualisation attendue.

## Contrats appliqués

- `README-FIRST.md` ;
- `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md` ;
- `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md` ;
- `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`.

## Cause structurelle traitée

Le runtime publié conserve encore l'ancien ordre de navigation OWASYS :

```text
Applications
-> Structure
-> Sources de données
-> Workflows
-> Sécurité
-> Sources et Git
-> Construction et validation
```

De plus :

- la sélection d'une application entre directement dans `structure` ;
- après matérialisation d'une nouvelle application, la FSM passe directement à `build` ;
- `CreationController` redirige explicitement vers `build` après succès.

Ce comportement contredit le workflow contractuel acquis le 2026-08-08 : la sécurité cible est définie avant matérialisation dans le wizard, puis la construction commence par la BDD éventuelle, la structure, l'ACL CRUD, les workflows, le contenu et enfin la validation/build.

R45C3 traite cette cause dans la FSM OWASYS elle-même. Aucun site généré n'est patché.

## Workflow OWASYS cible R45C3

### Création

```text
Applications
-> Nouvelle application
-> mode frontend|backend|fullstack
-> sécurité cible : rôles/utilisateurs/provider
-> revue
-> matérialisation
-> Sources de données
```

### Construction après matérialisation ou sélection

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

`Sources de données` reste une étape éventuelle : aucune BDD n'est imposée à un site qui n'en a pas besoin.

`Sécurité` dans cette séquence concerne le référentiel du site cible et ses droits sur les ressources. L'administration des comptes/rôles OWASYS elle-même reste séparée et sera traitée en R45D, admin-only.

## Modification R45C3

### `sites/owasys-front/config/fsm.json`

- ordre de navigation : `registry=10`, `data=20`, `structure=30`, `security=40`, `workflows=50`, `source=60`, `build=70` ;
- `select_app` : `registry -> data` ;
- `application_created` : `creation -> data` ;
- projection Mermaid canonique :

```text
Applications -> Sources de données -> Structure -> Sécurité -> Workflows -> Sources et Git -> Construction et validation
```

- `open_data` reste une transition runtime wildcard mais n'ajoute plus une arête visuelle contradictoire ;
- les autres transitions wildcard conservent leur capacité d'accès direct autorisé.

### `sites/owasys-front/application/creation/controllers/CreationController.php`

Après création réussie :

```text
redirect build
```

est remplacé par :

```text
redirect data
```

La transition FSM et la redirection HTTP sont donc cohérentes.

## Livrable

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

Le script d'application :

- exige le HEAD exact R45C2 ;
- refuse des cibles déjà modifiées ;
- vérifie chaque ancre source exactement une fois avant écriture ;
- valide le JSON final ;
- ne committe et ne pousse rien.

## Fichiers cibles

```text
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
```

Aucun fichier `Opus/**/*.php` n'est modifié par R45C3.

## Commandes owner

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45c3_structured_workflow_sequence.zip"
php apply_opus_p117w_r45c3_structured_workflow_sequence.php
composer dump-autoload -o
php "%USERPROFILE%\Downloads\smoke_opus_p117w_r45c3_structured_workflow_sequence_owner.php"
```

Puis relancer les deux bastions OWASYS selon les commandes déjà contractuelles.

## Gates owner

1. HEAD exact `058984bfb0229bf5f27c74cd2b59c6614bf74b4e` ;
2. les deux cibles sont propres ;
3. application du ZIP -> `OPUS_P117W_R45C3_APPLIED` et `FILES=2` ;
4. `composer dump-autoload -o` OK ;
5. smoke -> `OPUS_P117W_R45C3_SMOKE_OK` ;
6. dans OWASYS, la navigation et le diagramme FSM affichent l'ordre `Applications -> Sources de données -> Structure -> Sécurité -> Workflows -> Sources et Git -> Construction et validation` ;
7. sélectionner une application existante ouvre `Sources de données` ;
8. créer une nouvelle application frontend/backend/fullstack puis confirmer : après matérialisation, OWASYS ouvre `Sources de données`, pas `Construction et validation` ;
9. l'accès direct aux autres modules autorisés reste possible via la FSM/ACL ;
10. `Visualiser le site` R45C2 reste fonctionnel depuis `Construction et validation` ;
11. aucune FSM du site généré n'est modifiée ni exécutée par la FSM OWASYS ;
12. aucun JavaScript n'est ajouté à `owasys-back` ;
13. commit/push OPUS exclusivement par l'owner après succès.

## Suite

Après acquisition R45C3 : R45D administration Sécurité/RBAC OWASYS admin-only, sans fusion avec les rôles/ACL des sites générés.

NO SITE-SPECIFIC PATCH.  
NO FSM MERGE.  
NO ROLE MERGE.  
NO ACL BYPASS.  
NO BACKEND JAVASCRIPT.  
NO OPUS PUSH BY ASSISTANT.
