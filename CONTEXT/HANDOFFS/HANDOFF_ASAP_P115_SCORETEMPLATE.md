# HANDOFF ASAP — P115 ScoreTemplate / Twig transition

## Dépôt

```text
H:\ASAP
GitHub : philstephibanez-wq/ASAP
Branche : master
```

## Décisions

Twig appartient maintenant à ASAP. RefBook ne doit plus porter Twig.

`composer install` a été exécuté côté ASAP et `vendor/autoload.php` existe. `vendor/` reste local et non versionné.

## Assets RefBook

Ancien contrat interdit :

```text
H:\ASAP\DOC\refbook
```

Nouveau contrat :

```text
H:\ASAP\resources\refbook
```

Fichiers concernés :
- `framework/Asap/RefBook/Api/RefBookDocumentationAssetRepository.php`
- `framework/Asap/RefBook/Api/RefBookRestSnapshotProvider.php`
- `framework/Asap/RefBook/I18n/RefBookDocumentationI18nCatalog.php`

À vérifier avant commit :
- aucune référence restante à `DOC/refbook`;
- lint PHP OK ;
- `resources/refbook` versionné.

Commit cible :

```text
P115C Move RefBook assets from DOC to resources
```

## ScoreTemplate

Nom officiel :

```text
ASAP ScoreTemplate Engine
```

Namespace cible :

```text
ASAP\View\ScoreTemplate
```

Classes cibles :
- `ScoreTemplateEngine`
- `ScoreTemplateRenderer`
- `ScoreTemplateParser`
- `ScoreTemplateLoader`
- `ScoreTemplateContext`
- `ScoreTemplateFilterRegistry`
- `ScoreTemplateDebugTrace`
- `ScoreTemplateException`

Voir `P115E_SCORETEMPLATE_ENGINE_SPEC.md`.
