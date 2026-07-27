# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R19_REMOVE_OBSOLETE_OWASYS_OLD2_LOCAL_SITE_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R19_REMOVE_OBSOLETE_OWASYS_OLD2_LOCAL_SITE_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 7f672643c345a2a7b9f665773fffe36f60dc5132
Racine owner : H:\OPUS
Trace actif : 89447530efcc567d
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

## Cause active

R18 a exposé la cause exacte :

```text
OPUS_APPLICATION_COMMAND_REGISTRY_SITE_INVALID
Opus/Console/Application/ApplicationCommandDispatcher.php:118
sites/owasys_old2/config/composer.commands.json
```

`sites/owasys_old2` est un vestige local absent du dépôt source de vérité. Son registre déclare un `site_id` différent du nom de son répertoire.

## Correction P117W R19

Conserver la validation stricte du dispatcher.

Supprimer uniquement :

```text
sites/owasys_old2
```

Ne modifier aucun fichier OPUS. Ne produire aucun ZIP vide, script ou `tools`.

## Appliquer

```text
cd /d H:\OPUS
if exist sites\owasys_old2 rmdir /s /q sites\owasys_old2
```

## Auditer

```text
php -r "foreach (glob('sites/*/config/composer.commands.json') ?: [] as $f) { $j=json_decode(file_get_contents($f), true, 512, JSON_THROW_ON_ERROR); $d=basename(dirname(dirname(str_replace('\\','/',$f)))); $s=trim((string)($j['site_id']??'')); echo ($d===$s?'OK ':'INVALID ').$d.' site_id='.$s.' '.$f.PHP_EOL; }"
```

Aucune ligne `INVALID` ne doit subsister.

## Valider et relancer

```text
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

## Statut

```text
P117W R6 à R18 : présents/appliqués
P117W R19 : nettoyage local actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
