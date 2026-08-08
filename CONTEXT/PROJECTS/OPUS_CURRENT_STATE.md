# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-08.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 5770a144ed6524de5462eaae780cccc5b1aa8a47
Commit HEAD : opus_p117w_r45c1_dev_preview_button
R45B6 publié : 6b3665c4c26c8bee8791a2bf80d3e4be4abe4b9a
Livrable actif : R45C2 dev preview runtime fix
```

## Acquisition R45C1

R45C1 est publié par l'owner au commit :

```text
5770a144ed6524de5462eaae780cccc5b1aa8a47
```

Il ajoute dans `Construction et validation` un bouton `Visualiser le site` passant par le flux OWASYS contractuel jusqu'à `opus:dev-server --background --auto-port`.

## Retour owner R45C1

Cas réel publié :

```text
sites/test
site_name : OPUS test
profile : fullstack
```

Le bouton apparaît mais le serveur ne démarre pas et aucun nouvel onglet ne s'ouvre.

## Audit R45C1

La source publiée montre quatre défauts :

1. `SiteCommandService::startBackgroundDevelopmentServer()` utilise sous Windows `cmd.exe /C start /B` au lieu de lancer directement le serveur PHP connu du framework ;
2. stdout/stderr du serveur sont envoyés vers `NUL`, supprimant le diagnostic runtime ;
3. le contrôleur OWASYS Build capture tout `Throwable` et le remplace par `build.preview_failed` ;
4. le POST reste dans l'onglet courant et ne redirige pas directement vers l'URL du site.

Le site `test` n'est pas modifié localement. Le correctif reste générique OPUS/OWASYS.

## Livrable actif R45C2

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

## R45C2 — comportement cible

Framework :

- lancement direct `PHP_BINARY -S` via `proc_open` ;
- aucun shell Windows/Unix intermédiaire ;
- port local auto conservé ;
- PID contrôlé et renvoyé ;
- stdout/stderr -> `sites/<site>/var/logs/dev-server.process.log` ;
- log remis à zéro à chaque lancement ;
- sortie prématurée explicitement remontée ;
- CLI historique sans `--background` conservée.

OWASYS :

- front -> REST sécurisé -> back -> Composer -> service OPUS conservé ;
- aucune exception technique convertie silencieusement en message générique ;
- formulaire SCORE `target=_blank`, sans JavaScript ;
- après transition FSM OWASYS, HTTP 303 vers une URL locale strictement validée ;
- viewer ne reçoit pas la capacité `build:preview` ;
- backend-only ne reçoit pas le bouton.

## Contrat FSM / workflow

Contrat :

`CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`

Séparation obligatoire :

```text
FSM OWASYS = navigation + sécurité + workflow de construction des sites
FSM SITE = pages/navigation + sécurité + métier propre au site
```

OWASYS ne fusionne jamais sa FSM, ses rôles ou son ACL avec ceux du site généré.

Workflow OWASYS cible :

```text
1 login
2 ouvrir/définir application + mode frontend/backend/fullstack
3 définir rôles/utilisateurs de la cible
4 matérialiser/générer
5 BDD éventuelle
6 pages/routes/API + droits CRUD
7 workflows métier du site
8 contenu SCORE + données
9 validation / Git / build / preview / export
```

## Prévalidation assistant R45C2

- base distante exacte identifiée ;
- ZIP différentiel : un script uniquement ;
- 3 fichiers OPUS/OWASYS cibles ;
- apply script `php -l` OK ;
- smoke `php -l` OK ;
- smoke inclut audit exhaustif des interfaces homonymes OPUS ;
- lancement direct PHP validé conceptuellement sur environnement local Linux ;
- validation Windows owner obligatoire avant conformité finale.

## Suite gouvernée

1. acquisition owner R45C2 ;
2. reprise R45C workflow OWASYS structuré selon le nouveau contrat ;
3. administration Sécurité/RBAC réservée à admin ;
4. poursuite pages/API/BDD/CRUD/workflows métier selon profil du site.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO FSM MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
