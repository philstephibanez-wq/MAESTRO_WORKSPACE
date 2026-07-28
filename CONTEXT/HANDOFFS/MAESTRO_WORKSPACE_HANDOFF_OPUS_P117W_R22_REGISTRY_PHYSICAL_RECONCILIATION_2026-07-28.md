# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R22

Date : 2026-07-28  
État : livrable différentiel à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 4868780af4dd65bb7e28d95c981d1a1c5800a243
Racine owner : H:\OPUS
```

## Cause corrigée

La synchronisation SQLite importait et mettait à jour les applications
découvertes sans jamais retirer les applications physiquement supprimées.
Elle ne reconnaissait pas directement
`OPUS_SITE_STANDARD_CONTRACT_CORE`, utilisé par `owasys-front` et
`owasys-back`.

## Correction

R22 :

- synchronise SQLite dans une transaction atomique ;
- découvre directement les applications standard courantes ;
- compare chaque couple SQLite `id + root_path` aux sites canoniques
  réellement présents ;
- supprime les lignes obsolètes ;
- efface le contexte courant uniquement si l’application sélectionnée a
  disparu ;
- retourne `stale_removed`, `stale_ids` et
  `stale_context_cleared`.

## Racine des applications générées

```text
H:\OPUS\sites\<application-id>\
```

Le navigateur ne fournit jamais de chemin. OWASYS appelle uniquement le
workflow sécurisé existant jusqu’à `composer opus:create-site`, qui impose
`sites/<application-id>`.

## Livrable

```text
ZIP : opus_p117w_r22_registry_physical_reconciliation.zip
SHA-256 : 72dbe3d7700dfea0364b807f9e1714ca96218acc692d27c85517d03684538ba1
Taille : 6 868 octets
Fichiers : 1
```

Contenu exclusif :

```text
sites/owasys-back/application/registry/repositories/RegistryRepository.php
```

## Appliquer

```text
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r22_registry_physical_reconciliation.zip" -C H:\OPUS
php -l sites\owasys-back\application\registry\repositories\RegistryRepository.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git diff --check
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

Au premier chargement, la synchronisation doit supprimer l’entrée
`owasys` pointant vers `sites/owasys_old`. Les synchronisations suivantes
doivent être idempotentes.

Attendu :

```text
owasys-back
owasys-front
```

Interdit :

```text
owasys
sites/owasys_old
sites/owasys_old2
```

Ne pas supprimer manuellement le fichier SQLite : R22 réconcilie les données
et préserve les entrées valides.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
