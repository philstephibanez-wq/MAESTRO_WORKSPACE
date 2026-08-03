# MAESTRO WORKSPACE — Handoff OPUS P117W R46B12

Date : 2026-08-03

## Base owner

- Dépôt : `philstephibanez-wq/OPUS`
- Branche : `master`
- Base exacte : `bd0c5d20f2e510b3666df8ed758b7a906c9f46ea`
- R46B11 est poussé et acquis, mais son runtime front est bloqué au chargement PHP.
- Archive : `opus_p117w_r46b12_runtime_signal_resolver_collision_fix.zip`
- SHA-256 : `013f8347a4c52c4fcf15ef28eeddfd71e4acc484e15503660968f9252622f76e`
- Fichiers complets : 1.

## Cause

R46B11 a renommé la résolution complète d'une requête en `resolveSignal(...)`, alors que `OwasysRuntimeController` possédait déjà `resolveSignal(string $routeKey)`. PHP refuse donc de charger la classe avec `Cannot redeclare OwasysRuntimeController::resolveSignal()`.

## Correctif

R46B12 renomme uniquement la responsabilité multi-paramètres et son appel en `resolveRequestSignal(...)`. La résolution de route `resolveSignal(string $routeKey)` reste inchangée.

Aucun changement du contrat FSM V2, des transitions, des collecteurs ou du rendu SCORE.

## Portée

```text
sites/owasys-front/application/default/controllers/RuntimeController.php
```

## Contrôles assistant

- exactement une déclaration `resolveRequestSignal(...)` ;
- exactement une déclaration `resolveSignal(string $routeKey)` ;
- aucun ancien appel multi-paramètres à `resolveSignal(...)` ;
- archive ZIP intègre ;
- PHP indisponible dans l'environnement assistant : `php -l` et runtime obligatoires côté owner.

## Validation owner

Appliquer le ZIP sur le HEAD exact, exécuter le lint PHP, démarrer `owasys-front`, recharger `/fr-FR/`, puis vérifier le panneau FSM avant commit.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
