# HANDOFF GLOBAL — P115 ScoreTemplate / ASAP / RefBook

## Décision validée

Le moteur de template natif ASAP s’appelle :

```text
ASAP ScoreTemplate Engine
ScoreTemplate
Namespace cible : ASAP\View\ScoreTemplate
```

Formule validée :

```text
Smarty-like, mais avec discipline Mustache/Liquid, et sécurité/diagnostic inspirés de Twig.
```

## Situation actuelle

### ASAP

- Chemin : `H:\ASAP`
- Twig appartient désormais à ASAP.
- `composer install` a été exécuté côté ASAP.
- `H:\ASAP\vendor\autoload.php` existe.
- `vendor/` reste local et non versionné.
- `composer.lock` est ignoré côté ASAP.
- `DOC/` est interdit dans ASAP.
- Les assets RefBook officiels doivent vivre sous `H:\ASAP\resources\refbook`.

Palier à finaliser :
- `P115C Move RefBook assets from DOC to resources`

### ASAP_REF_BOOK

- Chemin : `H:\ASAP_REF_BOOK`
- RefBook ne doit plus porter Twig.
- RefBook ne doit plus porter son propre `vendor/`.
- RefBook doit consommer l’ASAP officiel.
- `composer.lock` RefBook doit sortir du dépôt s’il ne porte plus de dépendance runtime propre.

Palier à finaliser :
- `P115D Consume ASAP vendor instead of RefBook vendor`

## Prochains paliers

```text
P115C Move RefBook assets from DOC to resources
P115D Consume ASAP vendor instead of RefBook vendor
P115E ASAP ScoreTemplate Engine MVP
P115F RefBook migrates from Twig templates to ScoreTemplate
P115G Remove Twig from ASAP when no longer used
```

## Version ASAP à poser plus tard

```text
ASAP_VERSION = 8.0.0-alpha.1
ASAP_CODENAME = Berlioz
ASAP_GENERATION = PHP8 modernization
ASAP_CHANNEL = alpha
```

La source de vérité version doit être dans ASAP, via API officielle ASAP, pas dans RefBook.

## Spécification

Voir :

```text
P115E_SCORETEMPLATE_ENGINE_SPEC.md
```

## Règles

- 0 fallback silencieux.
- Pas de `DOC/`, `var/reports`, scripts ou patch docs dans les repos applicatifs.
- Les handoffs/specs vont dans `H:\MAESTRO_WORKSPACE`.
- Pas de suppression Twig tant que RefBook n’est pas migré et testé.
