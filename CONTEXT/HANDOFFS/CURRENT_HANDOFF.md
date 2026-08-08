# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-08

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45C2_DEV_PREVIEW_RUNTIME_FIX_2026-08-08.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45C2_DEV_PREVIEW_RUNTIME_FIX_2026-08-08.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte OPUS

OPUS `master` owner publié :

```text
5770a144ed6524de5462eaae780cccc5b1aa8a47
opus_p117w_r45c1_dev_preview_button
```

R45B6 est acquis au commit précédent `6b3665c4c26c8bee8791a2bf80d3e4be4abe4b9a`.
R45C1 est acquis et constitue la base exacte du correctif R45C2.

## Retour owner R45C1

Application courante :

```text
site_id : test
site_name : OPUS test
profile : fullstack
```

Dans `Construction et validation`, le bouton `Visualiser le site` est présent mais :

```text
Le serveur de développement n’a pas pu être démarré.
```

Aucun nouvel onglet n'est ouvert.

## Cause R45C1 traitée dans R45C2

La source publiée confirme :

- lancement Windows background via `cmd.exe /C start /B` ;
- stdout/stderr du serveur jetés vers `NUL` ;
- erreur du flux Build capturée par un `catch (Throwable)` puis réduite à `build.preview_failed` ;
- POST dans l'onglet courant, suivi seulement d'un éventuel second lien.

R45C2 supprime le détour shell, conserve les diagnostics runtime, refuse le fallback silencieux et transforme le clic SCORE en nouvel onglet + HTTP 303 vers le site local validé.

## Livrable actif — R45C2

```text
ZIP     : opus_p117w_r45c2_dev_preview_runtime_fix.zip
SHA-256 : 4ce81c7f0847daa144a53d2437380d5f0c1d5fac7ac3d77b10952665173e2042
SCRIPT  : apply_opus_p117w_r45c2_dev_preview_runtime_fix.php
SHA-256 : c8a160bfb03734968bd3c3b4c5ec1e048a6557796e4e827d9d2a4444ffe8306f
BASE    : 5770a144ed6524de5462eaae780cccc5b1aa8a47
TARGETS : 3
OUTPUT  : OPUS_P117W_R45C2_APPLIED / FILES=3
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45c2_dev_preview_runtime_fix_owner.php
SHA-256 : 32c75c0aa36eb62e884f940df159d58ebae1b8ee6b594504226d3d843df70a54
OUTPUT  : OPUS_P117W_R45C2_SMOKE_OK
```

## Contrat FSM / workflow acquis

Deux FSM indépendantes :

```text
FSM OWASYS
= navigation OWASYS
+ guards sécurité OWASYS
+ métier OWASYS de construction des sites

FSM SITE GÉNÉRÉ
= pages/navigation du site
+ guards sécurité du site
+ workflow métier du site
```

OWASYS édite/valide la FSM du site comme ressource mais ne l'exécute jamais comme sa propre FSM.

Workflow de construction OWASYS cible :

```text
login
-> application existante/nouvelle + mode frontend|backend|fullstack
-> sécurité cible : rôles/utilisateurs
-> matérialisation du site
-> BDD éventuelle
-> pages/routes/API + ACL CRUD
-> workflows métier du site
-> contenu SCORE + liaisons données
-> validation / Git / build / preview / export
```

L'administration des utilisateurs et rôles OWASYS reste admin-only.

## Gates owner R45C2

1. HEAD exact `5770a144...` ;
2. trois cibles propres ;
3. appliquer ZIP ;
4. `OPUS_P117W_R45C2_APPLIED` + `FILES=3` ;
5. `composer dump-autoload -o` ;
6. smoke séparé -> `OPUS_P117W_R45C2_SMOKE_OK` ;
7. relancer OWASYS back/front ;
8. sélectionner `test` ;
9. cliquer `Visualiser le site` ;
10. nouvel onglet direct sur le site attendu ;
11. le site doit exécuter sa propre FSM ;
12. en cas d'échec, relever le code exact et `sites/test/var/logs/dev-server.process.log` ;
13. commit/push OPUS uniquement par l'owner après succès.

## Suite

Après acquisition R45C2 : reprendre R45C workflow OWASYS structuré selon le contrat ci-dessus, puis administration Sécurité/RBAC admin-only.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO FSM MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
