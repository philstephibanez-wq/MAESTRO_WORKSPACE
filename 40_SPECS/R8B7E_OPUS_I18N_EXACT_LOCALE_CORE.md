# R8B7E — OPUS I18n exact-locale core

Date: 2026-09-01
Baseline OPUS: `1034e0b7cc0bb323219458dbf08b07cf8843c316` (`R8B7C`).

## But

Supprimer du coeur OPUS toute surface fonctionnelle conçue pour le fallback de locale, avant de corriger les politiques et catalogues OWASYS.

## Périmètre exact

Fichiers modifiés uniquement:

- `Opus/I18n/Locale.php`
- `Opus/I18n/LocaleInterface.php`
- `Opus/I18n/CatalogLoader.php`

## Contrat

### Locale

`Locale` reste responsable de la normalisation canonique BCP47 et de l'exposition de `value`, `language`, `script`, `region`.

Les méthodes suivantes disparaissent complètement:

- `parent()`
- `fallbackChain()`

Elles disparaissent également de `LocaleInterface`.

### CatalogLoader

`CatalogLoader::loadDirectory()` ne parcourt plus une chaîne de candidats de locale.

Il cherche uniquement le fichier de la locale exacte reçue:

`<directory>/<locale>.<json|yaml|yml|xml>`

Règles conservées:

- plus d'un format présent pour la même locale exacte => ambiguïté;
- aucun fichier et `required=true` => `OPUS_I18N_CATALOG_FILE_MISSING`;
- aucun fichier et `required=false` => `null`;
- validation de locale/scope inchangée;
- parsing toujours via `StructuredFileLoader` et la frontière `File` OPUS.

## Hors périmètre volontaire

Ce lot ne modifie pas encore:

- `sites/owasys-front/config/site.json`;
- `OwasysLocaleRegistry`;
- les 38 catalogues régionaux;
- `routes.localized.json`.

Ces corrections sont séparées afin de conserver une validation différentielle bornée.

## Validation attendue

- `php -l` sur les trois fichiers;
- `composer dump-autoload -o`;
- runner R8B7D complet;
- disparition de `I18N_CATALOG_FALLBACK_LOOP_FORBIDDEN`;
- disparition des deux `I18N_FALLBACK_API_REMAINS`;
- aucun nouveau finding.
