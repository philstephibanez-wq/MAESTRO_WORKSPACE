# Project Index — MAESTRO WORKSPACE

Ce fichier donne une lecture immédiate des sous-projets du workspace. Il doit rester court, opérationnel et maintenable.

## Règle permanente de livraison

```text
NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
SLOWER IS ACCEPTABLE; WASTING USER TIME IS NOT.
```

Référence canonique : `CONTEXT/DECISIONS/ADR_20260619_CONTRACT_FIRST_NO_BRICOLAGE.md`.

Toute livraison future doit privilégier le contrat, l'audit réel, la source de vérité et la cohérence architecturale plutôt que la vitesse. Aucun site OPUS/ASAP ne doit être traité comme une page isolée si le contrat impose une application, des modules, routes, controllers, services, view-models, templates, ressources, I18N/thèmes ou FSM/transitions.

Règle applicative ASAP/OPUS : une application possède un socle commun hérité par ses modules. Chaque module porte uniquement son métier et ses ressources propres ou overrides : ACL, helpers, CSS/assets, JavaScript, local/I18N, models/services, controllers, views/view-models et templates `.score`. Les parties communes ne sont jamais dupliquées module par module.

Règle OPUS ScoreTemplate : aucune page OPUS conforme sans module et sans template `.score`.

## Carte des sous-projets

### LOGANDPLAY

- Rôle : identité publique, carte d'entrée `logandplay.org`, présentation de l'écosystème Log&Play.
- Statut : intégré sous OPUS comme site à aligner contractuellement.
- Emplacement actuel : `H:\OPUS\sites\logandplay`.
- Dépôt source actuel : `philstephibanez-wq/OPUS`.
- Rendu cible : site/application généré par OPUS, sans hardcode métier dans le core framework.
- Règle P117SITE12 : Log&Play doit être aligné sur le vrai contrat d'application OPUS/ASAP avant toute nouvelle correction visuelle/runtime.
- Règle module : Log&Play doit devenir une application modulaire, pas une page publique isolée.
- Contenu initial : cartes OPUS, MAESTRO et KB avec description + statut `PROCHAINEMENT`.
- Exposition : aucune exposition publique active pour l'instant ; OPUS, MAESTRO et KB restent non publics.
- Sécurité : aucun lien Webmin, admin, LAN, préprod, chemin serveur ou diagnostic public.
- Cible future : Cloudflare Tunnel + Cloudflare Access, pas d'ouverture Freebox par défaut.
- Contrat dédié : `CONTEXT/PROJECTS/LOGANDPLAY.md`.

### OPUS

- Rôle : framework PHP principal.
- Identité : OPUS Framework 8.1.0 "Lysenko".
- Dépôt cible : OPUS.
- Priorité : critique immédiate, livraison Linux préprod + durcissement serveur P117 puis alignement contractuel des sites intégrés P117SITE12.
- État Linux : installé dans `/srv/opus/OPUS`, Apache `public/`, DNS LAN, UFW, Fail2ban SSH/Webmin, ClamAV ciblé, AWFFull privé et Webmin tempdir validés.
- Prochaines étapes : P117SITE12 OPUS site contract alignment, puis `P117L4B_LINUX_MULTISITE_REGISTRY_OVERLAY`, puis `P117AUTH1_ADMIN_GATE_CLOUDFLARE_READY`.
- Règle : OPUS n'est pas ASAP, mais ASAP est une référence historique structurante pour la conception applicative : application commune + modules hérités + parties métier par module.
- Règle Log&Play : OPUS génère le site/page, mais le contenu métier LOGANDPLAY ne doit pas être intégré au cœur framework.
- Règle modules : OPUS doit utiliser toute la potentialité du framework pour ses sites/apps ; pas de page isolée si un module, une route, une FSM, un service, un ViewModel ou un `.score` est requis.
- Entrée runtime : `index.php` à la racine OPUS, unique point d'entrée produit.
- Autoload : classe framework `Opus\Autoload\...`, appelée par `index.php`; aucun script racine `autoload.php`.
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
- Livrable propre : zéro Twig actif, zéro legacy, zéro backup, zéro CSS mort.
- Règle P117SITE12 : RefBook sert de référence de maturité applicative, mais doit lui aussi être contrôlé contre le contrat commun OPUS site avant tout patch UI/runtime.
- Règle ScoreTemplate : tout rendu RefBook doit rester en `.score`.

### OPUS_USER_GUIDE

- Rôle : guide utilisateur optionnel futur.
- Différence : guide humain, installation, workflows, exemples et prise en main.
- Règle : ne pas le mélanger au RefBook technique sans ADR dédiée.
- Règle runtime : même modèle package optionnel OPUS, sans framework dupliqué.
- Statut : option de livraison envisagée, à cadrer.

### OPUS_REF_BOOK

- Rôle : ancien dépôt transitoire historique du RefBook.
- Statut : ne doit plus être considéré comme source officielle long terme après intégration OPUS.
- Destination : historique remplacé par `H:\OPUS\sites\opus-refbook` dans le dépôt OPUS.
- Règle : ne pas recréer les anciens dépôts/racines autonomes.

### MAESTRO_V5

- Rôle : assistant musical REAPER/Lua.
- Objectif : aider le musicien à composer, analyser, humaniser, orchestrer et enrichir.
- Statut public : non exposé ; future carte LOGANDPLAY en `PROCHAINEMENT`.
- Règle : la finalité reste faire de la musique, pas maintenir l'infrastructure.

### MO_KB_DAEMON

- Rôle : backend KB musicale, workers, master/slaves, ingestion et analyses.
- Mode : service Python/headless + contrôle local.
- Statut public : non exposé ; future carte LOGANDPLAY en `PROCHAINEMENT`.
- Règle : la KB canonique reste sous contrôle master ; slaves sans écriture directe concurrente.

### MO_KB_FRONT

- Rôle : front/backoffice PHP/UwAmp pour la KB.
- Statut : à aligner progressivement avec OPUS.
- Statut public : non exposé.
- Règle : UI web séparée du backend Python, consommation par API/versionnement.

### MAESTRO_WORKSPACE

- Rôle : contexte global, décisions, handoffs, contrats transverses.
- Règle : documenter et cadrer, pas remplacer les dépôts sources.
- Règle livraison : chaque livraison significative met à jour le workspace et `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`.
- Règle permanente : ne jamais livrer vite au détriment des contrats ; préférer une livraison plus lente, auditée, cohérente et testable.
- Stockage dev OPUS : `H:\MAESTRO_WORKSPACE\var\opus\...` et `H:\MAESTRO_WORKSPACE\tools\opus\...` si nécessaire.

## Packaging OPUS cible

| Package | Type | Inclusion |
|---|---|---|
| OPUS | Core obligatoire | Toujours livré |
| OPUS_REF_BOOK | Site officiel optionnel | Profil documenté/offline/online |
| OPUS_USER_GUIDE | Guide utilisateur optionnel | Profil futur à cadrer |
| LOGANDPLAY_SITE | Site public futur | Carte d'identité publique `logandplay.org`, générée par OPUS |

## Topologie OPUS cible

```text
OPUS core est unique et partagé.
Les sites/packages optionnels déclarent leur dépendance OPUS.
Aucun site ne copie framework/Opus dans son propre arbre.
Chaque application/site OPUS possède un socle commun et des modules métier hérités.
Chaque module porte uniquement ses ACL/helpers/assets/javascript/local/models-services/controllers/viewmodels/templates propres.
Les pages OPUS passent obligatoirement par modules + templates .score.
OPUS product runtime écrit uniquement dans OPUS/var/cache et OPUS/var/logs.
Les états de développement, audits, generated, recipes, tmp et refbook transitoire vont dans MAESTRO_WORKSPACE.
LOGANDPLAY est un projet/site consommateur d'OPUS, pas une responsabilité du core OPUS.
```

## Handoff de reprise obligatoire

Le fichier canonique de reprise est :

```text
CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
```

Il doit être mis à jour à chaque livraison qui change l'état réel d'un sous-projet, une décision, une priorité ou une prochaine étape.

## Priorité de reprise

1. P117SITE12 : auditer et aligner contractuellement les sites OPUS intégrés avant toute nouvelle correction visuelle/runtime.
2. P117L4B : ajouter un overlay registry Linux pour supprimer `SERVER_DEGRADED` causé par les chemins Windows `H:\UwAmp`.
3. P117AUTH1 : poser un gate admin explicite compatible LAN préprod et Cloudflare Access.
4. P117CF1/P117CF2 : Cloudflare Tunnel puis Cloudflare Access, sans ouverture Freebox par défaut.
5. Reprendre ensuite la migration RefBook contrôlée quand OPUS P117 est stable.

## Contrats associés

- CONTEXT/DECISIONS/ADR_20260619_CONTRACT_FIRST_NO_BRICOLAGE.md
- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/PROJECTS/LOGANDPLAY.md
- CONTEXT/HANDOFFS/P117_20260617_OPUS_LINUX_BASELINE_SMTP_NTP.md
- CONTEXT/HANDOFFS/P117_20260617_OPUS_LINUX_DNS_SECURITY_UFW.md
- CONTEXT/DECISIONS/ADR_20260617_LOGANDPLAY_PUBLIC_IDENTITY_SITE.md
- CONTEXT/DECISIONS/ADR_20260616_OPUS_STRICT_RUNTIME_ENTRYPOINT_VAR_AUTOLOADER.md
- CONTEXT/DECISIONS/ADR_20260614_WORKSPACE_ALWAYS_UPDATED_DELIVERY_HANDOFF.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_DELIVERY_PACKAGING_PROFILE.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_REFBOOK_PACKAGED_OFFLINE_ONLINE_SITE.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_SHARED_CORE_PACKAGES_NO_DUPLICATION.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_FRAMEWORK_IDENTITY.md
- CONTEXT/DECISIONS/ADR_20260615_OPUS_REFBOOK_PRO_DOC_SIDEBAR_SEASONS_THEMES.md
- CONTEXT/VERSIONS/OPUS_VERSION.md
