# OPUS P117W R6 — TRAITER LA CAUSE RACINE DU CHARGEMENT CROISÉ DES APPLICATIONS

Date : 2026-07-26  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer les contrats MAESTRO/OPUS actifs.

Appliquer en particulier :

```text
Toujours traiter la cause, jamais l'effet
```

## Conserver

Conserver uniquement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier, dossier, volume, secret, configuration, manifeste ou état runtime.

## Identifier la cause racine

`OpusConsoleApplication::fromRoot()` construit systématiquement `ApplicationCommandDispatcher` avant connaître la commande demandée.

`ApplicationCommandDispatcher` parcourt ensuite tous les registres et exécute immédiatement tous les bootstraps applicatifs.

Une commande framework telle que :

```text
validate:site
dev:server
```

charge donc simultanément les providers de :

```text
sites/owasys
sites/owasys-back
```

Les deux racines déclarent encore la classe globale `OwasysApplicationSingletonInspector`, ce qui provoque la redéclaration fatale avant exécuter la commande framework.

Considérer la redéclaration comme un effet. Traiter le chargement global comme la cause.

## Corriger OpusConsoleApplication

Modifier :

```text
Opus/Console/OpusConsoleApplication.php
```

Ne plus construire `ApplicationCommandDispatcher` dans `fromRoot()`.

Conserver une référence nullable au dispatcher et la créer uniquement dans le chemin d'exécution d'une commande applicative.

Ne charger aucun registre ni provider applicatif pour les commandes framework :

```text
create:application
create:site
export:site
add:language
validate:site
list:routes
create:page
create:rubric
dev:server
serve:site
```

## Corriger ApplicationCommandDispatcher

Modifier :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
```

Lire les métadonnées des registres via `File` et `StructuredFileLoader`, sans exécuter leurs bootstraps.

Conserver uniquement des descripteurs typés contenant :

```text
site_id
site_root
bootstrap
commands
```

Pour une commande applicative :

1. rechercher les descripteurs déclarant la commande ;
2. refuser explicitement zéro correspondance ;
3. refuser explicitement plusieurs correspondances ;
4. charger uniquement le bootstrap de l'unique provider propriétaire ;
5. vérifier le contrat du provider ;
6. exécuter la commande.

Ne jamais charger tous les providers dans le même processus.

## Contrat des classes framework

Conserver :

```text
OpusConsoleApplication implements OpusConsoleApplicationInterface
ApplicationCommandDispatcher implements ApplicationCommandDispatcherInterface
```

Conserver l'extension directe des quatre marqueurs standards par chaque interface homonyme.

## Livrer

```text
ZIP : opus_p117w_r6_lazy_application_provider_bootstrap_root_cause.zip
SHA-256 : b9e6fade25160bd5e6fe3fbb3810267b4544cac67b4deff7c6d0a8a1d75c3896
Fichiers : 2
Octets : 5558
```

Inclure uniquement :

```text
Opus/Console/OpusConsoleApplication.php
Opus/Console/Application/ApplicationCommandDispatcher.php
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport et aucune racine partagée.

## Valider avant livraison

Valider dans un environnement isolé contenant deux sites dont les bootstraps déclarent volontairement une même classe globale :

```text
Exécuter validate:site sans charger de provider                 : OK
Exécuter dev:server sans charger de provider                    : OK
Découvrir les commandes sans charger de bootstrap               : OK
Refuser une commande ambiguë avant charger un provider          : OK
Charger uniquement le provider d'une commande unique            : OK
Analyser la syntaxe PHP                                          : OK
Détecter un chemin interdit dans le ZIP                          : 0
Réouvrir le ZIP                                                  : OK
```

Marqueur :

```text
P117W_R6_ROOT_CAUSE_FIXED_OK
```

Ne pas présenter cette validation isolée comme une validation runtime Windows owner.

## Valider côté owner

Exécuter :

```text
composer dump-autoload -o
php -l Opus/Console/OpusConsoleApplication.php
php -l Opus/Console/Application/ApplicationCommandDispatcher.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l'identifiant d'application, l'adresse et le port comme arguments variables. Réserver `opus:dev-server` au développement.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
