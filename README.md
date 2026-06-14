# MAESTRO WORKSPACE

Workspace global de coordination pour les sous-projets MAESTRO, OPUS, OPUS RefBook, MO_KB et Log&Play.

Ce dépôt sert à garder les contrats, décisions, handoffs et cartes de reprise. Il ne remplace pas les dépôts sources des sous-projets.

## Vue rapide

| Projet | Rôle | État |
|---|---|---|
| OPUS | Framework PHP OPUS 8.1.0 "Lysenko" | Prioritaire |
| OPUS RefBook | Site officiel de documentation OPUS, livré avec OPUS | À migrer dans OPUS |
| OPUS_REF_BOOK | Dépôt transitoire du RefBook actuel | À nettoyer |
| MAESTRO_V5 | Assistant musical REAPER/Lua | Actif |
| MO_KB_DAEMON | Backend KB musicale, workers master/slaves | Actif |
| MO_KB_FRONT | Front/backoffice KB | À aligner |
| Log&Play | Publication web, domaines, bastion/gateway | À cadrer |
| MAESTRO_WORKSPACE | Contexte global et décisions | Source de contexte |

## Raccourcis

- Index projets : CONTEXT/PROJECTS/PROJECT_INDEX.md
- Décisions : CONTEXT/DECISIONS/
- Handoffs : CONTEXT/HANDOFFS/
- Versions : CONTEXT/VERSIONS/
- Workspace VS Code : MAESTRO_WORKSPACE.code-workspace

## Règles immédiates

- Pas de patch sans source de vérité.
- Pas de fallback silencieux.
- Pas de code mort dans les livrables.
- RefBook cible : zéro Twig actif, zéro archive legacy, zéro backup.
- Le RefBook OPUS doit rester un vrai site OPUS offline et publiable online.
