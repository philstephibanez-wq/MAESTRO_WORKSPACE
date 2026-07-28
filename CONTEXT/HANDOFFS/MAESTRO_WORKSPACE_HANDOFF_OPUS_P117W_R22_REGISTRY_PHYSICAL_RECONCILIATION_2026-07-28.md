# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R22

Date : 2026-07-28  
État : appliqué sur `OPUS/master`; validation runtime owner requise

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base de développement : 4868780af4dd65bb7e28d95c981d1a1c5800a243
Commit appliqué : 464b702888314edfab2573e7ebe71d87fc988a33
Racine owner : H:\OPUS
```

## Cause corrigée

La synchronisation SQLite importait et mettait à jour les applications découvertes sans jamais retirer les applications physiquement supprimées.

Elle ne reconnaissait pas directement :

```text
OPUS_SITE_STANDARD_CONTRACT_CORE
```

Le Registry pouvait donc conserver :

```text
owasys -> sites/owasys_old
```

malgré l’absence physique de cette racine.

## Correction appliquée

R22 :

```text
ouvre une transaction SQLite immédiate
importe le seed
découvre les sites physiques canoniques
reconnaît OPUS_SITE_STANDARD_CONTRACT_CORE
réalise les UPSERT canoniques
compare les couples SQLite id + root_path aux couples physiques
supprime les lignes obsolètes
efface le contexte courant seulement si son application a disparu
commit ou rollback explicite
```

Le résultat expose :

```text
stale_removed
stale_ids
stale_context_cleared
```

La réconciliation technique ne crée pas d’événement utilisateur `select_app`.

## Racine des applications générées

```text
H:\OPUS\sites\<application-id>\
```

Chemin relatif :

```text
sites/<application-id>/
```

Cette racine est imposée par le contrat de site, `SiteScaffoldPlan`, `ScaffoldWriter` et `SiteCommandService`.

Le navigateur ne fournit jamais de chemin. Toute création suit :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé -> opus:create-site
```

## Différentiel historique R22

```text
ZIP : opus_p117w_r22_registry_physical_reconciliation.zip
SHA-256 : 72dbe3d7700dfea0364b807f9e1714ca96218acc692d27c85517d03684538ba1
Fichiers : 1
sites/owasys-back/application/registry/repositories/RegistryRepository.php
```

Le différentiel est désormais intégré dans le commit OPUS `464b702888314edfab2573e7ebe71d87fc988a33`.

## Valider

```text
cd /d H:\OPUS
php -l sites\owasys-back\application\registry\repositories\RegistryRepository.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git status --short
```

## Lancer

Backend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back
```

Frontend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front
```

## Contrôler

Ouvrir :

```text
http://127.0.0.1:8000/fr-FR/applications
```

Premier chargement attendu :

```text
applications visibles : owasys-back, owasys-front
owasys / sites/owasys_old : absent
stale_removed : 1
stale_ids : [owasys]
```

Chargements suivants :

```text
stale_removed : 0
```

Ne pas supprimer manuellement le fichier SQLite : R22 réconcilie les données et préserve les entrées valides.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
