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
```

Références canoniques :

```text
CONTEXT/DECISIONS/ADR_20260619_CONTRACT_FIRST_NO_BRICOLAGE.md
CONTEXT/DECISIONS/ADR_20260619_OPUS_COMPOSER_GENERATORS_AND_KB_FRONT_SITES.md
CONTEXT/DECISIONS/ADR_20260619_OPUS_SCORE_FIRST_MVC_SOURCE_AGNOSTIC_DATA.md
CONTEXT/DECISIONS/ADR_20260628_OPUS_REST_API_GENERIC_SECURITY_CORE.md
```

Toute livraison future doit privilégier le contrat, l'audit réel, la source de vérité et la cohérence architecturale plutôt que la vitesse. Aucun site OPUS/ASAP ne doit être traité comme une page isolée si le contrat impose une application, des modules, routes, controllers, services, view-models, templates, ressources, I18N/thèmes ou FSM/transitions.

## Carte des sous-projets

### LOGANDPLAY

- Rôle : identité publique, carte d'entrée `logandplay.org`, présentation de l'écosystème Log&Play.
- Statut : intégré sous OPUS comme site à aligner contractuellement.
- Emplacement actuel : `H:\OPUS\sites\logandplay`.
- Dépôt source actuel : `philstephibanez-wq/OPUS`.
- Rendu cible : site/application généré par OPUS, sans hardcode métier dans le core framework.
- Sécurité : aucun lien Webmin, admin, LAN, préprod, chemin serveur ou diagnostic public.
- Cible future : Cloudflare Tunnel + Cloudflare Access, pas d'ouverture Freebox par défaut.
- Contrat dédié : `CONTEXT/PROJECTS/LOGANDPLAY.md`.

### OPUS

- Rôle : framework PHP principal.
- Identité : OPUS Framework 8.1.0 "Lysenko".
- Dépôt cible : `philstephibanez-wq/OPUS`.
- État courant : P7B3 `P7 add LSTSAR contract engine skeleton` validé et poussé sur `master`, commit `ec2cb0c`.
- Prochain palier actif : `P7_LSTSAR_CONTRACT_VALIDATION_CORE`.
- P7B1 validé : REST API SSO Security Core, commit `73f1deb`.
- P7B2 validé : `Opus\Lstsar` contracts, LSTSAR contract registry, REST endpoints `/api/v1/lstsar/contracts` et `/api/v1/lstsar/pipelines/default`, commit `af2576f`.
- P7B3 validé : LSTSAR job descriptor, source/target contract objects, constraint set, stage result, declared pipeline, pipeline runner skeleton, run report, endpoint `/api/v1/lstsar/engine/skeleton`.
- État Linux : installé dans `/srv/opus/OPUS`, Apache `public/`, DNS LAN, UFW, Fail2ban SSH/Webmin, ClamAV ciblé, AWFFull privé et Webmin tempdir validés.
- Règle REST : REST est une brique générique OPUS, data-driven et contractuelle ; elle consomme SSO, Identity, ACL et FSM ; elle ne doit pas contenir de hardcode LSTSAR.
- Règle LSTSAR : LSTSAR signifie Load / Secure / Transform / Store / Audit / Report ; il a ses propres contrats et objets moteur `Opus\Lstsar\...` et consomme REST/Security Core.
- Règle validation LSTSAR suivante : séparer strictement validation reçue/source et validation transformée/cible, avec erreurs explicites et aucun fallback silencieux.
- Règle ACL : l'ACL OPUS est un contrat de policy ; une logique ACL plus mûre issue d'ASAP peut être adaptée derrière interface, sans casser le framework.
- Règle modules : OPUS doit utiliser toute la potentialité du framework pour ses sites/apps ; pas de page isolée si un module, une route, une FSM, un service, un ViewModel ou un `.score` est requis.
- Règle générateurs : l'équivalent OPUS de `composer create site`, `create module`, `create page`, `create route`, `create transition`, `create locale`, `create asset` et `create template` doit devenir le seul chemin de création.
- Règle MVC/data : source de donnée indifférente au rendu ; provider/repository/adapter -> service -> validation/transformation -> ViewModel -> `.score` -> HTML.
- Entrée runtime : `index.php` à la racine OPUS, unique point d'entrée produit.
- Cache Windows dev : `H:\OPUS\var\cache` uniquement.
- Logs Windows dev : `H:\OPUS\var\logs` uniquement.
- Cache/logs Linux préprod : `/srv/opus/OPUS/var/cache` et `/srv/opus/OPUS/var/logs`.
- Règle `var/` : seulement `cache` et `logs`; tout dev/audit/generated/tmp/recipes/refbook va dans MAESTRO_WORKSPACE si nécessaire.
- Livraison : package principal obligatoire, clean, sans résidus RefBook/Twig/legacy/dev.
- Topologie : core framework unique partagé, jamais copié dans chaque site.

### OPUS RefBook

- Rôle : site officiel de documentation OPUS.
- Cible : package optionnel officiel livré avec OPUS.
- Emplacement actuel intégré : `H:\OPUS\sites\opus-refbook`.
- Mode local : offline-first.
- Mode publié : online public, sans debug ni chemins locaux.
- Règle : fonctionne grâce à OPUS, mais ne pollue pas le cœur framework.
- Règle runtime : dépend d'un OPUS core partagé déclaré par manifest/config, sans duplication du framework.
- Règle ScoreTemplate : tout rendu RefBook doit rester en `.score`.
- Règle générateur : les futures pages/modules/routes/transitions RefBook doivent passer par les générateurs OPUS.
- Règle data : ses données de documentation doivent être normalisées avant rendu ; `.score` ne dépend pas de la source.

### OPUS_USER_GUIDE

- Rôle : guide utilisateur optionnel futur.
- Statut : option de livraison envisagée, à cadrer.

### OPUS_REF_BOOK

- Rôle : ancien dépôt transitoire historique du RefBook.
- Statut : ne doit plus être considéré comme source officielle long terme après intégration OPUS.
- Destination : historique remplacé par `H:\OPUS\sites\opus-refbook` dans le dépôt OPUS.

### KB_FRONT_OFFICE

- Rôle : futur site OPUS orienté front public/contrôlé de la KB musicale.
- Statut : à créer plus tard comme vraie application/site OPUS.
- Règle : doit être généré par OPUS, pas bricolé comme page ou UI autonome.

### KB_BACK_OFFICE

- Rôle : futur site OPUS d'administration/backoffice de la KB musicale.
- Statut : à créer plus tard comme vraie application/site OPUS.
- Règle sécurité : admin gate explicite, pas d'exposition publique directe sans contrat d'authentification.

### MAESTRO_V5

- Rôle : assistant musical REAPER/Lua.
- Statut public : non exposé ; future carte LOGANDPLAY en `PROCHAINEMENT`.

### MO_KB_DAEMON

- Rôle : backend KB musicale, workers, master/slaves, ingestion et analyses.
- Statut public : non exposé ; future carte LOGANDPLAY en `PROCHAINEMENT`.

### MO_KB_FRONT

- Rôle : front/backoffice PHP/UwAmp historique pour la KB.
- Statut : à réévaluer et à scinder/aligner vers `KB_FRONT_OFFICE` et `KB_BACK_OFFICE` sous forme de vrais sites OPUS.
- Règle future : ne pas poursuivre en bricolage ; migration ou remplacement par sites OPUS générés contractuellement.

### MAESTRO_WORKSPACE

- Rôle : contexte global, décisions, handoffs, contrats transverses.
- Règle : documenter et cadrer, pas remplacer les dépôts sources.
- Règle livraison : chaque livraison significative met à jour le workspace et `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`.
- Règle permanente : ne jamais livrer vite au détriment des contrats ; préférer une livraison plus lente, auditée, cohérente et testable.

## Packaging OPUS cible

| Package | Type | Inclusion |
|---|---|---|
| OPUS | Core obligatoire | Toujours livré |
| OPUS_REF_BOOK | Site officiel optionnel | Profil documenté/offline/online |
| OPUS_USER_GUIDE | Guide utilisateur optionnel | Profil futur à cadrer |
| LOGANDPLAY_SITE | Site public futur | Carte d'identité publique `logandplay.org`, générée par OPUS |
| KB_FRONT_OFFICE | Site KB futur | Front public/contrôlé généré par OPUS |
| KB_BACK_OFFICE | Site KB futur | Backoffice/admin généré par OPUS |

## Topologie OPUS cible

```text
OPUS core est unique et partagé.
Composer orchestre autoload/packages/manifests/générateurs OPUS.
Les sites/packages optionnels déclarent leur dépendance OPUS.
Aucun site ne copie framework/Opus dans son propre arbre.
Chaque application/site OPUS possède un socle commun et des modules métier hérités.
Les pages OPUS passent obligatoirement par modules + templates .score.
Toute création passe par générateurs OPUS, jamais par création sauvage de page.
.score produit le HTML ; i18n fournit les chaînes ; data est normalisée quelle que soit la source.
JSON/XML/BDD/API/fichiers sont des sources/transports, jamais des substituts aux templates.
REST est une brique framework générique, data-driven et contractuelle.
SSO, Identity, ACL et FSM sont des contrats consommés par REST, LSTSAR et autres briques.
LSTSAR a ses propres contrats et objets moteur sous Opus\Lstsar.
Aucune dépendance externe sauf exception contractée, auditée et validée.
OPUS product runtime écrit uniquement dans OPUS/var/cache et OPUS/var/logs.
Les états de développement, audits, generated, recipes, tmp et refbook transitoire vont dans MAESTRO_WORKSPACE.
LOGANDPLAY, KB_FRONT_OFFICE et KB_BACK_OFFICE sont des sites/applications consommateurs d'OPUS, pas des responsabilités du core OPUS.
```

## Handoff de reprise obligatoire

Le fichier canonique de reprise est :

```text
CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
```

Il doit être mis à jour à chaque livraison qui change l'état réel d'un sous-projet, une décision, une priorité ou une prochaine étape.

## Priorité de reprise

1. Lire `CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md`.
2. Lancer `P7_LSTSAR_CONTRACT_VALIDATION_CORE` : validation source/reçue, validation cible/transformée, erreurs explicites, aucun fallback silencieux.
3. Ajouter i18n fr/en/es au profiler dev toolbar/page.
4. Reprendre ensuite les générateurs OPUS et l'alignement sites/modules : P117SITE12M/N/O/P.
5. Reprendre ensuite `P117L4B_LINUX_MULTISITE_REGISTRY_OVERLAY`, puis `P117AUTH1_ADMIN_GATE_CLOUDFLARE_READY`.
6. Cloudflare Tunnel puis Cloudflare Access, sans ouverture Freebox par défaut.
7. Reprendre ensuite la migration RefBook/Log&Play contrôlée quand OPUS générateurs/sites sont stables.

## Contrats associés

- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
- CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
- CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
- CONTEXT/DECISIONS/ADR_20260628_OPUS_REST_API_GENERIC_SECURITY_CORE.md
- CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
