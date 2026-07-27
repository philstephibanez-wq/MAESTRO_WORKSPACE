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

- supprimer le chargement croisé des applications avec P117W R6 ;
- corriger la validation des sites propres avec P117W R7 ;
- aligner le contrat d’environnement avec P117W R8 ;
- restaurer I18n et les bindings réseau avec P117W R9 ;
- remplacer la configuration fragmentée par `environments.dev`, `test` et `prod` dans chaque `config/site.json` avec P117W R10 ;
- conserver l’adresse et le port d’écoute comme arguments variables ;
- interdire les secrets littéraux dans la configuration.

## Erreur owner après P117W R10

```text
OPUS_APPLICATION_ENVIRONMENT_SOURCE_MISSING:OPUS_OWASYS_BACKEND_TOKEN
```

## Cause

Les deux serveurs ont été lancés sans définir les variables secrètes requises :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Le refus avant démarrer le serveur applique le contrat P117W R10. Aucun défaut source distinct n’est démontré par cette erreur.

## Activer le développement

Générer une seule paire bearer/HMAC dans un terminal parent.

Lancer `owasys-back` et `owasys-front` depuis ce même terminal pour faire hériter exactement les mêmes valeurs aux deux processus enfants.

Effacer ensuite les variables du terminal parent sans modifier l’environnement déjà hérité par les processus enfants.

Ne créer aucun :

```text
.env
.env.local
config/secrets.json
var/development/environment.json
script de lancement dans le produit
secret dans argv
secret littéral dans site.json
```

## Statut

```text
P117W R6 : appliqué
P117W R7 : appliqué
P117W R8 : appliqué
P117W R9 : appliqué puis remplacé
P117W R10 : appliqué
Activation runtime : requise
Nouveau ZIP : non requis pour l’erreur de variable secrète absente
```

## Lancer

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Réserver `opus:dev-server` au développement. Conserver l’identifiant d’application, l’adresse et le port comme arguments variables.

## Tester

```text
http://127.0.0.1:8000/api/v1/status
http://127.0.0.1:8080/fr-FR/
http://127.0.0.1:8080/fr-FR/applications
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
