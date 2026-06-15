# Project Index — MAESTRO WORKSPACE

Ce fichier donne une lecture immédiate des sous-projets du workspace. Il doit rester court, opérationnel et maintenable.

## Carte des sous-projets

### OPUS

- Rôle : framework PHP principal.
- Identité : OPUS Framework 8.1.0 "Lysenko".
- Dépôt cible : OPUS.
- Priorité : haute.
- Règle : OPUS n'est pas ASAP. ASAP est historique uniquement.
- Livraison : package principal obligatoire, clean, sans résidus RefBook/Twig/legacy.
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
- UX cible : header global léger, vraie sidebar documentaire gauche, contenu central confortable, navigation responsive.
- Thèmes cible : `winter` = Night actuel, `summer` = Ocean actuel, `spring` = mauve pastel/lavande sombre, `autumn` = ambre/cuivre/brun doux. `paper` ne doit plus être exposé.

### OPUS_USER_GUIDE

- Rôle : guide utilisateur optionnel futur.
- Différence : guide humain, installation, workflows, exemples et prise en main.
- Règle : ne pas le mélanger au RefBook technique sans ADR dédiée.
- Règle runtime : même modèle package optionnel OPUS, sans framework dupliqué.
- Statut : option de livraison envisagée, à cadrer.

### OPUS_REF_BOOK

- Rôle : dépôt transitoire actuel du RefBook.
- Statut : runtime assaini mais encore transitoire.
- Validé : ScoreTemplate actif, zéro Twig attendu, Composer purgé de `twig/twig`, `lang=cs` OK, branding `OPUS FRAMEWORK / Reference Book`.
- Prochaine étape : P116C5H — sidebar documentaire pro + thèmes saisons avant migration dans OPUS/packages/opus-refbook.
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
```

## Handoff de reprise obligatoire

Le fichier canonique de reprise est :

```text
CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
```

Il doit être mis à jour à chaque livraison qui change l'état réel d'un sous-projet, une décision, une priorité ou une prochaine étape.

## Priorité de reprise

1. P116C5H : restaurer une vraie sidebar documentaire gauche dans OPUS_REF_BOOK.
2. P116C5H : remplacer `night/ocean/paper` par `winter/summer/spring/autumn`.
3. Garder `winter` proche du Night actuel et `summer` proche de l'Ocean actuel.
4. Créer `spring` en mauve pastel/lavande sombre premium.
5. Créer `autumn` en ambre/cuivre/brun doux, sans blanc agressif.
6. Retirer le menu horizontal principal du header ; garder header = brand, search, theme, language.
7. Vérifier zéro Twig, zéro erreur runtime i18n, zéro double scrollbar sale.
8. Ensuite seulement préparer la migration RefBook dans OPUS/packages/opus-refbook.
9. Mettre à jour `CURRENT_HANDOFF.md` à chaque livraison.

## Contrats associés

- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/DECISIONS/ADR_20260614_WORKSPACE_ALWAYS_UPDATED_DELIVERY_HANDOFF.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_DELIVERY_PACKAGING_PROFILE.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_REFBOOK_PACKAGED_OFFLINE_ONLINE_SITE.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_SHARED_CORE_PACKAGES_NO_DUPLICATION.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_FRAMEWORK_IDENTITY.md
- CONTEXT/DECISIONS/ADR_20260615_OPUS_REFBOOK_PRO_DOC_SIDEBAR_SEASONS_THEMES.md
- CONTEXT/VERSIONS/OPUS_VERSION.md
