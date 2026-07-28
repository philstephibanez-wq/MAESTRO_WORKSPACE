# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-28.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
Ancien OWASYS audité : e1055468213ae62806c039ca0231a49a98d844fe
État actuel audité   : dc47342006f7f6a5fc0b6d18fe06d12ac2b82bb5
Racine owner         : H:/OPUS
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
P117W R19 : supprimer les vestiges locaux owasys_old*
```

## Runtime confirmé

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
registry.sync : exit_code 0
frontend /fr-FR/applications : request.completed
```

## Logger et Profiler

Conserver exactement :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler/owasys-front.jsonl
sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler/owasys-back.jsonl
```

## Audit de parité fonctionnelle

Parité confirmée entre l’ancien site et les deux applications actuelles pour :

```text
connexion et SSO
changement de mot de passe
session et contexte applicatif
registre SQLite
synchronisation, sélection et effacement du registre
création d’application
routes frontend
FSM frontend
ACL deny-by-default
I18n UE + ukrainien
rendu SCORE
Logger et Profiler
API REST backend
exécution Composer allow-listée
```

Preuves structurelles principales :

```text
routes anciennes et actuelles : mêmes signaux
FSM ancienne et actuelle     : même SHA f237f5789396e6dc7640cdf1be393b89a34153e4
contrôleurs connexion/compte : mêmes SHA
modèle création              : même SHA df5f36b1e7ecb30655fd4082df83b109c949eb81
contrôleur registre          : même SHA d81ad3441baa5fef5d60a8e87acf2ca21388c100
pending.score ancien/actuel  : même SHA 92554142f9463df23db63e7992a55a62e4c1060f
```

Les modules ci-dessous étaient déjà des surfaces en attente dans l’ancien OWASYS :

```text
structure
data
workflows
security
source
build
```

Ils ne constituent pas une régression de migration.

## Cause P117W R20

Le catalogue historique :

```text
sites/owasys_old2/config/backend.operations.json
```

contenait 11 opérations.

Le catalogue actuel :

```text
sites/owasys-back/config/backend.operations.json
```

n’en contient plus que 7.

Opérations perdues :

```text
site.language.add -> opus:add-language
site.page.create -> opus:create-page
site.rubric.create -> opus:create-rubric
site.export -> opus:export-site
```

Les scripts Composer existent toujours dans `composer.json`. Cette différence constitue la seule perte fonctionnelle confirmée par l’audit.

## Correction P117W R20

Remplacer uniquement :

```text
sites/owasys-back/config/backend.operations.json
```

Restaurer les quatre opérations avec leurs rôles, arguments, expressions de validation, options et drapeaux d’écriture historiques.

Conserver les opérations actuelles et obtenir :

```text
11 opérations au total
4 opérations restaurées
```

## Livrable actif

```text
ZIP : opus_p117w_r20_restore_owasys_functional_operation_parity.zip
SHA-256 : 14c9f5cd4fa0e6228926aec8fe78821ec68d7de600c872657dfebfb70e2e48c5
Fichiers : 1
```

Inclure uniquement :

```text
sites/owasys-back/config/backend.operations.json
```

Ne livrer aucun `tools`, aucun script, aucun fichier runtime, aucun journal, aucun secret et aucune racine partagée.

## Validation effectuée

```text
JSON valide                              : OK
Contrat opération catalog                : OK
Nombre d’opérations                      : 11
Quatre opérations historiques restaurées: OK
Scripts Composer correspondants présents: OK
Chemins interdits dans le ZIP            : 0
ZIP directement superposable             : OK
```

## Validation owner

```text
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
php -r "$j=json_decode(file_get_contents('sites/owasys-back/config/backend.operations.json'),true,512,JSON_THROW_ON_ERROR); foreach(['site.language.add','site.page.create','site.rubric.create','site.export'] as $id){echo (isset($j['operations'][$id])?'OK ':'MISSING ').$id.PHP_EOL;} echo 'TOTAL='.count($j['operations']).PHP_EOL;"
git status --short
```

## Statut

```text
P117W R6 à R19 : présents/appliqués
P117W R20 : actif à appliquer
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
