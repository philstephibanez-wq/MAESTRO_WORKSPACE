# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-09

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2_CONTROLLED_SECURITY_MUTATIONS_2026-08-09.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A1_CREATION_SECURITY_INPUT_CANONICALIZATION_2026-08-09.md`
8. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A1_CREATION_SECURITY_INPUTS_2026-08-09.md`
9. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
4be105ebbc81b3164d7dcc26aa69ddd7400d2dd2  site: essai pour analyser la génération
e822848896734f92eb2fd631449e625a55aa8e08  opus_p117w_r45d2_controlled_security_mutations
af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121  opus_p117w_r45d1_security_snapshot_workspace
```

R45D2 est donc publié. `4be105...` ajoute le site diagnostique `essai` fourni par l'owner.

## Preuves runtime reçues

R45D1 : le workspace `Sécurité` réel est rendu sur `owasys-back`, en lecture seule, avec ACL/SSO réels.

R45D2 : le site généré `essai` est visible dans le workspace sécurité, avec cible `fullstack`, `OPUS_GENERATED_APPLICATION_ACL_V1`, `OPUS_GENERATED_APPLICATION_SSO_V1`, identité `steve` issue de `security.onboarding` et surface de mutations contrôlées.

La preview/commit complète R45D2 reste à valider.

## Incident création authentifiée

Le screenshot owner montre :

```text
OWASYS_CREATION_LOGIN_PROVIDER_INVALID
```

avec `authentication_required=true`, `login_page=true`, `provider=session`.

Cause confirmée : le formulaire OWASYS exposait indépendamment des paramètres que `SiteScaffoldPlan` exige cohérents. Le défaut est dans la projection du wizard, pas dans REST/Composer/scaffold.

Le même formulaire conservait `home_roles=everyone` lors de l'activation de l'authentification, créant un deuxième conflit latent.

## Livrable actif — R45D2A1

```text
ZIP     : opus_p117w_r45d2a1_creation_security_input_canonicalization.zip
SHA-256 : 3827223744bd55a2fe0ef9060cd4783cbaa800c06d1cdbddd289b1ddb385239f
BASE    : 4be105ebbc81b3164d7dcc26aa69ddd7400d2dd2
FILES   : 2
```

Fichiers :

```text
sites/owasys-front/application/creation/controllers/CreationController.php
sites/owasys-front/application/creation/templates/index.score
```

R45D2A1 ne relâche aucune garde OPUS. Le wizard produit les combinaisons canoniques :

```text
public + session       -> auth=false, login=false, home=everyone
auth + session         -> auth=true,  login=false, home=roles
auth + local-password  -> auth=true,  login=true,  home=roles
auth + auth0-proxy     -> auth=true,  login=false, home=roles
```

Public + provider autre que `session` reste rejeté explicitement : aucun fallback silencieux.

La case indépendante `Créer une page de connexion` est supprimée : `local-password` authentifié implique explicitement la page login. Le champ `home_roles` initial est également supprimé et calculé selon l'exposition ; sa valeur reste visible dans le récapitulatif.

Aucune classe `Opus/**/*.php`, aucun backend, aucun fichier de `sites/essai` et aucune logique R45D2 de mutation ne sont modifiés.

## Validation statique R45D2A1

```text
PHP lint controller        OK
public + session           OK
public + auth0             rejet explicite
auth + session             OK / no login
auth + local-password      OK / login
auth + auth0               OK / no login
SCORE if/endif             équilibré
new I18n keys              0
backend JS/Node delta      0
```

## Gate owner immédiat

1. extraire R45D2A1 ;
2. lint + autoload ;
3. relancer back puis front ;
4. création fullstack publique/session ;
5. création fullstack authentifiée/session ;
6. création fullstack authentifiée/local-password ;
7. création fullstack authentifiée/auth0-proxy ;
8. confirmer une création et contrôler le blueprint généré ;
9. reprendre ensuite preview/commit R45D2.

## Profiler `.lock`

Audit OPUS générique séparé ; aucune suppression aveugle.

NO VALIDATOR RELAXATION.
NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO SECRET OVER REST.
NO PUSH OPUS BY ASSISTANT.
