# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-09.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 4be105ebbc81b3164d7dcc26aa69ddd7400d2dd2
Commit : site: essai pour analyser la génération
```

Historique immédiat :

```text
4be105ebbc81b3164d7dcc26aa69ddd7400d2dd2  site: essai pour analyser la génération
e822848896734f92eb2fd631449e625a55aa8e08  opus_p117w_r45d2_controlled_security_mutations
af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121  opus_p117w_r45d1_security_snapshot_workspace
730f19032a5b69c66c14d4d4401813e0638353d1  opus_p117w_r45c3r1_github_recovery_structured_workflow
```

`sites/essai` est un site généré diagnostique fourni par l'owner. Il n'est pas une base de correctif spécifique.

## États acquis / publiés

R45C3R1 : workflow OWASYS structuré acquis.

R45D1 : workspace Sécurité réel publié et preuve runtime reçue.

R45D2 : mutations contrôlées publiées sous `e822848...`. Le screenshot owner montre la surface de mutation sur le site généré `essai`, mais preview/commit, contrôle de concurrence et audit complet restent à valider.

## Site `essai` observé

Le site généré sur GitHub déclare :

```text
profile = fullstack
authentication_required = false
login_page = false
provider = session
roles = admin
home_roles = everyone
initial identity = steve
```

Le workspace Sécurité le lit correctement sous les contrats générés ACL/SSO.

## Défaut courant — wizard création sécurité

Le screenshot owner reproduit :

```text
OWASYS_CREATION_LOGIN_PROVIDER_INVALID
```

avec :

```text
authentication_required = true
login_page = true
provider = session
```

Cause : `CreationController` et son template exposent `authentication_required`, `login_page`, `provider` et `home_roles` comme saisies indépendantes alors que le scaffold OPUS les protège par des invariants croisés.

La valeur initiale `home_roles=everyone` crée également un conflit dès que l'authentification est activée.

Le scaffold OPUS n'est pas à relâcher : ses gardes sont correctes.

## Livrable actif — R45D2A1

```text
ZIP     : opus_p117w_r45d2a1_creation_security_input_canonicalization.zip
SHA-256 : 3827223744bd55a2fe0ef9060cd4783cbaa800c06d1cdbddd289b1ddb385239f
BASE    : 4be105ebbc81b3164d7dcc26aa69ddd7400d2dd2
FILES   : 2
```

R45D2A1 modifie uniquement :

```text
sites/owasys-front/application/creation/controllers/CreationController.php
sites/owasys-front/application/creation/templates/index.score
```

Matrice canonique :

```text
public + session       -> auth=false, login=false, home=everyone
auth + session         -> auth=true,  login=false, home=roles
auth + local-password  -> auth=true,  login=true,  home=roles
auth + auth0-proxy     -> auth=true,  login=false, home=roles
```

Public + `local-password|auth0-proxy` reste refusé explicitement.

La page login n'est plus un booléen indépendant : elle est générée pour `local-password` authentifié. Les rôles d'accueil sont dérivés de l'exposition et restent affichés dans le récapitulatif.

## Validation statique R45D2A1

```text
PHP lint controller        OK
securityDraft matrix       OK
public + auth0             rejet explicite
SCORE if/endif             équilibré
new I18n keys              0
Opus/**/*.php delta        0
backend delta              0
```

## Suite après gate owner

1. valider les quatre cas de création canoniques ;
2. confirmer une création réelle et contrôler le blueprint ;
3. reprendre la validation R45D2 preview/commit ;
4. poursuivre ensuite les mutations de sécurité restantes selon le contrat RBAC.

## Profiler `.lock`

Audit OPUS générique séparé. Aucun nettoyage aveugle.

NO VALIDATOR RELAXATION.
NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
