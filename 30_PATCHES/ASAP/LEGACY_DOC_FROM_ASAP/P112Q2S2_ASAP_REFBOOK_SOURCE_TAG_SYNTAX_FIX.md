# P112Q2S2 — ASAP RefBook Source Tag Syntax Fix

## Cause racine

Le premier injecteur Q2S a inséré un bloc docblock complet à l'intérieur de docblocks PHP existants.

Cela pouvait produire un marqueur de fin de commentaire orphelin et casser PHP avec:

```text
syntax error, unexpected token "*", expecting end of file
```

## Correction

- Suppression des blocs `ASAP_REFBOOK` mal insérés.
- Réinjection des balises comme lignes de docblock dans le docblock existant.
- Lint PHP obligatoire des fichiers FSM.
- Audit source tags + manifest obligatoire.
- Test HTTP RefBook obligatoire.

## Règle permanente

Les `.md` ne remplacent jamais les balises de documentation intégrées aux sources pour générer une documentation technique officielle.