# P117W R8SEC2E — HANDOFF PURE EFSM MODULE CLASSIFICATION

## Base OPUS autoritative

`master` courant : `c1a9fc8748574633f29ea172e5ee0d557dbb6388` (`R8SEC2C`).

## État local owner connu avant R8SEC2E

R8SEC2D a été appliqué localement et a retiré les faux champs `module` de `security_quarantine` et `fault` dans le scaffold et les FSM `essai`, `owasys-front`, `owasys-back`. Le fichier runtime `sites/essai/config/application.fsm.layout.json` est un artefact utilisateur/runtime à préserver et reste hors périmètre.

Validation R8SEC2D : échec sur les trois applications avec `OPUS_SITE_FSM_MODULE_INVALID`.

## Cause racine vérifiée dans le dépôt

`Opus\Fsm\FsmSiteLoader::modulesFromFsm()` ignore déjà correctement tout état sans champ explicite `module`.

`Opus\Console\Service\SiteCommandService::modules()` utilise au contraire `module ?? id`. Il transforme donc un état moteur pur en module implicite. `security_quarantine`, qui contient un underscore, échoue immédiatement dans le validateur d'identifiant et produit `OPUS_SITE_FSM_MODULE_INVALID`.

Le correctif est framework et doit aligner le validateur sur le loader runtime. Aucun faux module ne doit être recréé.

## Cibles R8SEC2E

- `Opus/Console/Service/SiteCommandService.php`
- maintien des corrections R8SEC2D dans :
  - `Opus/Scaffold/SiteScaffoldPlan.php`
  - `sites/essai/config/application.fsm.json`
  - `sites/owasys-front/config/fsm.json`
  - `sites/owasys-back/config/fsm.json`

Aucun autre fichier OPUS/OWASYS ne doit être modifié par ce gate.

## Non-cibles absolues

- tous les `*.fsm.layout.json` ;
- création de répertoires `security`, `system`, `fault`, `security_quarantine` ;
- ajout de PHP dans config/data/templates/assets ;
- JavaScript/Node/npm/yarn/pnpm côté `owasys-back` ;
- modifications locales du rendu diagramme hors besoin du gate.

## Critères de sortie

Les trois commandes `composer opus:validate-site` doivent redevenir valides avec les états purs présents. En cas de toute autre erreur, STOP et retour de la sortie complète ; aucune poursuite vers commit/push.
