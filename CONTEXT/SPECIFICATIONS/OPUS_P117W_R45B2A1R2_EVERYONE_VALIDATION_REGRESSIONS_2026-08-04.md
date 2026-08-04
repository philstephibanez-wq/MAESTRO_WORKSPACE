# OPUS P117W R45B2A1R2 — EVERYONE ET RÉGRESSIONS DE VALIDATION

Date : 2026-08-04
Statut : livrable owner actif
Base OPUS : `edf17d28d32b1c2f293ba7993252b6e1748c906c`

## Cause

R45B2A1R1 corrige l'autorisation collective `everyone`, mais les validations owner révèlent deux régressions antérieures dans `SiteCommandService` :

- la règle de nom canonique des FSM générées est appliquée à tort aux FSM contractuelles des applications standard OWASYS ;
- les chemins du runtime backend généré sont imposés à tort à `owasys-back`, application standard autonome.

## Correction générique

- conserver `everyone` comme sujet collectif implicite sans rôle métier ;
- exiger un nom FSM non vide pour toute application ;
- réserver le format canonique `<site_id>.application` aux applications générées ;
- réserver les chemins `application/api/controllers`, `BackendApiController.php` et `var/profiler/rest` aux backends générés ;
- conserver les autres gates FSM, routes, ACL deny-by-default, SSO, SCORE et profils ;
- ne modifier aucun fichier OWASYS ni site généré.

## Livrable

```text
ZIP     : opus_p117w_r45b2a1r2_everyone_validation_regressions.zip
SHA-256 : c8dbf7d0c726c659b666728b208fcd7b024aaa5c7c04fe9ccf39591ada122516
FILES   : 2
BASE    : edf17d28d32b1c2f293ba7993252b6e1748c906c
```

Chemins :

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Console/Service/SiteCommandService.php
```

R45B2A1R2 remplace R45B2A1R1 comme archive cumulative active.

NO ACL BYPASS.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
