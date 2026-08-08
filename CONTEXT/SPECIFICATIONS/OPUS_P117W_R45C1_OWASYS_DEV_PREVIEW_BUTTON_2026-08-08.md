# OPUS P117W R45C1 — OWASYS development preview button

Date : 2026-08-08
Statut : livrable owner à valider
Base OPUS : `6b3665c4c26c8bee8791a2bf80d3e4be4abe4b9a`

## Gouvernance

Appliquer intégralement `README-FIRST.md`, les règles globales MAESTRO/OPUS/OWASYS et `OPUS_SITE_STANDARD_CONTRACT`.

## Séparation FSM contractuelle

Il existe deux domaines FSM distincts :

1. **FSM OWASYS** : navigation, guards de sécurité et métier propre d'OWASYS, à savoir la construction et l'administration des applications OPUS.
2. **FSM de chaque site généré** : navigation des pages, guards ACL du site et workflow métier propre à ce site.

OWASYS peut créer, éditer, visualiser et valider la FSM d'un site, mais ne l'exécute jamais à la place du site au runtime.

Le lancement d'une prévisualisation est une action/outillage de l'état OWASYS `build`; il ne crée aucun état ni transition dans la FSM du site généré.

## Besoin

Depuis `Construction et validation`, un utilisateur OWASYS autorisé doit pouvoir cliquer sur **Visualiser le site**.

Le bouton :

- est disponible uniquement à `admin` et `developer` via `build:preview` (admin `*:*`, developer `build:*` existants) ;
- n'est pas proposé au rôle `viewer` ;
- n'est pas proposé pour une application `backend` pure ;
- ne lance aucun shell, PHP ni Composer directement depuis le frontend ;
- conserve le rendu SCORE et l'I18n.

## Flux obligatoire

```text
SCORE Build
-> POST OWASYS front
-> ACL build:preview
-> REST sécurisé
-> POST /api/v1/applications/{site_id}/development-server
-> opération site.dev-server.start
-> Composer allow-listé opus:dev-server
-> OPUS dev:server --background --auto-port
-> serveur PHP local de développement
-> résultat structuré + URL
-> OWASYS Build ViewModel
-> SCORE
```

## Évolution générique OPUS

Le `dev:server` existant est bloquant et retourne actuellement un `int`. Il ne peut donc pas servir directement une requête REST qui doit rendre la main au navigateur.

R45C1 ajoute deux options génériques :

```text
--background
--auto-port
```

Sans ces options, le comportement CLI historique reste bloquant et inchangé.

Avec `--background --auto-port` :

- le serveur est lancé détaché ;
- le host est imposé à `127.0.0.1` ;
- un port libre est choisi entre 8000 et 8999 ;
- les variables d'environnement du site cible sont recalculées après choix du port ;
- aucun port OWASYS hérité n'est réutilisé ;
- la commande attend brièvement que le socket soit réellement ouvert ;
- le résultat est : `OPUS_CONSOLE_DEV_SERVER_START_RESULT_V1` avec `application_id`, `host`, `port`, `url`, `background=true`, `started=true`.

Le lancement détaché est Windows/Linux et reste strictement local au poste de développement.

## REST

Nouvelle ressource identique dans les trois catalogues front/back/inline :

```text
POST /api/v1/applications/{site_id}/development-server
operation: site.dev-server.start
parameters: background=true, auto_port=true
success_status: 200
```

Nouvelle opération Composer :

```text
site.dev-server.start
composer_script: opus:dev-server
roles: admin, developer
arguments: site_id, --background, --auto-port
```

## SCORE / I18n

`application/build/templates/index.score` devient une vraie page au lieu du fallback `pending.score`.

Le bouton et son erreur sont localisés dans les 25 langues de base UE + ukrainien. Les variantes régionales héritent par le contrat I18n existant `explicit-empty-overlay-inherits-base-language`.

## Livrable

```text
ZIP     : opus_p117w_r45c1_dev_preview_button.zip
SHA-256 : 6a44ee4c21734a0d1c003776aa39377fe9d367f1ea542c4de15b61c2203b95c0
SCRIPT  : apply_opus_p117w_r45c1_dev_preview_button.php
SHA-256 : 0218fdc8aa8e54e992cb8a9b0a61c5eb7df4f681f284871c8e06dca2b2dbf049
SMOKE   : smoke_opus_p117w_r45c1_dev_preview_button_owner.php
SHA-256 : 229c16f77cf63812dadd78cdf4db8c85f05f88a57d2c808ee0adec84ac91251f
```

Le ZIP ne contient que le script différentiel. Le smoke owner reste séparé.

## Gates owner

1. HEAD exact `6b3665c4c26c8bee8791a2bf80d3e4be4abe4b9a`.
2. Cibles tracked propres.
3. Application du ZIP.
4. `OPUS_P117W_R45C1_APPLIED`.
5. `composer dump-autoload -o`.
6. Smoke -> `OPUS_P117W_R45C1_SMOKE_OK`.
7. Relancer OWASYS back/front.
8. Sélectionner une application frontend/fullstack générée.
9. Ouvrir `Construction et validation`.
10. Admin/developer : bouton `Visualiser le site` visible.
11. Viewer : bouton absent.
12. Cliquer : serveur dev démarré sur loopback/port libre et URL affichée.
13. Ouvrir l'URL : le site généré répond avec sa propre FSM/runtime.
14. Aucun commit/push OPUS avant ces gates.

NO SITE FSM COUPLING.
NO FRONT SHELL.
NO DIRECT FRONT COMPOSER.
NO PRODUCTION DEV SERVER.
NO BACKEND JAVASCRIPT.
