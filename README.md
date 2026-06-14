# MAESTRO WORKSPACE

Workspace global de coordination pour les sous-projets MAESTRO, OPUS, OPUS RefBook, MO_KB et Log&Play.

Ce dépôt sert à garder les contrats, décisions, handoffs et cartes de reprise. Il ne remplace pas les dépôts sources des sous-projets.

## Vue rapide

| Projet | Rôle | État |
|---|---|---|
| OPUS | Framework PHP OPUS 8.1.0 "Lysenko" | Prioritaire |
| OPUS RefBook | Site officiel de documentation OPUS, package optionnel | À migrer dans OPUS |
| OPUS_USER_GUIDE | Guide utilisateur optionnel futur | À cadrer |
| OPUS_REF_BOOK | Dépôt transitoire du RefBook actuel | À nettoyer |
| MAESTRO_V5 | Assistant musical REAPER/Lua | Actif |
| MO_KB_DAEMON | Backend KB musicale, workers master/slaves | Actif |
| MO_KB_FRONT | Front/backoffice KB | À aligner |
| Log&Play | Publication web, domaines, bastion/gateway | À cadrer |
| MAESTRO_WORKSPACE | Contexte global et décisions | Source de contexte |

## Packaging OPUS cible

| Package | Statut | Contrat |
|---|---|---|
| OPUS | Obligatoire | Core clean, livrable, sans résidus RefBook/Twig |
| OPUS_REF_BOOK | Optionnel officiel | Site OPUS offline-first et publiable online |
| OPUS_USER_GUIDE | Optionnel futur | Guide utilisateur séparé du RefBook technique |

## Licence OPUS cible

| Sujet | Décision |
|---|---|
| Copyright | Philippe Stéphane Ibanez |
| Modèle | Source-available, libre d'utilisation non commerciale |
| Commercial | Licence commerciale payante avec royalties obligatoires |
| Open source OSI | Non, sauf décision future contraire |

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
- À la livraison : proposer OPUS clean en package principal, OPUS_REF_BOOK en option officielle, OPUS_USER_GUIDE en option envisagée.
- Licence OPUS cible : copyright Philippe Stéphane Ibanez, usage non commercial libre, usage commercial sous licence payante avec royalties.
