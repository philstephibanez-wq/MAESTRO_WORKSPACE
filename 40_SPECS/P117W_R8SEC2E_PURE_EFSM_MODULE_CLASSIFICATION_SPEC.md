# P117W R8SEC2E — PURE EFSM MODULE CLASSIFICATION

## Statut

Correctif cause-first succédant à R8SEC2D après preuve runtime locale.

## Constat dépôt courant

Le runtime `Opus\Fsm\FsmSiteLoader::modulesFromFsm()` applique déjà la sémantique correcte : un état EFSM sans champ explicite `module` est un objet moteur pur et ne participe pas au contrat `application/<module>`.

Le validateur Composer `Opus\Console\Service\SiteCommandService::modules()` diverge : il utilise actuellement `state.module ?? state.id`, ce qui transforme implicitement tout état pur en module. Après retrait des faux modules de R8SEC2D, `security_quarantine` devient ainsi un pseudo-module et provoque `OPUS_SITE_FSM_MODULE_INVALID`.

Cette divergence entre loader runtime et validateur est la cause racine.

## Correction

1. Aligner `SiteCommandService::modules()` sur `FsmSiteLoader::modulesFromFsm()`.
2. Valider qu'un état possède un `id` non vide.
3. Si `module` est absent : considérer l'état comme pur et ne pas l'ajouter à la liste des modules.
4. Si `module` est présent : conserver la validation stricte du nom et l'interdiction de `default`.
5. Conserver l'exigence qu'une application validée possède au moins un module fonctionnel.
6. Conserver dans les FSM/scaffold R8SEC2D l'absence de `module` pour `security_quarantine` et `fault`.
7. Ne créer aucun répertoire/classe/template/asset factice pour un état pur.
8. Ne toucher à aucun fichier `*.fsm.layout.json`.

## Invariants sécurité

- `security_violation / NMI -> security_quarantine`.
- `critical_error / NMI -> fault`.
- quarantaine persistante fail-closed déjà fournie par R8SEC1/R8SEC2C.
- aucun déblocage automatique.
- aucun PHP ajouté hors couche PHP framework appropriée.
- aucune pollution OWASYS ou applicative pour satisfaire un validateur.

## Validation obligatoire

- lint PHP de `SiteCommandService.php` et du scaffold ;
- parsing JSON des trois FSM ;
- preuve que `security_quarantine` et `fault` n'ont aucun champ `module` ;
- `composer opus:validate-site -- essai` ;
- `composer opus:validate-site -- owasys-front` ;
- `composer opus:validate-site -- owasys-back` ;
- `git diff --check` ;
- contrôle que `sites/essai/config/application.fsm.layout.json` n'est ni écrasé ni inclus au livrable.

## Livraison

ZIP natif différentiel. Aucun résidu de livraison ne doit rester dans OPUS après application. L'owner valide puis committe/pousse OPUS ; l'assistant ne le fait jamais.
