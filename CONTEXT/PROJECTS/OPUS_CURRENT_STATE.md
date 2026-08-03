# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : d8eba2e5e0631a2e59edd5d509ba017edfbe2037
Dernier acquis : R46B12
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R46B12 est poussé et acquis ; la collision `resolveSignal()` de R46B11 est corrigée.
- R46B10 est annulé et ne doit jamais être appliqué.
- Le contrat FSM V2 reste `table_fsm + current_state + signal -> next_state`.
- Les détails structurés REST/BDD, le terme visible Étape et l'instrumentation SCORE restent acquis.
- `fullstack-test` est un témoin, jamais une cible de correction locale.

## Livrable owner actif — R46B13

- Base : `d8eba2e5e0631a2e59edd5d509ba017edfbe2037`.
- ZIP : `opus_p117w_r46b13_routing_controller_evidence.zip`.
- SHA-256 : `a6d2730b021d6806d8526aaa10567380443a93504f6b0543a37534bc2a1c13ae`.
- Fichiers complets : 2.
- Statut : livré, validation et push owner requis.
- Handoff : `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B13_ROUTING_CONTROLLER_EVIDENCE_2026-08-03.md`.

R46B13 remplace les preuves insuffisantes de routage par les événements exacts `http.route.resolved` et `http.controller.selected`, avec route normalisée, paramètres assainis, règle de dispatch, classe et méthode réellement sélectionnées.

## Invariants

- ZIP différentiel seulement pour OPUS/OWASYS ;
- validation et push par l'owner ;
- aucune correction locale du site témoin ;
- SCORE, Singleton, FSM, I18n, SSO et ACL deny-by-default ;
- aucune donnée inventée dans le Profiler.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
