# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-27.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:/OPUS
```

## Architecture

Conserver uniquement deux applications OPUS autonomes actives :

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

- supprimer le chargement croisé des applications avec P117W R6 ;
- corriger la validation des sites propres avec P117W R7 ;
- aligner le contrat d’environnement avec P117W R8 ;
- restaurer I18n et les bindings réseau avec P117W R9 ;
- conserver `dev`, `test` et `prod` dans chaque `config/site.json` avec P117W R10 ;
- supprimer l’accès local au Registry frontend avec P117W R11 ;
- permettre le lancement autonome sans préparation manuelle de secrets avec P117W R12 ;
- lire l’adresse et le port locaux depuis la configuration avec P117W R13 ;
- cibler le provider Composer backend dans la requête RCP avec P117W R14 ;
- restaurer la FSM canonique frontend avec P117W R15.

## Développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Utiliser `composer opus:dev-server` pour les deux applications.

## Cause P117W R16

Le trace backend `296ba2a1e87ba3e0` montre :

```text
script = owasys:registry-sync
exit_code = 1
stdout = OPUS_CONSOLE_COMMAND_FAILED
```

Le registre backend déclare l’alias :

```text
owasys:registry-sync -> owasys:registry:sync
```

R14 a ajouté correctement `application_id = owasys-back`, mais sa version de `ApplicationCommandDispatcher` ne conserve que `providers[].commands` et ignore `aliases`.

La commande réellement invoquée par Composer est donc refusée avant charger le provider backend.

## Correction P117W R16

Modifier uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
```

Pour chaque registre :

```text
lire aliases via StructuredFileLoader
valider chaque alias et sa cible
associer l’alias au provider propriétaire
reconnaître l’alias dans supports()
cibler application_id
résoudre l’alias vers la commande canonique
charger uniquement le provider ciblé
exécuter uniquement la commande canonique
```

Conserver le rejet d’ambiguïté pour une commande non ciblée déclarée par plusieurs applications.

## Livrable actif

```text
ZIP : opus_p117w_r16_restore_application_command_aliases.zip
SHA-256 : 31448c0030d19ab7e0d0dd921ce5df20e9bb94ffa3d8c199048fc99b106cb3dd
Fichiers : 1
Octets ZIP : 2827
Octets non compressés : 11588
```

Inclure uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime, aucun secret et aucune racine partagée.

## Valider

```text
php -l Opus/Console/Application/ApplicationCommandDispatcher.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git status --short
```

## Lancer

Frontend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front
```

Backend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back
```

## Tester

```text
curl -i http://127.0.0.1:8080/api/v1/status
curl -i http://127.0.0.1:8000/fr-FR/
curl -i http://127.0.0.1:8000/fr-FR/applications
```

## Statut

```text
P117W R6 à R15 : appliqués
P117W R16 : actif à appliquer
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
