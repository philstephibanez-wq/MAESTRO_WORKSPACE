# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R19

Date : 2026-07-27  
État : nettoyage local obligatoire

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 7f672643c345a2a7b9f665773fffe36f60dc5132
Racine owner : H:\OPUS
```

## Cause exacte

Le trace `89447530efcc567d` fournit :

```text
error_code       : OPUS_APPLICATION_COMMAND_REGISTRY_SITE_INVALID
exception_file   : Opus/Console/Application/ApplicationCommandDispatcher.php
exception_line   : 118
exception_message: OPUS_APPLICATION_COMMAND_REGISTRY_SITE_INVALID:sites/owasys_old2/config/composer.commands.json
```

Le répertoire `sites/owasys_old2` est un vestige local hors contrat. Il est absent du dépôt GitHub OPUS actif.

## Décision

Conserver la validation stricte du dispatcher.

Ne pas ajouter de fallback et ne pas ignorer silencieusement les registres invalides.

Supprimer uniquement :

```text
sites/owasys_old2
```

## Livrable

Aucun ZIP : aucun fichier source ne doit être ajouté ou remplacé.

Ne produire aucun script, aucun `tools` et aucun ZIP vide.

## Appliquer

Arrêter les serveurs frontend et backend avec `Ctrl+C`, puis exécuter depuis un terminal CMD VS Code :

```text
cd /d H:\OPUS
if exist sites\owasys_old2 rmdir /s /q sites\owasys_old2
```

## Auditer les registres

```text
php -r "foreach (glob('sites/*/config/composer.commands.json') ?: [] as $f) { $j=json_decode(file_get_contents($f), true, 512, JSON_THROW_ON_ERROR); $d=basename(dirname(dirname(str_replace('\\','/',$f)))); $s=trim((string)($j['site_id']??'')); echo ($d===$s?'OK ':'INVALID ').$d.' site_id='.$s.' '.$f.PHP_EOL; }"
```

Aucune ligne `INVALID` ne doit subsister.

## Valider

```text
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git status --short
```

## Relancer

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

```text
curl -i http://127.0.0.1:8080/api/v1/status
curl -i http://127.0.0.1:8000/fr-FR/applications
```

## Statut attendu

```text
sites/owasys_old2 : absent
Registres          : tous cohérents
Erreur active      : supprimée
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
