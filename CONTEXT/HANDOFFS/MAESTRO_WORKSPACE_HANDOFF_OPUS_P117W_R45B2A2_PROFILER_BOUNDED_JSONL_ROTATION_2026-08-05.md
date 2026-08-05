# HANDOFF — OPUS P117W R45B2A2

Date : 2026-08-05

## Base

OPUS `master` : `00ba1221de99b838e211adb1cb4f5925a11f3193`.

R45B2A1R7 est acquis. La surface Web Profiler existe dans les applications générées. Le défaut actif suivant est la croissance non bornée du fichier JSONL.

## Livrable actif

```text
ZIP     : opus_p117w_r45b2a2_profiler_bounded_jsonl_rotation.zip
SHA-256 : 20bf71f25fd2db05e9525af29512fb99c6c5d233812463675759d6d69c4020c5
FILES   : 2
BASE    : 00ba1221de99b838e211adb1cb4f5925a11f3193
```

Chemins :

- `Opus/Profiler/Profiler.php` ;
- `Opus/Scaffold/SiteScaffoldPlan.php`.

## Validation owner obligatoire

Appliquer le ZIP, linter les deux sources, régénérer l'autoload, valider les deux bastions OWASYS et contrôler le diff. Supprimer le site témoin par la commande OPUS puis le recréer depuis OWASYS ; ne jamais le réparer à la main.

Tester avec une limite réduite la rotation répétée, la borne du nombre d'archives, la lecture d'une trace archivée et les écritures concurrentes. La configuration absente conserve les valeurs framework par défaut ; une configuration présente mais invalide bloque explicitement.

PHP CLI/Composer/runtime n'ont pas été exécutés dans le conteneur de préparation. Un parseur PHP indépendant et `git diff --check` ont réussi.

## Suite

Après acquisition fonctionnelle complète : E1, service générique OPUS d'édition sécurisée des sources, puis E2 et E3 selon la spécification validée.

NO LOCAL SITE FIX.  
NO UNBOUNDED STORAGE.  
NO FALLBACK SILENCIEUX.
