# Project Index — MAESTRO WORKSPACE

Ce fichier donne une lecture immédiate des sous-projets du workspace. Il doit rester court, opérationnel et maintenable.

## Règle permanente de livraison

```text
NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
SLOWER IS ACCEPTABLE; WASTING USER TIME IS NOT.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
ASAP BEHAVIOR MUST BE EVOLVED, NOT DEGRADED.
```

## Carte des sous-projets

### LOGANDPLAY

- Rôle : identité publique, carte d'entrée `logandplay.org`, présentation de l'écosystème Log&Play.
- Statut : intégré sous OPUS comme site à aligner contractuellement.
- Dépôt source actuel : `philstephibanez-wq/OPUS`.
- Sécurité : aucun lien Webmin, admin, LAN, préprod, chemin serveur ou diagnostic public.

### OPUS

- Rôle : framework PHP principal.
- Identité : OPUS Framework 8.1.0 "Lysenko".
- Dépôt cible : `philstephibanez-wq/OPUS`.
- État courant : P7B4 `P7 repair ACL with ASAP-compatible engine` validé et poussé sur `master`, commit `c402bd9`.
- Prochain palier actif : `P7_LSTSAR_CONTRACT_VALIDATION_CORE`.
- P7B1 validé : REST API SSO Security Core, commit `73f1deb`.
- P7B2 validé : `Opus\Lstsar` contracts, LSTSAR contract registry, REST endpoints `/api/v1/lstsar/contracts` et `/api/v1/lstsar/pipelines/default`, commit `af2576f`.
- P7B3 validé : LSTSAR job descriptor, source/target contract objects, constraint set, stage result, declared pipeline, runner skeleton, run report, endpoint `/api/v1/lstsar/engine/skeleton`, commit `ec2cb0c`.
- P7B4 validé : ACL ASAP-compatible engine behind AclPolicyInterface, default deny, role/resource inheritance, privileges, allow/deny, all roles/resources/privileges, conditions, decision traces.
- Règle OPUS/ASAP : OPUS doit faire évoluer ASAP, pas le dégrader.
- Règle REST : REST est une brique générique OPUS, data-driven et contractuelle ; elle consomme SSO, Identity, ACL et FSM ; elle ne doit pas contenir de hardcode LSTSAR.
- Règle LSTSAR : LSTSAR signifie Load / Secure / Transform / Store / Audit / Report ; il a ses propres contrats et objets moteur `Opus\Lstsar\...`.
- Règle validation LSTSAR suivante : séparer strictement validation reçue/source et validation transformée/cible, avec erreurs explicites et aucun fallback silencieux.
- Entrée runtime : `index.php` à la racine OPUS, unique point d'entrée produit.
- Cache Windows dev : `H:\OPUS\var\cache` uniquement.
- Logs Windows dev : `H:\OPUS\var\logs` uniquement.
- Livraison : package principal obligatoire, clean, sans résidus RefBook/Twig/legacy/dev.
- Topologie : core framework unique partagé, jamais copié dans chaque site.

### OPUS RefBook

- Rôle : site officiel de documentation OPUS.
- Cible : package optionnel officiel livré avec OPUS.
- Emplacement actuel intégré : `H:\OPUS\sites\opus-refbook`.
- Règle : fonctionne grâce à OPUS, mais ne pollue pas le cœur framework.
- Règle ScoreTemplate : tout rendu RefBook doit rester en `.score`.

### OPUS_USER_GUIDE

- Rôle : guide utilisateur optionnel futur.
- Statut : option de livraison envisagée, à cadrer.

### OPUS_REF_BOOK

- Rôle : ancien dépôt transitoire historique du RefBook.
- Statut : ne doit plus être considéré comme source officielle long terme après intégration OPUS.

### KB_FRONT_OFFICE

- Rôle : futur site OPUS orienté front public/contrôlé de la KB musicale.
- Statut : à créer plus tard comme vraie application/site OPUS.

### KB_BACK_OFFICE

- Rôle : futur site OPUS d'administration/backoffice de la KB musicale.
- Statut : à créer plus tard comme vraie application/site OPUS.

### MAESTRO_V5

- Rôle : assistant musical REAPER/Lua.
- Statut public : non exposé ; future carte LOGANDPLAY en `PROCHAINEMENT`.

### MO_KB_DAEMON

- Rôle : backend KB musicale, workers, master/slaves, ingestion et analyses.
- Statut public : non exposé ; future carte LOGANDPLAY en `PROCHAINEMENT`.

### MO_KB_FRONT

- Rôle : front/backoffice PHP/UwAmp historique pour la KB.
- Statut : à réévaluer et à scinder/aligner vers `KB_FRONT_OFFICE` et `KB_BACK_OFFICE` sous forme de vrais sites OPUS.

### MAESTRO_WORKSPACE

- Rôle : contexte global, décisions, handoffs, contrats transverses.
- Règle : documenter et cadrer, pas remplacer les dépôts sources.
- Règle livraison : chaque livraison significative met à jour le workspace et `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`.

## Priorité de reprise

1. Lire `CONTEXT/HANDOFFS/P7B4_20260628_OPUS_ACL_ASAP_COMPAT_REPAIR.md`.
2. Lancer `P7_LSTSAR_CONTRACT_VALIDATION_CORE` : validation source/reçue, validation cible/transformée, erreurs explicites, aucun fallback silencieux.
3. Ajouter i18n fr/en/es au profiler dev toolbar/page.
4. Reprendre ensuite les générateurs OPUS et l'alignement sites/modules.

## Contrats associés

- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/HANDOFFS/P7B4_20260628_OPUS_ACL_ASAP_COMPAT_REPAIR.md
- CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
- CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
- CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
- CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
