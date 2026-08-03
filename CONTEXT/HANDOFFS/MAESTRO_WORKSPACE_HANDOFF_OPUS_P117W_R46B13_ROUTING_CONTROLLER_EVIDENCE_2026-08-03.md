# MAESTRO WORKSPACE — Handoff OPUS P117W R46B13

Date : 2026-08-03

## Base owner

- Dépôt : `philstephibanez-wq/OPUS`
- Branche : `master`
- Base exacte : `d8eba2e5e0631a2e59edd5d509ba017edfbe2037`
- R46B12 est poussé et acquis.
- Archive : `opus_p117w_r46b13_routing_controller_evidence.zip`
- SHA-256 : `a6d2730b021d6806d8526aaa10567380443a93504f6b0543a37534bc2a1c13ae`
- Fichiers complets : 2.

## Cause

Le panneau « Routage et contrôleur » ne recevait pas les preuves nécessaires. OWASYS émettait un `http.route.resolved` limité au chemin puis un événement non contractuel `routing.controller.selected` contenant seulement un identifiant court. Le view-model générique excluait en outre les événements HTTP de l'onglet Routage.

## Correctif

R46B13 produit les types contractuels exacts :

- `http.route.resolved` ;
- `http.controller.selected`.

La résolution expose uniquement des faits observés et assainis :

- chemin reçu et route normalisée ;
- locale et paramètres de route utiles ;
- origine exacte de la règle de dispatch ;
- identifiant et classe du contrôleur ;
- méthode appelée.

Le view-model générique inclut ces deux événements dans le panneau Routage et fournit un résumé développeur dédié. Les événements restent également visibles dans le panneau HTTP, conformément à leur domaine.

## Portée

```text
Opus/Profiler/WebProfilerView.php
sites/owasys-front/application/default/Application.php
```

## Contrôles assistant

- base exacte relue au HEAD owner ;
- aucun ancien `routing.controller.selected` dans le producteur modifié ;
- aucun type doublé `http.http.route.resolved` ;
- trois décisions OWASYS explicites : creation, source et runtime ;
- route Profiler explicitement instrumentée ;
- `git diff --check` propre ;
- archive ZIP intègre avec les deux chemins finaux ;
- PHP indisponible dans l'environnement assistant : lint et runtime obligatoires côté owner.

## Validation owner

Appliquer le ZIP sur le HEAD exact. Exécuter le lint PHP, les smokes OPUS et la validation du site. Ouvrir ensuite le Profiler sur une route runtime, une route création et une route source. Le panneau Routage doit expliquer la route, la règle de sélection et `Controller::action` sans donnée inventée.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
