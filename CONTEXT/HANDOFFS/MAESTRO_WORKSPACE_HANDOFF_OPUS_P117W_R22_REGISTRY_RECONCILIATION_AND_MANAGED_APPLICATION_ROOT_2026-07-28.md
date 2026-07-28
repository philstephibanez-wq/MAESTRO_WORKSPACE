# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R22

Date : 2026-07-28  
État : livrable actif à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 2c48c86f04ab96fb031c2c22b8505f270a8eafad
Racine owner : H:\OPUS
P117W R20 : appliqué et committé
P117W R21 Source Browser : produit, indépendant de R22
```

## Architecture

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Conserver la frontière :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Problème actif

SQLite conserve encore `owasys` avec :

```text
root_path = sites/owasys_old
```

Le répertoire n’existe plus parce que la synchronisation actuelle ne fait que des upserts.

L’emplacement des sites créés par OWASYS n’était pas explicitement contracté, bien que Composer les crée déjà sous `sites/<site_id>`.

## Correction

Ajouter une réconciliation backend avant `owasys:registry:sync`.

Supprimer transactionnellement toute entrée dont :

```text
root_path != sites/<id>
répertoire absent
config/site.json absent
contract différent de OPUS_SITE_STANDARD_CONTRACT_CORE
site_id différent de id
nom du répertoire différent de id
```

Supprimer le contexte courant lorsqu’il pointe vers une entrée éliminée.

Déclarer dans le `site.json` backend :

```text
OWASYS_MANAGED_APPLICATIONS_V1
workspace = opus-root
sites_root = sites
site_root_pattern = sites/{site_id}
```

Résolution :

```text
dev  : H:\OPUS\sites\<site_id>
test : <OPUS_ROOT>/sites/<site_id>
prod : <OPUS_ROOT>/sites/<site_id>
```

Le frontend valide le `site_root` renvoyé par Composer et le `root_path` enregistré, sans accéder au filesystem.

## Livrable actif

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

Aucun `tools`, aucun script, aucun runtime, aucune base SQLite, aucun journal, aucun secret.

## Appliquer

Arrêter les deux serveurs avant extraction.

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r22_registry_reconciliation_and_managed_application_root.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r22_registry_reconciliation_and_managed_application_root.zip" -C H:\OPUS
php -l sites\owasys-back\application\default\console.php
php -l sites\owasys-back\application\registry\services\OwasysReconciledCommandProvider.php
php -l sites\owasys-back\application\registry\services\OwasysReconciledCommandProviderInterface.php
php -l sites\owasys-back\application\registry\services\OwasysRegistryReconciler.php
php -l sites\owasys-back\application\registry\services\OwasysRegistryReconcilerInterface.php
php -l sites\owasys-front\application\creation\models\ApplicationCreationModel.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back
```

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front
```

## Déclencher la réconciliation

```text
curl -i http://127.0.0.1:8000/fr-FR/applications
```

Le premier `registry.sync` doit supprimer l’entrée `owasys` et ses événements associés.

## Contrôler SQLite

```text
php -r "$db=new SQLite3('sites/owasys-back/var/registry/owasys.sqlite');$r=$db->query('SELECT id,root_path FROM owasys_applications ORDER BY id');while($x=$r->fetchArray(SQLITE3_ASSOC)){echo $x['id'].' '.$x['root_path'].PHP_EOL;}"
```

Résultat attendu au minimum :

```text
owasys-back sites/owasys-back
```

`owasys` et `sites/owasys_old` ne doivent plus apparaître.

## Contrôler la racine de création

Toute application créée par OWASYS doit être écrite sous :

```text
H:\OPUS\sites\<site_id>
```

en développement, et sous `<OPUS_ROOT>/sites/<site_id>` sur le bastion backend en test ou production.

## Validation effectuée

```text
PHP lint                               : OK
JSON                                   : OK
Racine canonique déclarée              : OK
Frontend sans accès filesystem         : OK
Chemins interdits                      : 0
ZIP                                    : OK
```

Validation SQLite Windows owner : requise.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
