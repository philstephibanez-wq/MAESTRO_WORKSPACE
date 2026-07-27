# OPUS P117W R19 — SUPPRIMER LE SITE LOCAL OBSOLÈTE `owasys_old2`

Date : 2026-07-27  
État : nettoyage local obligatoire ; aucun fichier source OPUS à modifier

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Cause exacte

Le trace `89447530efcc567d` contient :

```text
OPUS_APPLICATION_COMMAND_REGISTRY_SITE_INVALID
Opus/Console/Application/ApplicationCommandDispatcher.php:118
sites/owasys_old2/config/composer.commands.json
```

Le dispatcher valide chaque registre trouvé sous :

```text
sites/*/config/composer.commands.json
```

Le répertoire local `sites/owasys_old2` contient un registre dont `site_id` ne correspond pas au nom du répertoire. Il s’agit d’un vestige local hors contrat.

Le dépôt GitHub OPUS actif ne contient aucune occurrence de `owasys_old2`.

## Architecture contractuelle

Conserver uniquement les deux applications OWASYS actives :

```text
sites/owasys-front
sites/owasys-back
```

Ne pas modifier le dispatcher pour ignorer un registre invalide. Maintenir sa validation stricte.

## Correction

Arrêter les deux serveurs de développement.

Supprimer uniquement :

```text
sites/owasys_old2
```

Ne supprimer aucun autre répertoire dans R19.

## Absence de ZIP

R19 ne modifie aucun fichier source et ne constitue pas une évolution OPUS/OWASYS. Il s’agit uniquement de supprimer un vestige local absent du dépôt source de vérité.

Ne pas produire de ZIP vide, de script, de `tools` ou de fichier de nettoyage.

## Contrôler

Auditer tous les registres présents et vérifier pour chacun :

```text
basename(site_root) === composer.commands.json.site_id
```

Puis exécuter :

```text
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

Relancer :

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

Tester :

```text
http://127.0.0.1:8000/fr-FR/applications
```

## Statut attendu

```text
sites/owasys_old2                         : absent
registres site_id/répertoire              : cohérents
OPUS_APPLICATION_COMMAND_REGISTRY_SITE_INVALID : supprimé
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
