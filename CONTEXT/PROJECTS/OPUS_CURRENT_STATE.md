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
```

## Développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Utiliser :

```text
composer opus:dev-server -- owasys-front
composer opus:dev-server -- owasys-back
```

## Logger et Profiler

Conserver exactement :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler/owasys-front.jsonl
sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler/owasys-back.jsonl
```

## Trace active

```text
trace_id : 96902adf1f9fd87c
frontend : GET /fr-FR/applications
backend  : POST /api/v1/executions
operation: registry.sync
composer : owasys:registry-sync
résultat : callback Composer code 20
```

Le frontend et REST fonctionnent jusqu’au lancement Composer. Le blocage reste interne à la commande applicative backend.

## Cause P117W R18

`OpusConsoleApplication::safeErrorCode()` accepte uniquement un message entièrement constitué de majuscules, chiffres, `_`, `:`, `-`.

Une exception contenant un identifiant dynamique, un chemin, une valeur de configuration ou un message PHP est remplacée par :

```text
OPUS_CONSOLE_COMMAND_FAILED
```

Le processus Composer renvoie donc un JSON générique, et `ComposerCommandExecutor` ne peut enregistrer la cause réelle dans `owasys-back.log`.

## Correction P117W R18

Modifier uniquement :

```text
Opus/Console/OpusConsoleApplication.php
```

Conserver un code complet déjà conforme.

Extraire le préfixe stable OPUS/OWASYS lorsqu’un contexte dynamique suit le code.

Ajouter aux réponses JSON internes :

```text
diagnostic.error_code
diagnostic.exception_class
diagnostic.exception_file
diagnostic.exception_line
diagnostic.exception_message
diagnostic.fingerprint
```

Rendre les chemins OPUS relatifs, masquer les chemins extérieurs et caviarder les tokens, HMAC, secrets, mots de passe et bearer.

Ne pas modifier la sortie texte publique.

## Livrable actif

```text
ZIP : opus_p117w_r18_preserve_console_root_cause_diagnostics.zip
SHA-256 : 597137c99d95cb89bfcd262e0f6a465062432f43ce60826027cf72e31f731962
Fichiers : 1
Octets ZIP : 4014
Octets non compressés : 19261
```

Inclure uniquement :

```text
Opus/Console/OpusConsoleApplication.php
```

Ne livrer aucun `tools`, aucun script, aucun fichier runtime, aucun journal, aucun secret et aucune racine partagée.

## Validation effectuée

```text
PHP lint                               : OK
Code stable avec suffixe dynamique    : OK
Diagnostic JSON interne               : OK
Caviardage                             : OK
Chemins OPUS relatifs                 : OK
Chemins extérieurs masqués            : OK
Chemins interdits dans le ZIP         : 0
ZIP                                    : OK
```

## Appliquer et valider côté owner

```text
php -l Opus/Console/OpusConsoleApplication.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

Reproduire `/fr-FR/applications`, puis lire le nouveau `stdout_excerpt` dans `sites/owasys-back/var/logs/owasys-back.log`.

Ne pas utiliser la copie d’arborescence transmise par erreur.

## Statut

```text
P117W R6 à R17 : présents/appliqués
P117W R18 : actif à appliquer
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
