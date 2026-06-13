# P112Q3C1 — ASAP Coverage Smoke Marker Fix

## Rôle

Corriger le smoke P112Q3C qui échouait avec un faux négatif `MARKER_MISSING: var\reports` alors que le générateur de matrice fonctionnait correctement.

## Cause

Le smoke cherchait une chaîne littérale dépendante du séparateur Windows (`var\reports`) dans le code source PHP. Le générateur construit le chemin avec `DIRECTORY_SEPARATOR`, donc la chaîne littérale complète n’existe pas dans le fichier.

## Correction

Le smoke vérifie désormais le marqueur stable et portable `p112q3c_public_api_coverage`, qui garantit que la sortie reste bien ciblée sur le dossier de rapports P112Q3C.

## Contrat

- Aucun changement métier.
- Aucun changement framework.
- Aucun changement du générateur de couverture.
- Aucun `.bat`.
- Le smoke reste statique + lint PHP.

## Validation attendue

```cmd
cd /d H:\ASAP
tools\smoke\run_p112q3c_public_api_coverage_matrix_smoke.cmd
tools\coverage\run_p112q3c_public_api_coverage_matrix.cmd
```

Résultats attendus :

```text
P112Q3C_PUBLIC_API_COVERAGE_MATRIX_SMOKE_OK
P112Q3C_PUBLIC_API_COVERAGE_MATRIX_OK
```
