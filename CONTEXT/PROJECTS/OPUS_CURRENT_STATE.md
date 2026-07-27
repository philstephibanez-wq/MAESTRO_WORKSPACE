# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-27.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 7f672643c345a2a7b9f665773fffe36f60dc5132
Racine owner : H:/OPUS
```

## Architecture

Conserver uniquement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Ne partager aucun fichier, dossier, volume, configuration, secret, manifeste ou état runtime.

Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Résultats acquis

```text
P117W R6  : supprimer le chargement croisé
P117W R7  : valider les sites propres
P117W R8  : aligner le contrat d’environnement
P117W R9  : restaurer I18n et les bindings réseau
P117W R10 : centraliser dev, test et prod dans config/site.json
P117W R11 : supprimer l’accès Registry local du frontend
P117W R12 : lancer sans préparation manuelle de secrets en dev
P117W R13 : lire host et port depuis la configuration
P117W R14 : cibler le provider Composer backend
P117W R15 : restaurer la FSM frontend canonique
P117W R16 : restaurer les alias de commandes applicatives
P117W R17 : conserver un Logger et un Profiler par application
P117W R18 : conserver la cause interne des erreurs Console
```

## Développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

## Logger et Profiler

Conserver exactement :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler/owasys-front.jsonl
sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler/owasys-back.jsonl
```

## Cause P117W R19

Le trace `89447530efcc567d` fournit désormais la cause exacte :

```text
error_code       : OPUS_APPLICATION_COMMAND_REGISTRY_SITE_INVALID
exception_file   : Opus/Console/Application/ApplicationCommandDispatcher.php
exception_line   : 118
exception_message: OPUS_APPLICATION_COMMAND_REGISTRY_SITE_INVALID:sites/owasys_old2/config/composer.commands.json
```

`ApplicationCommandDispatcher` valide chaque registre trouvé sous :

```text
sites/*/config/composer.commands.json
```

Le vestige local `sites/owasys_old2` contient un registre dont `site_id` ne correspond pas au nom du répertoire. Ce chemin est absent du dépôt GitHub OPUS actif.

## Correction P117W R19

Ne pas affaiblir le dispatcher et ne pas ignorer un registre invalide.

Supprimer uniquement :

```text
sites/owasys_old2
```

Aucun fichier source OPUS n’est modifié. Aucun ZIP n’est produit pour ce nettoyage local absent de la source de vérité.

## Appliquer

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

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

## Statut

```text
P117W R6 à R18 : présents/appliqués
P117W R19 : nettoyage local à appliquer
```

## Contrats framework

Faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php`.

Faire étendre directement chaque interface homonyme par :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Lire toute configuration via `File` et `StructuredFileLoader`. Imposer Logger et Profiler. Interdire tout fallback silencieux.
