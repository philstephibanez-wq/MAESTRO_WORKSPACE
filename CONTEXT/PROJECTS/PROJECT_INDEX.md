# Project Index — MAESTRO WORKSPACE

Ce fichier donne une lecture immédiate des sous-projets du workspace. Il doit rester court, opérationnel et maintenable.

## Carte des sous-projets

### OPUS

- Rôle : framework PHP principal.
- Identité : OPUS Framework 8.1.0 "Lysenko".
- Dépôt cible : OPUS.
- Priorité : critique immédiate.
- Règle : OPUS n'est pas ASAP. ASAP est historique uniquement.
- Entrée runtime : `index.php` à la racine OPUS, unique point d'entrée produit.
- Autoload : classe framework `Opus\Autoload\...`, appelée par `index.php`; aucun script racine `autoload.php`.
- Cache : `H:\OPUS\var\cache` uniquement.
- Logs : `H:\OPUS\var\logs` uniquement.
- Règle `var/` : seulement `cache` et `logs`; tout dev/audit/generated/tmp/recipes/refbook va dans MAESTRO_WORKSPACE si nécessaire.
- Livraison : package principal obligatoire, clean, sans résidus RefBook/Twig/legacy/dev.
- Topologie : core framework unique partagé, jamais copié dans chaque site.

### OPUS RefBook

- Rôle : site officiel de documentation OPUS.
- Cible : package optionnel officiel livré avec OPUS.
- Emplacement cible : OPUS/packages/opus-refbook.
- Mode local : offline-first.
- Mode publié : online public, sans debug ni chemins locaux.
- Règle : fonctionne grâce à OPUS, mais ne pollue pas le cœur framework.
- Règle runtime : dépend d'un OPUS core partagé déclaré par manifest/config, sans duplication du framework.
- Livrable propre : zéro Twig actif, zéro legacy, zéro backup, zéro CSS mort.
- État : revenu au baseline P116C5H après revert des régressions P116C5I/J/K/L.
- Blocage : ne pas reprendre l'UI RefBook tant que le runtime OPUS n'est pas validé.

### OPUS_USER_GUIDE

- Rôle : guide utilisateur optionnel futur.
- Différence : guide humain, installation, workflows, exemples et prise en main.
- Règle : ne pas le mélanger au RefBook technique sans ADR dédiée.
- Règle runtime : même modèle package optionnel OPUS, sans framework dupliqué.
- Statut : option de livraison envisagée, à cadrer.

### OPUS_REF_BOOK

- Rôle : dépôt transitoire actuel du RefBook.
- Statut : runtime assaini puis rollback au baseline P116C5H après régressions UI.
- Validé avant pause : ScoreTemplate actif, zéro Twig attendu, Composer purgé de `twig/twig`, `lang=cs` OK, branding `OPUS FRAMEWORK / Reference Book`, sidebar/thèmes P116C5H.
- Dernier commit stable actuel : `b5f00c6 P116C5M_REVERT_REFBOOK_UI_REGRESSIONS_TO_P116C5H`.
- Destination : migration contrôlée vers OPUS/packages/opus-refbook puis package optionnel OPUS_REF_BOOK.
- Règle : ne pas le considérer comme source officielle long terme.

### MAESTRO_V5

- Rôle : assistant musical REAPER/Lua.
- Objectif : aider le musicien à composer, analyser, humaniser, orchestrer et enrichir.
- Règle : la finalité reste faire de la musique, pas maintenir l'infrastructure.

### MO_KB_DAEMON

- Rôle : backend KB musicale, workers, master/slaves, ingestion et analyses.
- Mode : service Python/headless + contrôle local.
- Règle : la KB canonique reste sous contrôle master ; slaves sans écriture directe concurrente.

### MO_KB_FRONT

- Rôle : front/backoffice PHP/UwAmp pour la KB.
- Statut : à aligner progressivement avec OPUS.
- Règle : UI web séparée du backend Python, consommation par API/versionnement.

### Log&Play / publication

- Rôle : exposition publique, domaines, publication des sites.
- Cible : publication RefBook et autres sites via architecture sécurisée.
- Règle : public -> bastion -> gateway -> services internes -> data.

### MAESTRO_WORKSPACE

- Rôle : contexte global, décisions, handoffs, contrats transverses.
- Règle : documenter et cadrer, pas remplacer les dépôts sources.
- Règle livraison : chaque livraison significative met à jour le workspace et `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`.
- Stockage dev OPUS : `H:\MAESTRO_WORKSPACE\var\opus\...` et `H:\MAESTRO_WORKSPACE\tools\opus\...` si nécessaire.

## Packaging OPUS cible

| Package | Type | Inclusion |
|---|---|---|
| OPUS | Core obligatoire | Toujours livré |
| OPUS_REF_BOOK | Site officiel optionnel | Profil documenté/offline/online |
| OPUS_USER_GUIDE | Guide utilisateur optionnel | Profil futur à cadrer |

## Topologie OPUS cible

```text
OPUS core est unique et partagé.
Les sites/packages optionnels déclarent leur dépendance OPUS.
Aucun site ne copie framework/Opus dans son propre arbre.
OPUS product runtime écrit uniquement dans OPUS/var/cache et OPUS/var/logs.
Les états de développement, audits, generated, recipes, tmp et refbook transitoire vont dans MAESTRO_WORKSPACE.
```

## Handoff de reprise obligatoire

Le fichier canonique de reprise est :

```text
CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
```

Il doit être mis à jour à chaque livraison qui change l'état réel d'un sous-projet, une décision, une priorité ou une prochaine étape.

## Priorité de reprise

1. P116C5N : restaurer OPUS `index.php` unique point d'entrée.
2. P116C5N : restaurer l'autoloader comme classe framework appelée par `index.php`.
3. P116C5N : l'autoloader reconstruit son cache dans `OPUS/var/cache` si nécessaire.
4. P116C5N : OPUS écrit ses logs runtime dans `OPUS/var/logs`.
5. P116C5N : `OPUS/var` est strictement limité à `cache/logs`.
6. P116C5N : déplacer les contenus dev/audit/generated/tmp/recipes/refbook vers MAESTRO_WORKSPACE si nécessaires.
7. P116C5N : audit bloquant `OPUS_INDEX_ENTRYPOINT_OK`, `OPUS_AUTOLOAD_CACHE_REBUILD_OK`, `OPUS_RUNTIME_LOG_WRITE_OK`, `OPUS_STRICT_VAR_CONTRACT_OK`.
8. Ensuite seulement reprendre la migration RefBook contrôlée.

## Contrats associés

- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/DECISIONS/ADR_20260616_OPUS_STRICT_RUNTIME_ENTRYPOINT_VAR_AUTOLOADER.md
- CONTEXT/DECISIONS/ADR_20260614_WORKSPACE_ALWAYS_UPDATED_DELIVERY_HANDOFF.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_DELIVERY_PACKAGING_PROFILE.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_REFBOOK_PACKAGED_OFFLINE_ONLINE_SITE.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_SHARED_CORE_PACKAGES_NO_DUPLICATION.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_FRAMEWORK_IDENTITY.md
- CONTEXT/DECISIONS/ADR_20260615_OPUS_REFBOOK_PRO_DOC_SIDEBAR_SEASONS_THEMES.md
- CONTEXT/VERSIONS/OPUS_VERSION.md
