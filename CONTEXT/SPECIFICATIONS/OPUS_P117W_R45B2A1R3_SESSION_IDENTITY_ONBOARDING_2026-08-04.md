# OPUS P117W R45B2A1R3 — IDENTITÉS INITIALES SESSION ET VALIDATIONS CUMULÉES

Date : 2026-08-04
Statut : livrable owner actif
Base OPUS : `21ce3ccbaa2c09adabc18d4bf021fbb126db9717`

## Causes

R45B2A1R2 n'est pas acquis au HEAD owner. Le journal OWASYS du 2026-08-04 prouve ensuite un blocage générique du wizard : `OWASYS_CREATION_USERS_PROVIDER_INVALID` lorsque le fournisseur `session` reçoit un identifiant initial.

Le formulaire et son contrat déclarent pourtant que les identifiants initiaux ne stockent aucun mot de passe. Une identité de session doit donc pouvoir être associée à un rôle sans être transformée en utilisateur `local-password`.

## Correction générique cumulative

- conserver l'autorisation collective `everyone` sans rôle métier ni bypass ACL ;
- distinguer les contrats FSM des applications standard et générées ;
- réserver les artefacts REST du backend généré aux applications générées ;
- accepter les identifiants initiaux avec le fournisseur `session` ;
- produire un manifeste d'onboarding portant le fournisseur sélectionné ;
- réserver `password-setup-required` et `var/auth/local-users.json` au fournisseur `local-password` ;
- produire une liaison identité-rôle active, sans secret ni magasin de mots de passe, pour `session` ;
- ne modifier aucun site généré.

## Livrable

```text
ZIP     : opus_p117w_r45b2a1r3_session_identity_onboarding.zip
SHA-256 : 5794c90454beb8df8fefceaba7dc1abb37216ca243f8833ae5c680f596816a46
FILES   : 4
BASE    : 21ce3ccbaa2c09adabc18d4bf021fbb126db9717
```

Chemins :

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Console/Service/SiteCommandService.php
Opus/Scaffold/SiteScaffoldPlan.php
sites/owasys-front/application/creation/controllers/CreationController.php
```

R45B2A1R3 remplace les ZIP R45B2A1R1 et R45B2A1R2 non acquis.

NO ACL BYPASS.
NO LOCAL SITE FIX.
NO SECRET VERSIONNÉ.
NO FALLBACK SILENCIEUX.
