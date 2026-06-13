# P112Q2T — ASAP RefBook All Source Tags Baseline

## Objectif

Ajouter une balise `ASAP_REFBOOK` baseline à tous les symboles du framework ASAP.

## Règles

- Les balises sont dans les sources ASAP.
- Les `.md` ne remplacent pas les balises de génération de documentation.
- Les balises baseline sont volontairement génériques.
- L'enrichissement détaillé se fera ensuite domaine par domaine.
- Les commentaires sont lintés via `php -l` sur tout le framework.

## Sécurité syntaxe

Les blocs `ASAP_REFBOOK` sont des commentaires normaux, insérés avant le PHPDoc existant si présent.
Cela évite de casser l'association du PHPDoc natif avec la classe.
- Tagged during apply: `0`
- Already tagged: `203`
