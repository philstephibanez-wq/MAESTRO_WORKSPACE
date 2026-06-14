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

### OPUS_USER_GUIDE

- Rôle : guide utilisateur optionnel futur.
- Différence : guide humain, installation, workflows, exemples et prise en main.
- Règle : ne pas le mélanger au RefBook technique sans ADR dédiée.
- Règle runtime : même modèle package optionnel OPUS, sans framework dupliqué.
- Statut : option de livraison envisagée, à cadrer.

### OPUS_REF_BOOK

- Rôle : dépôt transitoire actuel du RefBook.
- Statut : instable, à assainir.
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

## Priorité de reprise

1. Stopper les rustines sur OPUS_REF_BOOK.
2. Auditer le vrai contenu servi localement.
3. Nettoyer Twig/legacy/backups du livrable cible.
4. Stabiliser layout et i18n RefBook.
5. Définir le manifest package OPUS optionnel.
6. Préparer migration RefBook dans OPUS/packages/opus-refbook.
7. Cadrer les profils de livraison OPUS / OPUS_REF_BOOK / OPUS_USER_GUIDE.
8. Reprendre OPUS puis KB/Maestro selon priorité validée.

## Contrats associés

- CONTEXT/DECISIONS/ADR_20260614_OPUS_DELIVERY_PACKAGING_PROFILE.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_REFBOOK_PACKAGED_OFFLINE_ONLINE_SITE.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_SHARED_CORE_PACKAGES_NO_DUPLICATION.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_FRAMEWORK_IDENTITY.md
- CONTEXT/VERSIONS/OPUS_VERSION.md
