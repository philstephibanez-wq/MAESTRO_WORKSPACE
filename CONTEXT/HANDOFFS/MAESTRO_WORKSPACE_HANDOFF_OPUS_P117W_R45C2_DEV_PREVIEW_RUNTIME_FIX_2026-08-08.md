# HANDOFF — OPUS P117W R45C2 DEV PREVIEW RUNTIME FIX

Date : 2026-08-08

## Base OPUS acquise

```text
5770a144ed6524de5462eaae780cccc5b1aa8a47
opus_p117w_r45c1_dev_preview_button
```

R45C1 est publié par l'owner.

## Retour owner R45C1

Dans `OWASYS -> Construction et validation`, application courante `OPUS test` (`sites/test`, `fullstack`) :

- bouton `Visualiser le site` présent ;
- clic -> message `Le serveur de développement n’a pas pu être démarré.` ;
- aucun nouvel onglet.

## Analyse

Défauts R45C1 confirmés dans la source publiée :

1. le framework background Windows passe par `cmd.exe /C start /B` ;
2. stdout/stderr du serveur sont envoyés vers `NUL` ;
3. le contrôleur Build capture tout `Throwable` et remplace la cause par `build.preview_failed` ;
4. le formulaire POST reste dans l'onglet courant et n'effectue aucune redirection directe vers le site.

Le site `test` n'est pas corrigé localement. Il est un site généré `fullstack` et constitue uniquement le cas d'intégration owner.

## R45C2 livré

```text
ZIP     : opus_p117w_r45c2_dev_preview_runtime_fix.zip
SHA-256 : 4ce81c7f0847daa144a53d2437380d5f0c1d5fac7ac3d77b10952665173e2042
SCRIPT  : apply_opus_p117w_r45c2_dev_preview_runtime_fix.php
SHA-256 : c8a160bfb03734968bd3c3b4c5ec1e048a6557796e4e827d9d2a4444ffe8306f
BASE    : 5770a144ed6524de5462eaae780cccc5b1aa8a47
TARGETS : 3
OUTPUT  : OPUS_P117W_R45C2_APPLIED / FILES=3
```

Smoke séparé :

```text
smoke_opus_p117w_r45c2_dev_preview_runtime_fix_owner.php
SHA-256 : 32c75c0aa36eb62e884f940df159d58ebae1b8ee6b594504226d3d843df70a54
OUTPUT  : OPUS_P117W_R45C2_SMOKE_OK
```

## Cibles

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/application/default/controllers/RuntimeController.php
sites/owasys-front/application/build/templates/index.score
```

## Contrat R45C2

- lancement direct `PHP_BINARY -S`, sans shell detour ;
- port local auto 8000..8999 conservé ;
- PID contrôlé et renvoyé ;
- `var/logs/dev-server.process.log` remis à zéro puis alimenté par le process PHP ;
- sortie prématurée -> `OPUS_DEV_SERVER_BACKGROUND_EXITED:<code>` ;
- aucun fallback silencieux Build ;
- formulaire SCORE `target=_blank` + `rel=noopener` ;
- après transition FSM OWASYS réussie, HTTP 303 vers l'URL locale strictement validée ;
- aucun JavaScript ;
- aucune modification de la FSM du site généré.

## Contrat FSM acquis

Workspace :

`CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`

Séparation :

```text
FSM OWASYS = navigation + guards sécurité + métier de construction des sites
FSM SITE   = pages/navigation + guards sécurité + métier propre au site
```

## Validation owner

1. appliquer R45C2 sur le HEAD exact R45C1 ;
2. `composer dump-autoload -o` ;
3. smoke -> `OPUS_P117W_R45C2_SMOKE_OK` ;
4. relancer owasys-back et owasys-front ;
5. sélectionner `test` ;
6. Construction et validation -> `Visualiser le site` ;
7. vérifier qu'un nouvel onglet s'ouvre directement sur le site ;
8. vérifier que le site exécute sa propre FSM ;
9. en cas d'échec, relever le code exact affiché et `sites/test/var/logs/dev-server.process.log` ;
10. commit/push OPUS uniquement après réussite.

## Suite après acquisition

Reprendre le workflow OWASYS R45C structuré selon le contrat FSM/workflow, notamment l'ordre :

```text
login -> application/mode -> sécurité cible -> génération -> BDD éventuelle -> pages/API + CRUD -> workflows site -> contenu -> validation/prévisualisation
```

Puis administration Sécurité/RBAC admin-only.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO FSM MERGE.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
