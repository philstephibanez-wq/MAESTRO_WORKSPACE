# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-28

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R21_RESTORE_SOURCE_BROWSER_VIA_REST_COMPOSER_SCORE_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R21_RESTORE_SOURCE_BROWSER_VIA_REST_COMPOSER_SCORE_2026-07-28.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 2c48c86f04ab96fb031c2c22b8505f270a8eafad
Racine owner : H:\OPUS
P117W R20 : appliqué et committé
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

## État runtime confirmé

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
registry.sync : succès
frontend /fr-FR/applications : succès
```

## Audit fonctionnel corrigé

P117W R20 a restauré les quatre opérations backend manquantes :

```text
site.language.add
site.page.create
site.rubric.create
site.export
```

Le module `source` de l’ancien OWASYS n’était pas une surface vide. Il permettait la liste et la lecture en lecture seule des fichiers autorisés de l’application courante.

L’ancienne implémentation est interdite car elle accédait au filesystem depuis le frontend, produisait du JSON avec `echo` et dépendait de JavaScript.

## Évolution générique OPUS P117W R21

Créer :

```text
Opus\Application\Inspection\SiteSourceInspector
```

Contrats :

```text
OPUS_SITE_SOURCE_LIST_V1
OPUS_SITE_SOURCE_FILE_V1
```

Faire passer le navigateur Source par :

```text
SCORE
-> FSM open_source
-> ACL + SSO
-> REST sécurisé
-> FSM backend
-> Composer allow-listé
-> OwasysSourceCommandProvider
-> SiteSourceInspector
-> ViewModel
-> SCORE
```

Opérations :

```text
source.list -> owasys:source-list -> owasys:source:list
source.read -> owasys:source-read -> owasys:source:read
```

## Livrable actif

```text
ZIP : opus_p117w_r21_restore_source_browser_via_rest_composer_score.zip
SHA-256 : 66fc714986b3d8da7fc74b9a1a573a072cad9404a160484bb5cc866aa499e9ff
Fichiers : 14
```

Ne livrer aucun `tools`, aucun script, aucun fichier runtime, aucun journal, aucun secret et aucune racine partagée.

## Appliquer et valider

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r21_restore_source_browser_via_rest_composer_score.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r21_restore_source_browser_via_rest_composer_score.zip" -C H:\OPUS
php -l Opus\Application\Inspection\SiteSourceInspector.php
php -l Opus\Application\Inspection\SiteSourceInspectorInterface.php
php -l sites\owasys-back\application\source\console.php
php -l sites\owasys-back\application\source\services\OwasysSourceCommandProvider.php
php -l sites\owasys-back\application\source\services\OwasysSourceCommandProviderInterface.php
php -l sites\owasys-front\application\default\Application.php
php -l sites\owasys-front\application\default\bootstrap.php
php -l sites\owasys-front\application\source\controllers\SourceController.php
php -l sites\owasys-front\application\source\models\SourceModel.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git status --short
```

## Lancer et tester

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

```text
http://127.0.0.1:8000/fr-FR/applications
http://127.0.0.1:8000/fr-FR/source
```

## Statut

```text
P117W R6 à R20 : présents/appliqués
P117W R21 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
