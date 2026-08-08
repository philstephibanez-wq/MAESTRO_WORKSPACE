# HANDOFF — OPUS P117W R45C1 — OWASYS development preview

Date : 2026-08-08

## Source de vérité

Lire d'abord :

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B6_PERMISSION_SURFACE_CONSISTENCY_2026-08-07.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45C1_OWASYS_DEV_PREVIEW_BUTTON_2026-08-08.md`

## Base exacte OPUS

```text
6b3665c4c26c8bee8791a2bf80d3e4be4abe4b9a
opus_p117w_r45b6_permission_surface_consistency
```

R45B6 est publié sur `OPUS/master`. R45C1 est le prochain différentiel owner.

## Décision FSM

Ne jamais confondre les deux domaines :

- **FSM OWASYS** = navigation + guards de sécurité + workflow métier OWASYS de construction/administration des applications OPUS.
- **FSM du site généré** = navigation/pages + guards ACL + workflow métier du site.

Le bouton de prévisualisation appartient à l'outillage OWASYS `build`. Il ne modifie jamais la FSM du site.

## Livrable R45C1

```text
ZIP     : opus_p117w_r45c1_dev_preview_button.zip
SHA-256 : 6a44ee4c21734a0d1c003776aa39377fe9d367f1ea542c4de15b61c2203b95c0
SCRIPT  : apply_opus_p117w_r45c1_dev_preview_button.php
SHA-256 : 0218fdc8aa8e54e992cb8a9b0a61c5eb7df4f681f284871c8e06dca2b2dbf049
SMOKE   : smoke_opus_p117w_r45c1_dev_preview_button_owner.php
SHA-256 : 229c16f77cf63812dadd78cdf4db8c85f05f88a57d2c808ee0adec84ac91251f
```

Le ZIP contient uniquement le script différentiel. Le smoke est séparé.

R45C1 modifie 9 fichiers tracked et crée 26 fichiers, soit 35 cibles : évolution générique `opus:dev-server`, route REST/operation Composer OWASYS, vraie page SCORE Build, et 25 catalogues I18n de base UE + ukrainien.

## Contrat du bouton

`Construction et validation` expose `Visualiser le site` uniquement pour une application `frontend` ou `fullstack` et un acteur `admin` ou `developer`.

Flux :

```text
SCORE
-> OWASYS front POST
-> ACL build:preview
-> REST sécurisé
-> OWASYS back
-> Composer allow-listé opus:dev-server
-> OPUS --background --auto-port
-> résultat structuré URL
-> SCORE
```

Le rôle `viewer` ne voit pas le bouton. Une application `backend` pure n'a pas de prévisualisation visuelle.

## Dev server

L'évolution OPUS conserve le mode CLI existant lorsque les nouveaux flags sont absents.

Pour OWASYS :

```text
--background
--auto-port
```

imposent un lancement local loopback, choisissent un port libre 8000..8999 et retournent `OPUS_CONSOLE_DEV_SERVER_START_RESULT_V1` sans bloquer la requête REST.

## Gates owner

1. HEAD `6b3665c4c26c8bee8791a2bf80d3e4be4abe4b9a`.
2. Cibles propres.
3. Appliquer R45C1.
4. Attendre `OPUS_P117W_R45C1_APPLIED` + `FILES=35`.
5. `composer dump-autoload -o`.
6. Smoke -> `OPUS_P117W_R45C1_SMOKE_OK`.
7. Relancer owasys-back puis owasys-front.
8. Frontend/fullstack + admin/developer : bouton visible.
9. Viewer : bouton absent.
10. Backend-only : bouton absent.
11. Cliquer : serveur local réellement prêt, URL affichée.
12. Ouvrir URL : runtime/FSM du site généré, pas FSM OWASYS.
13. Owner seulement commit/push OPUS après succès.

## Suite métier OWASYS

Le workflow de construction à formaliser ensuite reste :

```text
login
-> ouvrir/définir application + mode
-> sécurité cible (admin OWASYS seulement pour administration utilisateurs/rôles)
-> matérialisation site
-> BDD éventuelle
-> pages/API + ACL CRUD
-> workflows métier du site
-> contenu / liaisons données
-> validation / Git / build / preview / export
```

NO SITE FSM COUPLING.
NO FRONT SHELL.
NO DIRECT FRONT COMPOSER.
NO PRODUCTION DEV SERVER.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
