# HANDOFF — OPUS P117W R45D2A1 CREATION SECURITY INPUTS

Date : 2026-08-09

## État GitHub OPUS observé

```text
4be105ebbc81b3164d7dcc26aa69ddd7400d2dd2  site: essai pour analyser la génération
e822848896734f92eb2fd631449e625a55aa8e08  opus_p117w_r45d2_controlled_security_mutations
af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121  opus_p117w_r45d1_security_snapshot_workspace
```

Le site `essai` est une preuve de génération fournie pour analyse, pas un composant à corriger localement.

## Incident bloquant

Le wizard de création autorise de saisir des paramètres sécurité contradictoires, puis les refuse :

```text
OWASYS_CREATION_LOGIN_PROVIDER_INVALID
```

Cas owner : authentification requise + page login + provider `session`.

Un second conflit est latent avec la valeur initiale `home_roles=everyone` lorsque l'authentification est activée.

## Décision

Traiter la cause dans le wizard OWASYS, sans relâcher `SiteScaffoldPlan`.

R45D2A1 rend les paramètres dérivés cohérents :

```text
login_page = authentication_required && provider == local-password
home_roles = everyone si public, sinon rôles déclarés
```

Le provider reste un choix explicite. Public + provider autre que `session` reste un rejet explicite.

La case indépendante `login_page` et le champ indépendant `home_roles` sont retirés du formulaire ; leurs valeurs calculées restent visibles dans le récapitulatif.

## Fichiers cibles

```text
sites/owasys-front/application/creation/controllers/CreationController.php
sites/owasys-front/application/creation/templates/index.score
```

Aucun fichier `Opus/**/*.php`, backend, site `essai`, catalogue I18n ou sécurité R45D2 n'est modifié.

## Validation hors runtime owner

```text
PHP lint controller        OK
public + session           OK
public + auth0             reject explicite
required + session         OK / no login
required + local-password  OK / login
required + auth0           OK / no login
SCORE if/endif balance     OK
new I18n keys              0
backend JS/Node delta      0
```

## Gate suivant

Owner applique le ZIP R45D2A1, relance `owasys-back` puis `owasys-front`, et teste les quatre combinaisons canoniques depuis une création neuve.

Après acquisition, reprendre la validation R45D2 des mutations de sécurité sur un site généré.

NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO SITE-SPECIFIC PATCH.
NO PUSH OPUS BY ASSISTANT.
