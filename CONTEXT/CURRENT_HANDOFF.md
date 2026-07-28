# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-28

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R22_REGISTRY_PHYSICAL_RECONCILIATION_AND_APPLICATION_ROOT_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R22_REGISTRY_PHYSICAL_RECONCILIATION_2026-07-28.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD courant : 464b702888314edfab2573e7ebe71d87fc988a33
Racine owner : H:\OPUS
P117W R21 : appliqué et committé
P117W R22 : appliqué et committé
```

## Architecture

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne restaurer aucun site monolithique, aucun partage filesystem et aucun vestige `owasys_old*`.

## R22 appliqué

La synchronisation Registry est désormais atomique et :

```text
reconnaît OPUS_SITE_STANDARD_CONTRACT_CORE
importe les sites physiques canoniques
compare id + root_path avec SQLite
supprime les entrées absentes ou divergentes
efface le contexte courant uniquement s’il est devenu obsolète
retourne stale_removed, stale_ids et stale_context_cleared
```

## Racine contractuelle des applications créées

```text
H:\OPUS\sites\<application-id>\
```

Chemin relatif canonique :

```text
sites/<application-id>/
```

Le navigateur ne fournit jamais de chemin. La création reste :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé -> opus:create-site
```

## Validation runtime à effectuer

```text
cd /d H:\OPUS
php -l sites\owasys-back\application\registry\repositories\RegistryRepository.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git status --short
```

Lancer le backend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back
```

Lancer le frontend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front
```

Ouvrir :

```text
http://127.0.0.1:8000/fr-FR/applications
```

Attendu au premier chargement :

```text
stale_removed = 1
stale_ids contient owasys
applications visibles : owasys-back, owasys-front
```

Attendu aux chargements suivants :

```text
stale_removed = 0
```

## Statut

```text
P117W R6 à R22 : présents sur OPUS/master
Prochaine étape : validation runtime owner de R22, puis reprise fonctionnelle après résultat
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
