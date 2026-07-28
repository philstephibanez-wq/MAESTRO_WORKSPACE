# OPUS P117W R22 — RÉCONCILIER LE REGISTRE ET DÉFINIR LA RACINE DES APPLICATIONS GÉRÉES

Date : 2026-07-28  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 2c48c86f04ab96fb031c2c22b8505f270a8eafad
Racine owner : H:\OPUS
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

Le frontend ne doit jamais accéder au filesystem des applications gérées.

## Cause 1 — entrée SQLite obsolète

La synchronisation actuelle :

```text
importe et met à jour les sites découverts
ne supprime jamais une entrée dont root_path a disparu
```

Ainsi `owasys` reste présent dans SQLite avec :

```text
root_path = sites/owasys_old
```

alors que ce répertoire n’existe plus.

## Correction du registre

Ajouter un reconciler backend exécuté uniquement avant :

```text
owasys:registry:sync
```

Pour chaque ligne de `owasys_applications`, valider :

```text
id conforme
root_path = sites/<id>
racine physique existante sous OPUS_ROOT
config/site.json présent
contract = OPUS_SITE_STANDARD_CONTRACT_CORE
site_id = id
nom du répertoire = id
```

Supprimer transactionnellement les lignes invalides. Les événements associés sont supprimés par la contrainte SQLite `ON DELETE CASCADE`.

Supprimer également `owasys_runtime_context.current_app` lorsque le contexte pointe vers une application supprimée ou non canonique.

Ajouter au résultat `registry.sync` :

```text
reconciliation.contract
reconciliation.checked
reconciliation.removed
reconciliation.removed_ids
reconciliation.current_context_cleared
```

Ne modifier aucune base directement depuis le frontend.

## Cause 2 — emplacement des applications créées implicite

`SiteCommandService::create()` crée déjà les sites sous :

```text
sites/<site_id>
```

mais OWASYS ne déclarait ni ne contrôlait cette décision.

## Contrat de stockage des applications gérées

Déclarer dans `sites/owasys-back/config/site.json` :

```text
contract = OWASYS_MANAGED_APPLICATIONS_V1
owner_application = owasys-back
workspace = opus-root
sites_root = sites
site_root_pattern = sites/{site_id}
frontend_filesystem_access = false
creation_boundary = rest-secured-composer
```

Résolution :

```text
dev  : H:\OPUS\sites\<site_id>
test : <OPUS_ROOT>/sites/<site_id>
prod : <OPUS_ROOT>/sites/<site_id>
```

`OPUS_ROOT` désigne la racine OPUS du bastion backend. Aucune racine partagée avec le frontend.

Le modèle de création frontend doit refuser le résultat lorsque :

```text
command.site_root != sites/<site_id>
registry.root_path != sites/<site_id>
```

## Livrable

```text
ZIP : opus_p117w_r22_registry_reconciliation_and_managed_application_root.zip
SHA-256 : b98ec51bdd2ff5156b03733a61805911338fdc42321194a0741ccb7e21f950b4
Fichiers : 7
Octets non compressés : 22800
```

Contenu exclusif :

```text
sites/owasys-back/application/default/console.php
sites/owasys-back/application/registry/services/OwasysReconciledCommandProvider.php
sites/owasys-back/application/registry/services/OwasysReconciledCommandProviderInterface.php
sites/owasys-back/application/registry/services/OwasysRegistryReconciler.php
sites/owasys-back/application/registry/services/OwasysRegistryReconcilerInterface.php
sites/owasys-back/config/site.json
sites/owasys-front/application/creation/models/ApplicationCreationModel.php
```

Ne livrer aucun `tools`, aucun script, aucun fichier runtime, aucune base SQLite, aucun journal, aucun secret et aucune racine partagée.

## Compatibilité

R22 est superposable après R20 et n’écrase aucun fichier du ZIP R21 Source Browser. R21 et R22 peuvent être appliqués dans n’importe quel ordre après R20.

## Validation effectuée

```text
PHP lint des six fichiers PHP                 : OK
JSON site.json                                : OK
Provider applicatif via interface contractuelle: OK
Réconciliation appelée uniquement sur sync    : OK
Racine canonique sites/<site_id>               : OK
Frontend sans accès filesystem                 : OK
Chemins interdits dans le ZIP                  : 0
ZIP directement superposable                   : OK
```

L’extension SQLite3 n’est pas disponible dans le runtime de fabrication du ZIP. La suppression transactionnelle doit être validée sur le runtime Windows owner avec PHP 8.5.6.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
