# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R21

Date : 2026-07-28  
État : livrable actif à appliquer et valider côté owner

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

Ne restaurer aucun site monolithique et aucun accès filesystem croisé.

## Cause active

L’ancien module `source` possédait une navigation fonctionnelle en lecture seule. Cette fonction n’a pas été reprise dans `owasys-front` et `owasys-back`.

Ne pas restaurer l’ancienne action locale, ses `echo` JSON ou son interface construite en JavaScript.

## Correction

Créer une évolution générique OPUS :

```text
Opus\Application\Inspection\SiteSourceInspector
```

L’exposer par :

```text
source.list -> owasys:source-list -> owasys:source:list
source.read -> owasys:source-read -> owasys:source:read
```

Ajouter un provider backend Source distinct du provider Registry.

Ajouter un contrôleur, un modèle REST et un template SCORE frontend Source.

Conserver :

```text
FSM open_source
ACL deny-by-default
SSO
I18n navigateur
Logger et Profiler existants
rendu serveur sans JavaScript obligatoire
lecture seule
limite 1 Mio
blocage des chemins sensibles
```

## Livrable actif

```text
ZIP : opus_p117w_r21_restore_source_browser_via_rest_composer_score.zip
SHA-256 : 66fc714986b3d8da7fc74b9a1a573a072cad9404a160484bb5cc866aa499e9ff
Fichiers : 14
```

## Appliquer

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

## Tester

Sélectionner une application dans :

```text
http://127.0.0.1:8000/fr-FR/applications
```

Ouvrir :

```text
http://127.0.0.1:8000/fr-FR/source
```

Valider :

```text
liste des fichiers autorisés visible
lecture d’un fichier par formulaire POST
contenu rendu par SCORE
aucun JavaScript requis
aucun fichier .env, vendor, var ou .git visible
trace corrélée dans les Logger et Profiler uniques front/back
```

## Validation effectuée

```text
PHP lint                               : OK
JSON                                   : OK
Interface homonyme et quatre marqueurs : OK
Test runtime isolé de l’inspecteur     : OK
Blocage des chemins sensibles          : OK
REST puis Composer                     : OK
SCORE sans echo UI                     : OK
Chemins interdits                      : 0
ZIP                                    : OK
```

Validation runtime intégrée Windows owner : requise.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
