# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-31

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md
CONTEXT/AUDITS/OPUS_P117W_R45_GENERATION_AND_RESOURCE_SECURITY_AUDIT_2026-07-31.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45A1_ACL_DENY_PRIORITY_2026-07-31.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Base et état acquis

- OPUS owner validé localement : `33f37843`.
- R45A1 est appliqué, linté, autoloadé et poussé localement sur `master`.
- Le commit `33f37843` n'est pas encore visible par l'API GitHub ; ne produire aucun ZIP supplémentaire avant disponibilité de ce HEAD source.
- `test2` est supprimé et ne doit pas être restauré ou corrigé.
- Le nouveau témoin prévu est `fullstack-test`.
- Modes exacts : `frontend`, `backend`, `fullstack`.
- `fullstack` signifie frontend SCORE + backend REST dans le même site, même déploiement et même serveur par défaut, tout en restant client-serveur via REST.
- Aucun concept, profil, dossier ou runtime `shared`.

## R45 — Sécurité et génération

R45A1 est accepté par l'owner :

- appliquer la priorité absolue du deny ;
- charger la politique ACL via StructuredFileLoader ;
- valider la syntaxe PHP ;
- générer l'autoload optimisé ;
- valider `git diff --check` et un arbre propre.

R45A2, R45B, R45C et R45D restent requis. Leur implémentation est temporairement suspendue pendant le premier incrément Profiler afin de pouvoir observer honnêtement la suite du wizard fullstack.

## Écart Profiler constaté

L'écran de création OWASYS affiche actuellement :

- une chaîne statique `front → REST → back → Composer` ;
- un `trace_id` ;
- un état FSM.

Cette présentation n'est pas une preuve d'exécution. Les traces V1 observées contiennent seulement `trace.started` et `trace.stopped`, y compris en échec. L'intégration récente code la chaîne de corrélation en dur dans le renderer.

Le framework possède historiquement des briques de Web Profiler, collecteurs, routes et vues SCORE. Il faut les auditer et les consolider dans un unique Profiler générique plutôt que créer une solution OWASYS locale.

## Livraison active — R46A

Appliquer le contrat :

`CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md`

Construire uniquement après visibilité GitHub du HEAD owner exact :

1. Définir les objets typés trace, span, événement et statut.
2. Définir `trace_id`, `span_id` et `parent_span_id`.
3. Versionner le schéma de trace.
4. Collecter uniquement des faits réels.
5. Masquer les données sensibles.
6. Signaler explicitement les données indisponibles.
7. Tester succès, warning, error, causalité, durée et mémoire.
8. Respecter les interfaces homonymes aux quatre marqueurs.
9. Livrer un ZIP différentiel direct de fichiers complets.
10. Faire valider par l'owner avant R46B.

## Invariants

- Ne jamais corriger `fullstack-test` directement.
- Corriger OPUS génériquement, puis OWASYS et le générateur.
- Utiliser `?profiler=1` uniquement en développement/local.
- Interdire le Profiler en production.
- Rendre l'interface du Profiler exclusivement avec SCORE.
- Piloter le Profiler par FSM et le protéger par ACL.
- Ne jamais afficher une étape sans événement collecté.
- Ne partager aucun fichier ou état runtime entre owasys-front et owasys-back.
- Ne mettre aucun JavaScript dans owasys-back.
- Ne créer aucun `shared`.

NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
